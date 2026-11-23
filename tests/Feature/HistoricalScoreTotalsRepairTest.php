<?php

namespace Tests\Feature;

use App\Exports\EventRawScoresExport;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;
use RuntimeException;
use Tests\TestCase;

class HistoricalScoreTotalsRepairTest extends TestCase
{
    private const CASES = [
        [
            'name' => 'Uwais', 'surname' => 'Haffejee',
            'event' => 'Grading - MRI - 18 September 2025', 'date' => '2025-09-18',
            'old_total' => 275, 'total' => 321, 'required' => 343, 'grade' => 'JS1', 'target' => 'JS2',
            'rounds' => [46, 40, 41, 35, 29, 36, 24, 30, 40],
        ],
        [
            'name' => 'Muhammed Ihsaan', 'surname' => 'Casoojee',
            'event' => 'MRI Grading 2025/11/05', 'date' => '2025-11-05',
            'old_total' => 425, 'total' => 480, 'required' => null, 'grade' => 'JNG', 'target' => '0',
            'rounds' => [53, 55, 55, 57, 53, 56, 47, 56, 48],
        ],
        [
            'name' => 'Azhar', 'surname' => 'Hadjee',
            'event' => 'Male Bidaayah 10m grading', 'date' => '2025-11-15',
            'old_total' => 262, 'total' => 299, 'required' => 368, 'grade' => 'AS1', 'target' => 'AS2',
            'rounds' => [22, 31, 39, 39, 40, 37, 34, 24, 33],
        ],
        [
            'name' => 'Aneesa', 'surname' => 'Bodiat',
            'event' => 'Ladies Bidaayah 1 grading - April 2026', 'date' => '2026-04-25',
            'old_total' => 387, 'total' => 430, 'required' => 368, 'grade' => 'ANG', 'target' => 'AS1',
            'rounds' => [43, 42, 48, 46, 52, 51, 51, 52, 45],
        ],
        [
            'name' => 'Azhar', 'surname' => 'Hadjee',
            'event' => 'Mens Bidayah Grading 10m 9am 13 June 2025', 'date' => '2026-06-13',
            'old_total' => 262, 'total' => 302, 'required' => null, 'grade' => null, 'target' => '0',
            'rounds' => [28, 30, 49, 14, 37, 40, 48, 24, 32],
        ],
    ];

    private array $entries = [];

    protected function setUp(): void
    {
        parent::setUp();
        $this->app->instance('env', 'testing');
        config([
            'database.default' => 'historical_scores_test',
            'database.connections.historical_scores_test' => [
                'driver' => 'sqlite', 'database' => ':memory:', 'prefix' => '',
                'foreign_key_constraints' => true,
            ],
        ]);
        DB::connection()->getPdo()->sqliteCreateFunction('CONCAT', fn (...$values) => implode('', $values));
        Mail::fake();
        foreach ([
            '2025_01_20_094837_create_archers_table.php',
            '2025_01_20_103919_create_archergradings_table.php',
            '2025_02_19_131213_create_eventcategories_table.php',
            '2025_02_20_160159_create_events_table.php',
            '2025_02_20_160206_create_eventscores_table.php',
            '2025_03_25_121405_create_scorecards_table.php',
            '2025_04_10_083917_create_grading_cards_table.php',
            '2026_09_21_090100_add_certificate_email_tracking_to_eventscores_table.php',
        ] as $migration) {
            (require database_path('migrations/' . $migration))->up();
        }
        Schema::table('archergradings', fn (Blueprint $table) => $table->string('event')->nullable());
        DB::table('eventcategories')->insert(['id' => 1, 'name' => 'Grading', 'rounds' => 9, 'arrows' => 6]);
        foreach (self::CASES as $case) {
            $this->entries[] = $this->seedEntry($case);
        }
    }

    public function test_repairs_all_five_totals_rounds_and_exports_without_changing_other_data(): void
    {
        $this->seedEntry(array_replace(self::CASES[0], ['event' => 'Unrelated grading', 'date' => '2025-09-19']));
        $this->seedEntry(array_replace(self::CASES[0], ['name' => 'Another', 'surname' => 'Archer']), $this->entries[0]['event_id']);
        $this->seedEntry(array_replace(self::CASES[0], [
            'name' => 'Asma', 'surname' => 'Bhikhoo', 'event' => 'Bhikhoo', 'date' => '2026-11-22',
        ]));
        $before = $this->protectedData();

        $this->migration()->up();

        $this->assertSame($before, $this->protectedData());
        foreach ($this->entries as $entry) {
            $score = DB::table('eventscores')->find($entry['score_id']);
            $this->assertSame($entry['total'], (int) $score->totalScore);
            $this->assertSame((int) round($entry['total'] / 9), (int) $score->thumbring);
            $cumulative = 0;
            foreach ($entry['rounds'] as $index => $roundTotal) {
                $round = $index + 1;
                $cumulative += $roundTotal;
                $arrows = DB::table('scorecards')->where('event_id', $entry['event_id'])
                    ->where('archer_id', $entry['archer_id'])->where('round', $round)->get();
                $this->assertCount(6, $arrows);
                foreach ($arrows as $arrow) {
                    $this->assertSame($roundTotal, (int) $arrow->roundtotal);
                    $this->assertSame($cumulative, (int) $arrow->cumtotal);
                    $this->assertSame($entry['total'], (int) $arrow->total);
                    $this->assertSame((int) round($cumulative / $round), (int) $arrow->currentPR);
                    if ($entry['required'] !== null) {
                        $this->assertSame((int) round(($entry['required'] - $cumulative) / max(1, 9 - $round)), (int) $arrow->requiredPR);
                    }
                }
            }
            $row = collect((new EventRawScoresExport($entry['event_id']))->array())
                ->first(fn ($row) => $row[1] === $entry['name'] . ' ' . $entry['surname']);
            $this->assertSame($entry['total'], end($row));
        }
        Mail::assertNothingSent();
        Mail::assertNothingQueued();
    }

    public function test_missing_grading_targets_and_required_rates_are_not_invented(): void
    {
        $this->migration()->up();
        foreach ([$this->entries[1], $this->entries[4]] as $entry) {
            $grading = DB::table('archergradings')->where('event', $entry['event_id'])
                ->where('archer_id', $entry['archer_id'])->first();
            $this->assertNull($grading->totalScore);
            $this->assertSame('0', $grading->gradingfor);
            $this->assertSame(27, (int) DB::table('eventscores')->find($entry['score_id'])->arrowinhand);
            $this->assertSame([27], DB::table('scorecards')->where('event_id', $entry['event_id'])
                ->where('archer_id', $entry['archer_id'])->distinct()->pluck('requiredPR')->all());
        }
    }

    public function test_repair_is_idempotent_and_rollback_does_not_restore_wrong_totals(): void
    {
        $this->migration()->up();
        $afterFirstRun = $this->allData();
        $this->migration()->up();
        $this->migration()->down();
        $this->assertSame($afterFirstRun, $this->allData());
    }

    public function test_absent_matching_events_are_ignored(): void
    {
        DB::table('events')->update(['name' => 'Not the audited event']);
        $before = $this->allData();
        $this->migration()->up();
        $this->assertSame($before, $this->allData());
    }

    public function test_duplicate_rounds_are_rejected_without_any_repairs(): void
    {
        $entry = $this->entries[0];
        $arrows = DB::table('scorecards')->where('event_id', $entry['event_id'])->where('round', 1)->get();
        foreach ($arrows as $arrow) {
            DB::table('scorecards')->insert(Arr::except((array) $arrow, ['id']));
        }
        $this->assertRepairRefusedWithoutChanges();
    }

    public function test_missing_round_is_rejected_without_any_repairs(): void
    {
        DB::table('scorecards')->where('event_id', $this->entries[0]['event_id'])->where('round', 9)->delete();
        $this->assertRepairRefusedWithoutChanges();
    }

    public function test_changed_round_totals_are_rejected_even_when_the_grand_total_is_unchanged(): void
    {
        $event = $this->entries[0]['event_id'];
        $first = DB::table('scorecards')->where('event_id', $event)->where('round', 1)->first();
        $second = DB::table('scorecards')->where('event_id', $event)->where('round', 2)->orderByDesc('id')->first();
        DB::table('scorecards')->where('id', $first->id)->update(['arrow' => $first->arrow - 1]);
        DB::table('scorecards')->where('id', $second->id)->update(['arrow' => $second->arrow + 1]);
        $this->assertSame(321, (int) DB::table('scorecards')->where('event_id', $event)->sum('arrow'));
        $this->assertRepairRefusedWithoutChanges();
    }

    public function test_invalid_later_record_rolls_back_the_earlier_repairs(): void
    {
        $arrow = DB::table('scorecards')->where('event_id', $this->entries[4]['event_id'])->first();
        DB::table('scorecards')->where('id', $arrow->id)->update(['arrow' => $arrow->arrow - 1]);
        $this->assertRepairRefusedWithoutChanges();
    }

    public function test_ambiguous_archer_names_are_not_repaired(): void
    {
        DB::table('archers')->insert(['name' => 'Uwais', 'surname' => 'Haffejee']);
        $this->migration()->up();
        $this->assertSame(275, (int) DB::table('eventscores')->find($this->entries[0]['score_id'])->totalScore);
        foreach (array_slice($this->entries, 1) as $entry) {
            $this->assertSame($entry['total'], (int) DB::table('eventscores')->find($entry['score_id'])->totalScore);
        }
    }

    private function seedEntry(array $case, ?int $eventId = null): array
    {
        $archerId = DB::table('archers')->where('name', $case['name'])->where('surname', $case['surname'])->value('id');
        $archerId ??= DB::table('archers')->insertGetId([
            'name' => $case['name'], 'surname' => $case['surname'],
            'currentGradingDominant' => 'AS2', 'currentGradingWeak' => 'ANG',
        ]);
        $eventId ??= DB::table('events')->insertGetId(['name' => $case['event'], 'doe' => $case['date'], 'cat' => 1]);
        $gradingId = DB::table('archergradings')->insertGetId([
            'event' => $eventId, 'archer_id' => $archerId, 'date' => $case['date'],
            'currentGrading' => $case['grade'], 'gradingfor' => $case['target'], 'totalScore' => $case['required'],
        ]);
        $scoreId = DB::table('eventscores')->insertGetId([
            'event_id' => $eventId, 'archer_id' => $archerId, 'totalScore' => $case['old_total'],
            'status' => '1', 'timed' => 9, 'thumbring' => 1, 'arrowinhand' => 27, 'bowUsed' => 5,
            'certificate_email_status' => 'sent', 'certificate_email_address' => 'archer@example.com',
            'certificate_email_attempts' => 2, 'certificate_email_sent_at' => '2026-11-22 12:00:00',
            'created_at' => '2026-11-22 10:00:00', 'updated_at' => '2026-11-22 12:00:00',
        ]);
        foreach ($case['rounds'] as $index => $roundTotal) {
            $remaining = $roundTotal;
            for ($arrow = 0; $arrow < 6; $arrow++) {
                $value = min(10, $remaining);
                $remaining -= $value;
                DB::table('scorecards')->insert([
                    'event_id' => $eventId, 'archer_id' => $archerId, 'archergrading_id' => $gradingId,
                    'round' => $index + 1, 'arrow' => $value, 'roundtotal' => 0, 'cumtotal' => 0,
                    'total' => $case['old_total'], 'currentPR' => 1, 'requiredPR' => 27,
                    'time' => '60', 'isX' => 0, 'created_at' => '2026-11-22 10:00:00', 'updated_at' => '2026-11-22 12:00:00',
                ]);
            }
        }

        return $case + ['archer_id' => $archerId, 'event_id' => $eventId, 'score_id' => $scoreId];
    }

    private function allData(): array
    {
        $data = [];
        foreach (['archers', 'archergradings', 'events', 'eventscores', 'scorecards'] as $table) {
            $data[$table] = DB::table($table)->orderBy('id')->get()->map(fn ($row) => (array) $row)->all();
        }
        return $data;
    }

    private function protectedData(): array
    {
        $data = $this->allData();
        foreach ($this->entries as $entry) {
            foreach ($data['eventscores'] as &$row) {
                if ($row['id'] === $entry['score_id']) {
                    $row = Arr::except($row, array_merge(['totalScore', 'thumbring'], $entry['required'] === null ? [] : ['arrowinhand']));
                }
            }
            unset($row);
            foreach ($data['scorecards'] as &$row) {
                if ((int) $row['event_id'] === $entry['event_id'] && (int) $row['archer_id'] === $entry['archer_id']) {
                    $row = Arr::except($row, array_merge(['roundtotal', 'cumtotal', 'total', 'currentPR'], $entry['required'] === null ? [] : ['requiredPR']));
                }
            }
            unset($row);
        }
        return $data;
    }

    private function assertRepairRefusedWithoutChanges(): void
    {
        $before = $this->allData();
        try {
            $this->migration()->up();
            $this->fail('Changed scores should require another review.');
        } catch (RuntimeException $exception) {
            $this->assertStringContainsString('have changed', $exception->getMessage());
        }
        $this->assertSame($before, $this->allData());
    }

    private function migration()
    {
        return require database_path('migrations/2026_11_23_090100_correct_selected_historical_score_totals.php');
    }
}
