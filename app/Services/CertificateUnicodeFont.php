<?php

namespace App\Services;

use FontLib\Font;
use RuntimeException;

class CertificateUnicodeFont
{
    private array $characters;
    private array $glyphs = [];
    private array $widths = [];
    private array $bounds;
    private int $ascent;
    private int $descent;
    private string $fontData;
    private string $encodedText = '';
    private int $textWidth = 0;

    public function __construct(string $text)
    {
        $fontPath = dirname(__DIR__, 2) . '/vendor/dompdf/dompdf/lib/fonts/DejaVuSans.ttf';
        $font = Font::load($fontPath);

        if ($font === null) {
            throw new RuntimeException('The certificate Unicode font could not be loaded.');
        }

        try {
            $characterMap = [];
            foreach ($font->getData('cmap', 'subtables') as $subtable) {
                if ($subtable['platformID'] === 0
                    || ($subtable['platformID'] === 3 && in_array($subtable['platformSpecificID'], [1, 10], true))) {
                    $characterMap += $subtable['glyphIndexArray'];
                }
            }

            $head = $font->getData('head');
            $hhea = $font->getData('hhea');
            $metrics = $font->getData('hmtx');
            $scale = 1000 / $head['unitsPerEm'];
            $this->bounds = array_map(fn ($key) => (int) round($head[$key] * $scale), ['xMin', 'yMin', 'xMax', 'yMax']);
            $this->ascent = (int) round($hhea['ascent'] * $scale);
            $this->descent = (int) round($hhea['descent'] * $scale);
            $this->characters = array_values(array_unique(mb_str_split($text, 1, 'UTF-8')));
            $cids = [];

            foreach ($this->characters as $index => $character) {
                $codePoint = mb_ord($character, 'UTF-8');
                $glyph = $characterMap[$codePoint] ?? 0;
                if ($glyph === 0) {
                    throw new RuntimeException(sprintf('The certificate font does not support character U+%04X.', $codePoint));
                }
                $this->glyphs[] = $glyph;
                $this->widths[] = (int) round($metrics[$glyph][0] * $scale);
                $cids[$character] = $index + 1;
            }

            foreach (mb_str_split($text, 1, 'UTF-8') as $character) {
                $cid = $cids[$character];
                $this->encodedText .= sprintf('%04X', $cid);
                $this->textWidth += $this->widths[$cid - 1];
            }
        } finally {
            $font->close();
        }

        $fontData = file_get_contents($fontPath);
        if ($fontData === false) {
            throw new RuntimeException('The certificate Unicode font could not be read.');
        }
        $this->fontData = $fontData;
    }

    public function encodedText(): string
    {
        return '<' . $this->encodedText . '>';
    }

    public function textWidth(float $fontSize): float
    {
        return $this->textWidth * $fontSize / 1000;
    }

    public function objects(int $firstObjectId): array
    {
        $cidFontId = $firstObjectId + 1;
        $descriptorId = $firstObjectId + 2;
        $fontFileId = $firstObjectId + 3;
        $toUnicodeId = $firstObjectId + 4;
        $glyphMapId = $firstObjectId + 5;
        $glyphMap = pack('n*', 0, ...$this->glyphs);
        $mapping = [];
        foreach ($this->characters as $index => $character) {
            $mapping[] = sprintf('<%04X> <%s>', $index + 1, strtoupper(bin2hex(mb_convert_encoding($character, 'UTF-16BE', 'UTF-8'))));
        }
        $cmap = "/CIDInit /ProcSet findresource begin\n12 dict begin\nbegincmap\n"
            . "/CIDSystemInfo << /Registry (Adobe) /Ordering (UCS) /Supplement 0 >> def\n"
            . "/CMapName /CertificateUnicode def\n/CMapType 2 def\n"
            . "1 begincodespacerange\n<0000> <FFFF>\nendcodespacerange\n";
        foreach (array_chunk($mapping, 100) as $chunk) {
            $cmap .= count($chunk) . " beginbfchar\n" . implode("\n", $chunk) . "\nendbfchar\n";
        }
        $cmap .= "endcmap\nCMapName currentdict /CMap defineresource pop\nend\nend\n";

        return [
            $firstObjectId => "<< /Type /Font /Subtype /Type0 /BaseFont /DejaVuSans /Encoding /Identity-H /DescendantFonts [{$cidFontId} 0 R] /ToUnicode {$toUnicodeId} 0 R >>",
            $cidFontId => "<< /Type /Font /Subtype /CIDFontType2 /BaseFont /DejaVuSans /CIDSystemInfo << /Registry (Adobe) /Ordering (Identity) /Supplement 0 >> /FontDescriptor {$descriptorId} 0 R /CIDToGIDMap {$glyphMapId} 0 R /W [1 [" . implode(' ', $this->widths) . ']] >>',
            $descriptorId => '<< /Type /FontDescriptor /FontName /DejaVuSans /Flags 32 /FontBBox [' . implode(' ', $this->bounds)
                . "] /ItalicAngle 0 /Ascent {$this->ascent} /Descent {$this->descent} /CapHeight {$this->ascent} /StemV 80 /FontFile2 {$fontFileId} 0 R >>",
            $fontFileId => $this->stream($this->fontData, '/Length1 ' . strlen($this->fontData)),
            $toUnicodeId => $this->stream($cmap),
            $glyphMapId => $this->stream($glyphMap),
        ];
    }

    private function stream(string $data, string $extra = ''): string
    {
        $compressed = gzcompress($data);
        if ($compressed === false) {
            throw new RuntimeException('The certificate Unicode font could not be compressed.');
        }

        return '<< /Filter /FlateDecode /Length ' . strlen($compressed) . ' ' . $extra . " >>\nstream\n"
            . $compressed . "\nendstream";
    }
}
