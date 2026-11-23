<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::transaction(function () {
            $archers = DB::table('archers')->where('name', 'Asma')->where('surname', 'Bhikhoo')->pluck('id');
            $events = DB::table('events')->where('name', 'Bhikhoo')->where('doe', '2026-11-22')->pluck('id');

            if ($archers->count() !== 1 || $events->count() !== 1) {
                return;
            }

            $archerId = $archers->first();
            $eventId = $events->first();
            $eventScore = DB::table('eventscores')->where('event_id', $eventId)
                ->where('archer_id', $archerId)->lockForUpdate()->first();

            if (!$eventScore) {
                return;
            }

            $rounds = DB::table('scorecards')->where('event_id', $eventId)->where('archer_id', $archerId)
                ->orderBy('round')->orderBy('id')->get()->groupBy('round');

            // Stop rather than overwrite scores that have changed since the audited backup.
            if ($rounds->keys()->map(fn ($round) => (int) $round)->all() !== range(1, 9)
                || $rounds->contains(fn ($arrows) => $arrows->count() !== 6)
                || (int) $rounds->sum(fn ($arrows) => $arrows->sum('arrow')) !== 463) {
                throw new RuntimeException('Asma Bhikhoo\'s Bhikhoo event scores differ from the audited 54-arrow total of 463. Review before applying this repair.');
            }

            $grading = DB::table('archergradings')->where('event', $eventId)->where('archer_id', $archerId)->first();
            $requiredScore = is_numeric($grading?->totalScore) ? (float) $grading->totalScore : 0;
            $cumulative = 0;

            foreach ($rounds as $round => $arrows) {
                $roundTotal = (int) $arrows->sum('arrow');
                $cumulative += $roundTotal;
                $currentPR = (int) round($cumulative / (int) $round);
                $requiredPR = (int) round(($requiredScore - $cumulative) / max(1, 9 - (int) $round));

                DB::table('scorecards')->where('event_id', $eventId)->where('archer_id', $archerId)
                    ->where('round', $round)->update([
                        'roundtotal' => $roundTotal,
                        'cumtotal' => $cumulative,
                        'total' => 463,
                        'currentPR' => $currentPR,
                        'requiredPR' => $requiredPR,
                    ]);
            }

            DB::table('eventscores')->where('id', $eventScore->id)->update([
                'totalScore' => 463,
                'thumbring' => $currentPR,
                'arrowinhand' => $requiredPR,
            ]);
        });
    }

    public function down(): void
    {
        // Do not restore the incorrect historical score on rollback.
    }
};
