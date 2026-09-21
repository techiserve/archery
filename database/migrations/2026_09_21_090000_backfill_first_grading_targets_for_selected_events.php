<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    private const EVENTS = [
        ['name' => 'Ladies Bidaayah 1 06/2026', 'doe' => '2026-06-13'],
        ['name' => 'Mens Bidayah Grading 5m 9am 13 June 2025', 'doe' => '2026-06-13'],
        ['name' => 'Ladies Bidaayah 1 grading - April 2026', 'doe' => '2026-04-25'],
    ];

    private const FIRST_GRADING_LEVELS = [
        'CNG' => 'CS1',
        'JNG' => 'JS1',
        'ANG' => 'AS1',
    ];

    public function up(): void
    {
        $gradingCategoryIds = DB::table('eventcategories')
            ->whereRaw('LOWER(TRIM(name)) = ?', ['grading'])
            ->pluck('id');

        if ($gradingCategoryIds->isEmpty()) {
            return;
        }

        foreach (self::EVENTS as $selectedEvent) {
            $eventIds = DB::table('events')
                ->where('name', $selectedEvent['name'])
                ->where('doe', $selectedEvent['doe'])
                ->whereIn('cat', $gradingCategoryIds)
                ->pluck('id');

            foreach ($eventIds as $eventId) {
                $gradings = DB::table('archergradings')
                    ->where('event', $eventId)
                    ->where(function ($query) {
                        $query->whereNull('gradingfor')
                            ->orWhere('gradingfor', '')
                            ->orWhere('gradingfor', '0');
                    })
                    ->get(['id', 'currentGrading']);

                foreach ($gradings as $grading) {
                    $currentLevel = strtoupper(trim((string) $grading->currentGrading));
                    $targetLevel = self::FIRST_GRADING_LEVELS[$currentLevel] ?? null;

                    if (!$targetLevel) {
                        continue;
                    }

                    $requiredScore = DB::table('grading_cards')
                        ->where('level', $targetLevel)
                        ->value('score');

                    if ($requiredScore === null) {
                        continue;
                    }

                    DB::table('archergradings')
                        ->where('id', $grading->id)
                        ->update([
                            'gradingfor' => $targetLevel,
                            'totalScore' => $requiredScore,
                        ]);
                }
            }
        }
    }

    public function down(): void
    {
        // Historical grading corrections are intentionally retained on rollback.
    }
};
