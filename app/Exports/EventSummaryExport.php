<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class EventSummaryExport implements FromArray, WithHeadings, ShouldAutoSize
{
    private array $rounds = [];

    public function __construct(private int $eventId)
    {
        $this->rounds = DB::table('scorecards')
            ->where('event_id', $this->eventId)
            ->whereNotNull('round')
            ->distinct()
            ->orderBy('round')
            ->pluck('round')
            ->map(fn ($r) => (int)$r)
            ->toArray();
    }

    public function headings(): array
    {
        $roundHeaders = array_map(fn ($r) => "Round {$r}", $this->rounds);

        return array_merge(
            ['Name', 'Age Category', 'Event Type', 'Required Score'],
            $roundHeaders,
            ['Total']
        );
    }

    public function array(): array
    {
        // 1) Base archer rows for this event
        $baseRows = DB::table('scorecards as sc')
            ->join('archers as a', 'a.id', '=', 'sc.archer_id')
            ->join('events as e', 'e.id', '=', 'sc.event_id')
            ->leftJoin('eventcategories as ec', 'ec.id', '=', 'e.cat')
            ->where('sc.event_id', $this->eventId)
            ->select([
                'sc.archer_id',
                'a.name as archer_name',
                // CHANGE THIS if your column name differs:
                'a.ageCategory as age_category',
                'ec.name as event_type',
                DB::raw('MAX(sc.requiredPR) as biggest_required_score'),
            ])
            ->groupBy('sc.archer_id', 'a.name', 'a.ageCategory', 'ec.name')
            ->orderBy('a.name')
            ->get();

        // 2) Round totals per archer per round (use MAX(roundtotal) because multiple arrow rows exist)
        $roundTotals = DB::table('scorecards')
            ->where('event_id', $this->eventId)
            ->whereNotNull('round')
            ->select([
                'archer_id',
                'round',
                DB::raw('MAX(roundtotal) as round_total'),
            ])
            ->groupBy('archer_id', 'round')
            ->get();

        // Build a lookup: totals[archer_id][round] = round_total
        $totals = [];
        foreach ($roundTotals as $rt) {
            $aid = (string)$rt->archer_id;
            $r   = (int)$rt->round;
            $totals[$aid][$r] = (int)($rt->round_total ?? 0);
        }

        // 3) Build final sheet rows
        $rows = [];

        foreach ($baseRows as $b) {
            $aid = (string)$b->archer_id;

            $grandTotal = 0;
            $perRoundCols = [];

            foreach ($this->rounds as $r) {
                $v = $totals[$aid][$r] ?? 0;
                $perRoundCols[] = $v;
                $grandTotal += $v;
            }

            $rows[] = array_merge(
                [
                    $b->archer_name,
                    $b->age_category,
                    $b->event_type,
                    $b->biggest_required_score ?? 0,
                ],
                $perRoundCols,
                [$grandTotal]
            );
        }

        return $rows;
    }
}
