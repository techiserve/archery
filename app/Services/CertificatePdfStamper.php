<?php

namespace App\Services;

use RuntimeException;

class CertificatePdfStamper
{
    private const PAGE_WIDTH = 841.89;
    private const PAGE_HEIGHT = 595.276;
    private const POINTS_PER_MM = 72 / 25.4;

    public function stamp(string $templatePath, array $data): string
    {
        $basePdf = file_get_contents($templatePath);

        if ($basePdf === false) {
            throw new RuntimeException('Certificate template could not be read.');
        }

        $page = $this->findFirstPageObject($basePdf);
        $startXref = $this->findLastStartXref($basePdf);
        $trailer = $this->findLastTrailer($basePdf);
        $size = $this->extractRequiredInteger($trailer, 'Size');
        $root = $this->extractRequiredReference($trailer, 'Root');
        $info = $this->extractOptionalReference($trailer, 'Info');
        $id = $this->extractOptionalId($trailer);

        $streamObjectId = $size;
        $scriptFontObjectId = $streamObjectId + 1;
        $newSize = $scriptFontObjectId + 1;
        $stream = $this->buildOverlayStream($data);
        $updatedPage = $this->appendContentsReference($page['content'], $streamObjectId);
        $updatedPage = $this->appendFontResource($updatedPage, 'FScript', $scriptFontObjectId);

        $output = $basePdf;

        if (!str_ends_with($output, "\n")) {
            $output .= "\n";
        }

        $offsets = [];

        $offsets[$page['number']] = strlen($output);
        $output .= $page['number'] . " 0 obj\n" . $updatedPage . "\nendobj\n";

        $offsets[$streamObjectId] = strlen($output);
        $output .= $streamObjectId . " 0 obj\n"
            . '<< /Length ' . strlen($stream) . " >>\n"
            . "stream\n"
            . $stream
            . "endstream\n"
            . "endobj\n";

        $offsets[$scriptFontObjectId] = strlen($output);
        $output .= $scriptFontObjectId . " 0 obj\n"
            . "<< /Type /Font /Subtype /Type1 /BaseFont /Times-Italic /Encoding /WinAnsiEncoding >>\n"
            . "endobj\n";

        $xrefOffset = strlen($output);
        ksort($offsets);

        $output .= "xref\n";

        foreach ($offsets as $objectNumber => $offset) {
            $output .= $objectNumber . " 1\n";
            $output .= sprintf('%010d 00000 n ', $offset) . "\n";
        }

        $output .= "trailer\n<< /Size {$newSize} /Root {$root}";

        if ($info !== null) {
            $output .= " /Info {$info}";
        }

        $output .= " /Prev {$startXref}";

        if ($id !== null) {
            $output .= " /ID {$id}";
        }

        $output .= " >>\nstartxref\n{$xrefOffset}\n%%EOF\n";

        return $output;
    }

    private function findFirstPageObject(string $pdf): array
    {
        preg_match_all('/(\d+)\s+0\s+obj\s*(.*?)\s*endobj/s', $pdf, $matches, PREG_SET_ORDER);

        foreach ($matches as $match) {
            if (preg_match('/\/Type\s*\/Page\b/', $match[2])) {
                return [
                    'number' => (int) $match[1],
                    'content' => trim($match[2]),
                ];
            }
        }

        throw new RuntimeException('Certificate template page object was not found.');
    }

    private function appendContentsReference(string $pageObject, int $streamObjectId): string
    {
        if (preg_match('/\/Contents\s+(\d+)\s+(\d+)\s+R/', $pageObject, $match)) {
            return preg_replace(
                '/\/Contents\s+\d+\s+\d+\s+R/',
                '/Contents[' . $match[1] . ' ' . $match[2] . ' R ' . $streamObjectId . ' 0 R]',
                $pageObject,
                1
            );
        }

        if (preg_match('/\/Contents\s*\[(.*?)\]/s', $pageObject, $match)) {
            return preg_replace(
                '/\/Contents\s*\[(.*?)\]/s',
                '/Contents[' . trim($match[1]) . ' ' . $streamObjectId . ' 0 R]',
                $pageObject,
                1
            );
        }

        throw new RuntimeException('Certificate template page contents were not found.');
    }

    private function appendFontResource(string $pageObject, string $fontResourceName, int $fontObjectId): string
    {
        if (preg_match('/\/Font\s*<<[^>]*\/' . preg_quote($fontResourceName, '/') . '\s+\d+\s+\d+\s+R/s', $pageObject)) {
            return $pageObject;
        }

        if (preg_match('/\/Font\s*<<(.*?)>>/s', $pageObject)) {
            return preg_replace(
                '/\/Font\s*<<(.*?)>>/s',
                '/Font<<$1 /' . $fontResourceName . ' ' . $fontObjectId . ' 0 R>>',
                $pageObject,
                1
            );
        }

        throw new RuntimeException('Certificate template page font resources were not found.');
    }

    private function buildOverlayStream(array $data): string
    {
        $name = (string) ($data['name'] ?? '');
        $grading = (string) ($data['grading'] ?? '');
        $score = (string) ($data['score'] ?? '');
        $date = (string) ($data['certificateDate'] ?? '');

        $nameFontSize = strlen($name) > 32 ? 16.4 : (strlen($name) > 24 ? 18.1 : 20.1);
        $smallFontSize = 14.7;
        $dateFontSize = 11.9;
        $signatureFontSize = 13.5;

        $commands = ["q\n"];
        $commands[] = $this->drawCenteredText($name, $nameFontSize, 421.0, $this->baselineFromTopMm(103.5, 7.1));
        $commands[] = $this->drawInlineText($grading, $smallFontSize, $this->points(175), $this->baselineFromTopMm(132.7, 5.2), 56);
        $commands[] = $this->drawInlineText($score, $smallFontSize, $this->points(175), $this->baselineFromTopMm(143.3, 5.2), 48);
        $commands[] = $this->drawSignatureInlineText('A.Adamjee', $signatureFontSize, $this->points(20), $this->baselineFromTopMm(178.8, 4.2), 55, true);
        $commands[] = $this->drawSignatureInlineText('I. Akoob', $signatureFontSize, $this->points(88), $this->baselineFromTopMm(178.8, 4.2), 55, true);
        $commands[] = $this->drawInlineText($date, $dateFontSize, $this->points(159), $this->baselineFromTopMm(178.8, 4.2), 52, true);
        $commands[] = "Q\n";

        return implode('', $commands);
    }

    private function drawCenteredText(string $text, float $fontSize, float $centerX, float $baselineY): string
    {
        $width = $this->estimatedTextWidth($text, $fontSize);
        $x = $centerX - ($width / 2);

        return $this->textCommand($text, $fontSize, $x, $baselineY);
    }

    private function drawInlineText(string $text, float $fontSize, float $x, float $baselineY, float $widthMm, bool $center = false): string
    {
        $width = $this->points($widthMm);
        $height = $fontSize * 1.15;
        $textWidth = $this->estimatedTextWidth($text, $fontSize);
        $textX = $center ? $x + (($width - $textWidth) / 2) : $x + $this->points(1.5);
        $rectY = $baselineY - ($fontSize * 0.28);

        return "1 1 1 rg\n"
            . sprintf('%.3F %.3F %.3F %.3F re f', $x, $rectY, $width, $height) . "\n"
            . $this->textCommand($text, $fontSize, $textX, $baselineY);
    }

    private function drawSignatureInlineText(string $text, float $fontSize, float $x, float $baselineY, float $widthMm, bool $center = false): string
    {
        $width = $this->points($widthMm);
        $textWidth = $this->estimatedSignatureTextWidth($text, $fontSize);
        $textX = $center ? $x + (($width - $textWidth) / 2) : $x + $this->points(1.5);

        return $this->signatureTextCommand($text, $fontSize, $textX, $baselineY);
    }

    private function textCommand(string $text, float $fontSize, float $x, float $baselineY): string
    {
        return "0.024 0.114 0.239 rg\n"
            . "BT\n"
            . sprintf('/TT0 %.3F Tf', $fontSize) . "\n"
            . sprintf('1 0 0 1 %.3F %.3F Tm', $x, $baselineY) . "\n"
            . '(' . $this->escapePdfString($text) . ") Tj\n"
            . "ET\n";
    }

    private function signatureTextCommand(string $text, float $fontSize, float $x, float $baselineY): string
    {
        return "0.024 0.114 0.239 rg\n"
            . "BT\n"
            . sprintf('/FScript %.3F Tf', $fontSize) . "\n"
            . sprintf('1 0 0 1 %.3F %.3F Tm', $x, $baselineY) . "\n"
            . '(' . $this->escapePdfString($text) . ") Tj\n"
            . "ET\n";
    }

    private function baselineFromTopMm(float $topMm, float $fontMm): float
    {
        return self::PAGE_HEIGHT - $this->points($topMm + ($fontMm * 0.78));
    }

    private function estimatedTextWidth(string $text, float $fontSize): float
    {
        return strlen($text) * $fontSize * 0.54;
    }

    private function estimatedSignatureTextWidth(string $text, float $fontSize): float
    {
        return strlen($text) * $fontSize * 0.45;
    }

    private function points(float $millimetres): float
    {
        return $millimetres * self::POINTS_PER_MM;
    }

    private function escapePdfString(string $text): string
    {
        return str_replace(
            ["\\", '(', ')', "\r", "\n"],
            ["\\\\", "\\(", "\\)", '', ' '],
            $text
        );
    }

    private function findLastStartXref(string $pdf): int
    {
        preg_match_all('/startxref\s+(\d+)/', $pdf, $matches);
        $last = end($matches[1]);

        if ($last === false) {
            throw new RuntimeException('Certificate template startxref was not found.');
        }

        return (int) $last;
    }

    private function findLastTrailer(string $pdf): string
    {
        preg_match_all('/trailer\s*<<(.*?)>>\s*startxref/s', $pdf, $matches);
        $last = end($matches[1]);

        if ($last === false) {
            throw new RuntimeException('Certificate template trailer was not found.');
        }

        return $last;
    }

    private function extractRequiredInteger(string $trailer, string $key): int
    {
        if (!preg_match('/\/' . preg_quote($key, '/') . '\s+(\d+)/', $trailer, $match)) {
            throw new RuntimeException("Certificate template trailer is missing {$key}.");
        }

        return (int) $match[1];
    }

    private function extractRequiredReference(string $trailer, string $key): string
    {
        if (!preg_match('/\/' . preg_quote($key, '/') . '\s+(\d+\s+\d+\s+R)/', $trailer, $match)) {
            throw new RuntimeException("Certificate template trailer is missing {$key}.");
        }

        return $match[1];
    }

    private function extractOptionalReference(string $trailer, string $key): ?string
    {
        if (!preg_match('/\/' . preg_quote($key, '/') . '\s+(\d+\s+\d+\s+R)/', $trailer, $match)) {
            return null;
        }

        return $match[1];
    }

    private function extractOptionalId(string $trailer): ?string
    {
        if (!preg_match('/\/ID\s*(\[[^\]]+\])/', $trailer, $match)) {
            return null;
        }

        return $match[1];
    }
}
