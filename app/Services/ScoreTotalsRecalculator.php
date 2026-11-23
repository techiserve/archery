<?php

namespace App\Services;

use App\Models\Archergrading;
use App\Models\Eventcategory;
use App\Models\Eventscore;
use App\Models\GradingCard;
use App\Models\Scorecard;

class ScoreTotalsRecalculator
{
    // Call while holding the event-score row lock in the score-saving transaction.
    public function recalculate(Eventscore $eventScore, Eventcategory $category): int
    {
        $rounds = Scorecard::where('event_id', $eventScore->event_id)
            ->where('archer_id', $eventScore->archer_id)
            ->whereNotNull('round')
            ->orderBy('round')
            ->orderBy('id')
            ->get()
            ->groupBy('round');

        $total = (int) $rounds->sum(fn ($arrows) => $arrows->sum('arrow'));
        $grading = Archergrading::where('event', $eventScore->event_id)
            ->where('archer_id', $eventScore->archer_id)
            ->first();
        $requiredScore = is_numeric($grading?->totalScore) && (float) $grading->totalScore > 0
            ? (float) $grading->totalScore
            : (float) (GradingCard::where('level', $grading?->gradingfor)->value('score') ?? 0);

        $cumulative = 0;
        $currentPR = 0;
        $requiredPR = 0;

        foreach ($rounds as $round => $arrows) {
            $roundTotal = (int) $arrows->sum('arrow');
            $cumulative += $roundTotal;
            $currentPR = (int) round($cumulative / max(1, (int) $round));
            $requiredPR = in_array((int) $category->id, [1, 11], true)
                ? (int) round(($requiredScore - $cumulative) / max(1, (int) $category->rounds - (int) $round))
                : 0;

            Scorecard::where('event_id', $eventScore->event_id)
                ->where('archer_id', $eventScore->archer_id)
                ->where('round', $round)
                ->update([
                    'roundtotal' => $roundTotal,
                    'cumtotal' => $cumulative,
                    'total' => $total,
                    'currentPR' => $currentPR,
                    'requiredPR' => $requiredPR,
                ]);
        }

        $eventScore->forceFill([
            'totalScore' => $total,
            'thumbring' => $currentPR,
            'arrowinhand' => $requiredPR,
        ])->save();

        return $total;
    }
}
