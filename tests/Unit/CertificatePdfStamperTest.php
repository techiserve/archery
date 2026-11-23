<?php

namespace Tests\Unit;

use App\Services\CertificatePdfStamper;
use Normalizer;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use RuntimeException;

class CertificatePdfStamperTest extends TestCase
{
    #[DataProvider('names')]
    public function test_special_characters_have_embedded_glyphs_and_exact_unicode_mappings(string $name): void
    {
        $pdf = $this->stamp($name);
        $objects = $this->incrementalObjects($pdf);
        $font = $this->objectContaining($objects, '/Subtype /Type0');
        $this->assertStringContainsString('/Encoding /Identity-H', $font);
        preg_match('/\/ToUnicode (\d+) 0 R/', $font, $match);
        $cmap = $this->compressedStream($objects[(int) $match[1]]);
        $normalized = Normalizer::normalize($name, Normalizer::FORM_C);
        foreach (array_unique(mb_str_split($normalized, 1, 'UTF-8')) as $character) {
            $hex = strtoupper(bin2hex(mb_convert_encoding($character, 'UTF-16BE', 'UTF-8')));
            $this->assertStringContainsString('<' . $hex . '>', $cmap);
        }
        preg_match('/\/FontFile2 (\d+) 0 R/', $this->objectContaining($objects, '/Type /FontDescriptor'), $match);
        $fontData = $this->compressedStream($objects[(int) $match[1]]);
        $this->assertStringStartsWith("\x00\x01\x00\x00", $fontData);
        $this->assertGreaterThan(100000, strlen($fontData));
        $overlay = $this->overlay($objects);
        $this->assertStringContainsString('/FUnicode ', $overlay);
        $this->assertMatchesRegularExpression('/<[0-9A-F]+> Tj/', $overlay);
        $this->assertStringNotContainsString('(' . $name . ') Tj', $overlay);
        $this->assertStringStartsWith(file_get_contents($this->template()), $pdf);
    }

    public static function names(): array
    {
        return [
            'acute accent' => ["\u{00C1}yesha Bham"],
            'Latin accents' => ["Zo\u{00EB} Fran\u{00E7}ois Jos\u{00E9} Mu\u{00F1}oz"],
            'extended Latin' => ["\u{0141}ukasz \u{015E}ahin \u{1E24}asan"],
            'curly apostrophe and dash' => ["O\u{2019}Connor \u{2013} D\u{2019}Amico & S\u{00F8}ren"],
            'Greek' => ["\u{0391}\u{03BB}\u{03AD}\u{03BE}\u{03B1}\u{03BD}\u{03B4}\u{03C1}\u{03BF}\u{03C2}"],
            'Cyrillic' => ["\u{0410}\u{043B}\u{0435}\u{043A}\u{0441}\u{0435}\u{0439}"],
            'combining accent' => ["A\u{0301}yesha Bham"],
            'escaped PDF characters' => ["\u{00C1}yesha (Bham) \\ Test"],
            'supplementary character' => ["\u{00C1}yesha \u{1F600}"],
        ];
    }

    public function test_plain_names_keep_the_existing_font_and_all_other_text_and_positions_stay_unchanged(): void
    {
        $stamper = new CertificatePdfStamper;
        $plain = $stamper->stamp($this->template(), $this->data('Ayesha Bham'));
        $unicode = $stamper->stamp($this->template(), $this->data("\u{00C1}yesha Bham"));
        $plainOverlay = $this->overlay($this->incrementalObjects($plain));
        $unicodeOverlay = $this->overlay($this->incrementalObjects($unicode));
        $this->assertStringNotContainsString('/FUnicode', $plain);
        $this->assertStringContainsString('/TT0 20.100 Tf', $plainOverlay);
        $this->assertStringContainsString('(Ayesha Bham) Tj', $plainOverlay);
        $this->assertSame(explode("ET\n", $plainOverlay, 2)[1], explode("ET\n", $unicodeOverlay, 2)[1]);
        preg_match('/1 0 0 1 [\d.]+ ([\d.]+) Tm/', $plainOverlay, $plainPosition);
        preg_match('/1 0 0 1 [\d.]+ ([\d.]+) Tm/', $unicodeOverlay, $unicodePosition);
        $this->assertSame($plainPosition[1], $unicodePosition[1]);
        $this->assertSame($plain, $stamper->stamp($this->template(), $this->data('Ayesha Bham')));
    }

    public function test_precomposed_and_combining_accents_generate_the_same_certificate(): void
    {
        $this->assertSame($this->stamp("\u{00C1}yesha Bham"), $this->stamp("A\u{0301}yesha Bham"));
    }

    #[DataProvider('nameLengths')]
    public function test_font_size_uses_character_count_not_utf8_byte_count(int $length, string $expectedSize): void
    {
        $overlay = $this->overlay($this->incrementalObjects($this->stamp(str_repeat("\u{00E9}", $length))));
        $this->assertStringContainsString('/FUnicode ' . $expectedSize . ' Tf', $overlay);
    }

    public static function nameLengths(): array
    {
        return [[24, '20.100'], [25, '18.100'], [32, '18.100'], [33, '16.400']];
    }

    public function test_invalid_utf8_is_rejected_instead_of_printing_corrupt_characters(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('must be valid UTF-8');
        $this->stamp("\xC3yesha");
    }

    public function test_unsupported_glyph_is_reported_instead_of_silently_replaced(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('does not support character U+10FFFF');
        $this->stamp("Name \u{10FFFF}");
    }

    private function template(): string
    {
        return dirname(__DIR__, 2) . '/resources/certificates/qf-archery-certificate-detailed-template.pdf';
    }

    private function data(string $name): array
    {
        return ['name' => $name, 'grading' => 'AS1', 'score' => 412, 'certificateDate' => '22 Nov 2026'];
    }

    private function stamp(string $name): string
    {
        return (new CertificatePdfStamper)->stamp($this->template(), $this->data($name));
    }

    private function incrementalObjects(string $pdf): array
    {
        preg_match('/startxref\s+(\d+)\s+%%EOF\s*$/', $pdf, $match);
        $xrefOffset = (int) $match[1];
        preg_match_all('/(\d+) 1\n(\d{10}) 00000 n /', substr($pdf, $xrefOffset), $matches, PREG_SET_ORDER);
        $offsets = [];
        foreach ($matches as $entry) {
            $offsets[(int) $entry[1]] = (int) $entry[2];
        }
        asort($offsets);
        $ids = array_keys($offsets);
        $objects = [];
        foreach ($ids as $index => $id) {
            $end = isset($ids[$index + 1]) ? $offsets[$ids[$index + 1]] : $xrefOffset;
            $objects[$id] = substr($pdf, $offsets[$id], $end - $offsets[$id]);
            $this->assertStringStartsWith($id . " 0 obj\n", $objects[$id]);
        }
        return $objects;
    }

    private function objectContaining(array $objects, string $needle): string
    {
        foreach ($objects as $object) {
            if (str_contains($object, $needle)) {
                return $object;
            }
        }
        $this->fail('PDF object not found: ' . $needle);
    }

    private function compressedStream(string $object): string
    {
        preg_match('/\/Length (\d+)/', $object, $match);
        $start = strpos($object, "stream\n") + strlen("stream\n");
        $data = gzuncompress(substr($object, $start, (int) $match[1]));
        $this->assertNotFalse($data);
        return $data;
    }

    private function overlay(array $objects): string
    {
        $object = $this->objectContaining($objects, "\nq\n");
        preg_match('/\/Length (\d+)/', $object, $match);
        $start = strpos($object, "stream\n") + strlen("stream\n");
        return substr($object, $start, (int) $match[1]);
    }
}
