<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    private const REPAIRS = [
        [
            'name' => 'Uwais', 'surname' => 'Haffejee',
            'event' => 'Grading - MRI - 18 September 2025', 'date' => '2025-09-18',
            'round_totals' => [46, 40, 41, 35, 29, 36, 24, 30, 40],
        ],
        [
            'name' => 'Muhammed Ihsaan', 'surname' => 'Casoojee',
            'event' => 'MRI Grading 2025/11/05', 'date' => '2025-11-05',
            'round_totals' => [53, 55, 55, 57, 53, 56, 47, 56, 48],
        ],
        [
            'name' => 'Azhar', 'surname' => 'Hadjee',
            'event' => 'Male Bidaayah 10m grading', 'date' => '2025-11-15',
            'round_totals' => [22, 31, 39, 39, 40, 37, 34, 24, 33],
        ],
        [
            'name' => 'Aneesa', 'surname' => 'Bodiat',
            'event' => 'Ladies Bidaayah 1 grading - April 2026', 'date' => '2026-04-25',
            'round_totals' => [43, 42, 48, 46, 52, 51, 51, 52, 45],
        ],
        [
            'name' => 'Azhar', 'surname' => 'Hadjee',
            'event' => 'Mens Bidayah Grading 10m 9am 13 June 2025', 'date' => '2026-06-13',
            'round_totals' => [28, 30, 49, 14, 37, 40, 48, 24, 32],
        ],
    ];

    public function up(): void
    {
        DB::transaction(function () {
            foreach (self::REPAIRS as $repair) {
                $this->repair($repair);
            }
        });
    }

    private function repair(array $repair): void
    {
        $archers = DB::table('archers')->where('name', $repair['name'])
            ->where('surname', $repair['surname'])->pluck('id');
        $events = DB::table('events')->where('name', $repair['event'])
            ->where('doe', $repair['date'])->pluck('id');

        if ($archers->count() !== 1 || $events->count() !== 1) {
            return;
        }

        $archerId = $archers->first();
        $eventId = $events->first();
        $eventScores = DB::table('eventscores')->where('event_id', $eventId)
            ->where('archer_id', $archerId)->lockForUpdate()->get();

        if ($eventScores->isEmpty()) {
            return;
        }

        $rounds = DB::table('scorecards')->where('event_id', $eventId)->where('archer_id', $archerId)
            ->orderBy('round')->orderBy('id')->lockForUpdate()->get()->groupBy('round');

        // Only repair the audited, non-duplicated rounds; changed data needs another review.
        if ($eventScores->count() !== 1
            || $rounds->keys()->map(fn ($round) => (int) $round)->all() !== range(1, 9)
            || $rounds->contains(fn ($arrows) => $arrows->count() !== 6)
            || $rounds->map(fn ($arrows) => (int) $arrows->sum('arrow'))->values()->all() !== $repair['round_totals']) {
            throw new RuntimeException("The audited scores for {$repair['name']} {$repair['surname']} in {$repair['event']} have changed. Review before applying this repair.");
        }

        $grading = DB::table('archergradings')->where('event', $eventId)->where('archer_id', $archerId)->first();
        $requiredScore = is_numeric($grading?->totalScore) && (float) $grading->totalScore > 0
            ? (float) $grading->totalScore
            : null;
        $total = array_sum($repair['round_totals']);
        $cumulative = 0;

        foreach ($rounds as $round => $arrows) {
            $roundTotal = (int) $arrows->sum('arrow');
            $cumulative += $roundTotal;
            $currentPR = (int) round($cumulative / (int) $round);
            $updates = [
                'roundtotal' => $roundTotal,
                'cumtotal' => $cumulative,
                'total' => $total,
                'currentPR' => $currentPR,
            ];

            if ($requiredScore !== null) {
                $requiredPR = (int) round(($requiredScore - $cumulative) / max(1, 9 - (int) $round));
                $updates['requiredPR'] = $requiredPR;
            }

            DB::table('scorecards')->where('event_id', $eventId)->where('archer_id', $archerId)
                ->where('round', $round)->update($updates);
        }

        $updates = ['totalScore' => $total, 'thumbring' => $currentPR];
        if ($requiredScore !== null) {
            $updates['arrowinhand'] = $requiredPR;
        }
        DB::table('eventscores')->where('id', $eventScores->first()->id)->update($updates);
    }

    public function down(): void
    {
        // Keep corrected historical totals rather than restoring the undercounts.
    }
};
