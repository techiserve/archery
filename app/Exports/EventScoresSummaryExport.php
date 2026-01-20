<?php

namespace App\Exports;

use App\Models\Archer;
use App\Models\Eventscore;
use App\Models\Gradingcard;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class EventScoresSummaryExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    private array $gradingForByArcherId = [];

    public function __construct(private int $eventId)
    {
        $this->gradingForByArcherId = $this->buildGradingForMap();
    }

    private function buildGradingForMap(): array
    {
        // Load grading cards once
        $gradingCards = Gradingcard::query()
            ->orderBy('id', 'asc')
            ->get(['id', 'level']);

        // Quick lookup: level => id
        $levelToId = $gradingCards->pluck('id', 'level')->toArray();

        // Sorted list of cards for "next id" lookup
        $cards = $gradingCards->values();

        $archers = Archer::query()->get(['id', 'name', 'currentGradingDominant']);

        $map = [];

        foreach ($archers as $archer) {
            $current = $archer->currentGradingDominant;

            if ($current === 'CNG') {
                $x = 0;
            } elseif ($current === 'JNG') {
                $x = 9;
            } elseif ($current === 'ANG') {
                $x = 18;
            } else {
                $x = $levelToId[$current] ?? 0;
            }

            // Find first grading level with id > x
            $next = $cards->first(fn ($c) => $c->id > $x);

            $map[$archer->id] = $next?->level; // can be null if nothing higher exists
        }

        return $map;
    }

    public function collection(): Collection
    {
        return Eventscore::query()
            ->where('event_id', $this->eventId)
            ->join('archers', 'archers.id', '=', 'eventscores.archer_id')
            ->select([
                'eventscores.archer_id',
                'archers.name as archer_name',
                'eventscores.totalScore',
                'eventscores.created_at',
            ])
            ->orderBy('eventscores.created_at', 'desc')
            ->get();
    }

    public function headings(): array
    {
        return ['Name', 'Graded for', 'Score', 'Date'];
    }

    public function map($row): array
    {
        $gradedFor = $this->gradingForByArcherId[$row->archer_id] ?? null;

        return [
            $row->archer_name,
            $gradedFor,
            $row->totalScore,
            optional($row->created_at)->format('d F Y'), // 20 June 2025
        ];
    }
}
