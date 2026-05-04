<?php

namespace App\Exports;

use App\Models\Event;
use App\Models\Eventcategory;
use App\Models\GradingCard;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class EventRawScoresExport implements FromArray, WithHeadings, ShouldAutoSize, WithStyles
{
    private array $rounds = [];
    private array $arrowsPerRound = [];
    private ?Event $event = null;
    private ?Eventcategory $category = null;

    public function __construct(private int $eventId)
    {
        $this->event = Event::find($this->eventId);

        $this->category = $this->event
            ? Eventcategory::find($this->event->cat)
            : null;

        $this->rounds = DB::table('scorecards')
            ->where('event_id', $this->eventId)
            ->whereNotNull('round')
            ->distinct()
            ->orderBy('round')
            ->pluck('round')
            ->map(fn ($r) => (int) $r)
            ->toArray();

        $arrowCounts = DB::table('scorecards')
            ->where('event_id', $this->eventId)
            ->whereNotNull('round')
            ->select([
                'archer_id',
                'round',
                DB::raw('COUNT(*) as arrows_count'),
            ])
            ->groupBy('archer_id', 'round')
            ->get();

        foreach ($this->rounds as $round) {
            $this->arrowsPerRound[$round] = (int) (
                $arrowCounts->where('round', $round)->max('arrows_count') ?? 0
            );
        }
    }

    public function headings(): array
    {
        $headings = [
            'Date',
            'Name',
            'Age Category',
            'Bow Used',
            'Current Grading',
            'Grading For',
        ];

        foreach ($this->rounds as $round) {
            $arrowCount = $this->arrowsPerRound[$round] ?? 0;

            for ($arrow = 1; $arrow <= $arrowCount; $arrow++) {
                $headings[] = "A{$round}-{$arrow}";
            }
        }

        $headings[] = 'TOTAL';

        return $headings;
    }

    public function array(): array
    {
        $baseRows = DB::table('scorecards as sc')
            ->join('archers as a', 'a.id', '=', 'sc.archer_id')
            ->join('events as e', 'e.id', '=', 'sc.event_id')
            ->leftJoin('archergradings as ag', function ($join) {
                $join->on('ag.archer_id', '=', 'sc.archer_id')
                    ->on('ag.event', '=', 'sc.event_id');
            })
            ->where('sc.event_id', $this->eventId)
            ->select([
                'sc.archer_id',
                'e.doe as event_date',
                DB::raw("TRIM(CONCAT(COALESCE(a.name, ''), ' ', COALESCE(a.surname, ''))) as archer_name"),
                'a.ageCategory as age_category',
                'a.currentGradingWeak',
                'a.currentGradingDominant',
                'ag.bowUsed as bow_used',
            ])
            ->groupBy(
                'sc.archer_id',
                'e.doe',
                'a.name',
                'a.surname',
                'a.ageCategory',
                'a.currentGradingWeak',
                'a.currentGradingDominant',
                'ag.bowUsed'
            )
            ->orderBy('a.name')
            ->get();

        $scoreRows = DB::table('scorecards')
            ->where('event_id', $this->eventId)
            ->whereNotNull('round')
            ->orderBy('archer_id')
            ->orderBy('round')
            ->orderBy('id')
            ->get();

        $scores = [];

        foreach ($scoreRows as $scoreRow) {
            $archerId = (string) $scoreRow->archer_id;
            $round = (int) $scoreRow->round;

            $scores[$archerId][$round][] = (int) ($scoreRow->arrow ?? 0);
        }

        $rows = [];

        foreach ($baseRows as $base) {
            $archerId = (string) $base->archer_id;

            $currentGrading = $this->getCurrentGrading($base);
            $gradingFor = $this->getGradingFor($currentGrading);

            $row = [
                $base->event_date,
                $base->archer_name,
                $base->age_category ?? 'No Age Category',
                $base->bow_used ?? '',
                $currentGrading,
                $gradingFor,
            ];

            $grandTotal = 0;

            foreach ($this->rounds as $round) {
                $roundScores = $scores[$archerId][$round] ?? [];
                $arrowCount = $this->arrowsPerRound[$round] ?? 0;

                for ($i = 0; $i < $arrowCount; $i++) {
                    $score = $roundScores[$i] ?? '';
                    $row[] = $score;

                    if ($score !== '') {
                        $grandTotal += (int) $score;
                    }
                }
            }

            $row[] = $grandTotal;

            $rows[] = $row;
        }

        return $rows;
    }

    private function getCurrentGrading(object $archer): string
    {
        if (($this->category?->name ?? '') === 'Non Dominant Hand') {
            return $archer->currentGradingWeak ?? 'CNG';
        }

        return $archer->currentGradingDominant ?? 'CNG';
    }

    private function getGradingFor(?string $currentGrading): string
    {
        $currentGrading = $currentGrading ?: 'CNG';

        if ($currentGrading === 'CNG') {
            $currentGradeId = 0;
        } elseif ($currentGrading === 'JNG') {
            $currentGradeId = 9;
        } elseif ($currentGrading === 'ANG') {
            $currentGradeId = 18;
        } else {
            $currentGradeId = Gradingcard::where('level', $currentGrading)->value('id') ?? 0;
        }

        return Gradingcard::where('id', '>', $currentGradeId)
            ->orderBy('id', 'asc')
            ->value('level') ?? '';
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle(1)->getFont()->setBold(true);
        $sheet->freezePane('A2');

        return [];
    }
}