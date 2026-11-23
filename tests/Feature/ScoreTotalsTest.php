<?php

namespace Tests\Feature;

use App\Http\Controllers\GradingController;
use App\Models\Archer;
use App\Models\Archergrading;
use App\Models\Event;
use App\Models\Eventcategory;
use App\Models\Eventcategoryscore;
use App\Models\Eventscore;
use App\Models\GradingCard;
use App\Models\Scorecard;
use App\Models\User;
use App\Services\CertificatePdfStamper;
use App\Services\ScoreTotalsRecalculator;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;
use RuntimeException;
use Tests\TestCase;

class ScoreTotalsTest extends TestCase
{
    private Archer $archer;
    private Event $event;
    private Archergrading $grading;
    private Eventscore $eventScore;

    protected function setUp(): void
    {
        parent::setUp();
        $this->app->instance('env', 'testing');
        config([
            'database.default' => 'score_totals_test',
            'database.connections.score_totals_test' => [
                'driver' => 'sqlite', 'database' => ':memory:', 'prefix' => '',
                'foreign_key_constraints' => true,
            ],
            'cache.default' => 'array', 'session.driver' => 'array',
        ]);
        Mail::fake();
        foreach ([
            '0001_01_01_000000_create_users_table.php',
            '2025_01_20_094837_create_archers_table.php',
            '2025_01_20_103919_create_archergradings_table.php',
            '2025_02_19_131213_create_eventcategories_table.php',
            '2025_02_20_160159_create_events_table.php',
            '2025_02_20_160206_create_eventscores_table.php',
            '2025_03_20_073220_create_eventcategoryscores_table.php',
            '2025_03_25_121405_create_scorecards_table.php',
            '2025_04_10_083917_create_grading_cards_table.php',
            '2026_09_21_090100_add_certificate_email_tracking_to_eventscores_table.php',
        ] as $migration) {
            (require database_path('migrations/' . $migration))->up();
        }
        // This legacy column exists in the deployed database, but not its initial migration.
        Schema::table('archergradings', fn (Blueprint $table) => $table->string('event')->nullable());
        $this->actingAs(User::create([
            'name' => 'Score Admin', 'email' => 'admin@example.com', 'password' => 'test-password', 'role' => 'admin',
        ]));
        Eventcategory::create(['id' => 1, 'name' => 'Grading', 'rounds' => 9, 'arrows' => 6]);
        Eventcategoryscore::create(['eventcategory_id' => 1, 'score' => 10]);
        GradingCard::create(['level' => 'AS1', 'score' => 368]);
        $this->archer = Archer::create([
            'name' => 'Asma', 'surname' => 'Bhikhoo', 'currentGradingDominant' => 'ANG', 'currentGradingWeak' => 'ANG',
        ]);
        $this->event = new Event;
        $this->event->forceFill(['id' => 47, 'name' => 'Bhikhoo', 'doe' => '2026-11-22', 'cat' => 1])->save();
        $this->grading = new Archergrading;
        $this->grading->forceFill([
            'event' => $this->event->id, 'archer_id' => $this->archer->id,
            'name' => 'Asma', 'date' => '2026-11-22', 'currentGrading' => 'ANG',
            'gradingfor' => 'AS1', 'totalScore' => 368,
        ])->save();
        $this->eventScore = Eventscore::create([
            'event_id' => $this->event->id, 'archer_id' => $this->archer->id,
            'totalScore' => 0, 'bowUsed' => 0, 'timed' => 1, 'status' => '1',
            'certificate_email_status' => 'sent', 'certificate_email_attempts' => 2,
            'certificate_email_sent_at' => '2026-11-22 12:00:00',
        ]);
    }

    public function test_editing_round_one_then_capturing_round_two_keeps_round_one_in_the_total(): void
    {
        $firstRound = $this->round(1, [10, 9, 9, 9, 7, 6], 0);
        $this->edit(1, $firstRound->pluck('arrow', 'id')->all());
        $this->assertRound(1, 50, 50, 50);

        $this->capture(2, [10, 10, 9, 9, 9, 8]);
        $this->assertRound(1, 50, 50, 105);
        $this->assertRound(2, 55, 105, 105);
        $this->assertSame(105, (int) $this->eventScore->fresh()->totalScore);
    }

    public function test_editing_an_earlier_round_rebuilds_all_later_cumulative_totals(): void
    {
        $first = $this->round(1, [10, 9, 9, 9, 7, 6], 0);
        $this->round(2, [10, 10, 9, 9, 9, 8], 55);
        $this->round(3, [10, 10, 9, 9, 9, 9], 111);
        $scores = $first->pluck('arrow', 'id')->all();
        $scores[$first->last()->id] = 10;
        $this->edit(1, $scores);

        $this->assertRound(1, 54, 54, 165);
        $this->assertRound(2, 55, 109, 165);
        $this->assertRound(3, 56, 165, 165);
        $this->assertSame(165, (int) $this->eventScore->fresh()->totalScore);
        $this->assertSame('sent', $this->eventScore->fresh()->certificate_email_status);
        $this->assertSame(2, $this->eventScore->fresh()->certificate_email_attempts);
        Mail::assertNothingSent();
        Mail::assertNothingQueued();
    }

    public function test_final_capture_uses_arrow_totals_for_the_upgrade_decision_not_posted_totals(): void
    {
        $this->eventScore->update(['timed' => 8]);
        $this->round(1, [10, 9, 9, 9, 7, 6], 0);
        foreach ([55, 56, 55, 57, 47, 48, 49] as $index => $total) {
            $this->round($index + 2, $this->arrowsForTotal($total), 0);
        }
        $this->capture(9, [9, 8, 8, 8, 8, 5], ['total' => 0, 'cum_total' => 0, 'round_total' => 0]);

        $this->assertSame(463, (int) $this->eventScore->fresh()->totalScore);
        $this->assertRound(9, 46, 463, 463);
        $this->assertSame('AS1', $this->archer->fresh()->currentGradingDominant);
    }

    public function test_capturing_a_round_twice_does_not_duplicate_arrows_or_inflate_the_total(): void
    {
        $this->capture(1, [10, 9, 9, 9, 7, 6]);
        $this->postJson(route('grading.confirmscores'), $this->capturePayload(1, [10, 9, 9, 9, 7, 6]))
            ->assertUnprocessable()->assertJsonValidationErrors('round');
        $this->assertSame(6, Scorecard::count());
        $this->assertSame(50, (int) $this->eventScore->fresh()->totalScore);
    }

    public function test_editing_middle_and_final_rounds_ignores_missing_client_totals(): void
    {
        $this->round(1, [10, 9, 9, 9, 7, 6], 0);
        $middle = $this->round(2, [10, 10, 9, 9, 9, 8], 55);
        $final = $this->round(3, [10, 10, 9, 9, 9, 9], 111);
        foreach ([$middle, $final] as $arrows) {
            $scores = $arrows->pluck('arrow', 'id')->all();
            $scores[$arrows->last()->id] = 0;
            $payload = $this->editPayload((int) $arrows->first()->round, $scores);
            unset($payload['round_total'], $payload['cum_total'], $payload['total'], $payload['current_pr']);
            $this->post(route('event.updateScore'), $payload)->assertRedirect()->assertSessionHasNoErrors();
        }
        $this->assertRound(1, 50, 50, 144);
        $this->assertRound(2, 47, 97, 144);
        $this->assertRound(3, 47, 144, 144);
        $this->assertSame(144, (int) $this->eventScore->fresh()->totalScore);
    }

    public function test_non_grading_scores_are_recalculated_without_changing_grades(): void
    {
        $category = new Eventcategory;
        $category->forceFill(['id' => 9, 'name' => 'Tabla Challenge', 'rounds' => 5, 'arrows' => 6])->save();
        $this->event->update(['cat' => 9]);
        $first = $this->round(1, [10, 9, 9, 9, 7, 6], 0);
        $this->round(2, [10, 10, 9, 9, 9, 8], 55);
        $payload = $this->editPayload(1, $first->pluck('arrow', 'id')->all());
        $payload['cat'] = 9;
        $this->post(route('event.updateScore'), $payload)->assertRedirect()->assertSessionHasNoErrors();
        $this->assertRound(1, 50, 50, 105);
        $this->assertRound(2, 55, 105, 105);
        $this->assertSame(0, (int) $this->eventScore->fresh()->arrowinhand);
        $this->assertSame('ANG', $this->archer->fresh()->currentGradingDominant);
    }

    public function test_failed_recalculation_rolls_back_the_arrow_edit(): void
    {
        $first = $this->round(1, [10, 9, 9, 9, 7, 6], 50);
        $scores = $first->pluck('arrow', 'id')->all();
        $scores[$first->last()->id] = 10;
        $this->mock(ScoreTotalsRecalculator::class)->shouldReceive('recalculate')->once()
            ->andThrow(new RuntimeException('Test calculation failure'));
        $this->withoutExceptionHandling();
        try {
            $this->post(route('event.updateScore'), $this->editPayload(1, $scores));
            $this->fail('Expected recalculation failure.');
        } catch (RuntimeException $exception) {
            $this->assertSame('Test calculation failure', $exception->getMessage());
        }
        $this->assertSame(6, (int) $first->last()->fresh()->arrow);
        $this->assertSame(0, (int) $this->eventScore->fresh()->totalScore);
    }

    public function test_forged_high_total_cannot_upgrade_an_archer_with_insufficient_arrow_scores(): void
    {
        for ($round = 1; $round < 9; $round++) {
            $this->round($round, [0, 0, 0, 0, 0, 0], 9999);
        }
        $this->capture(9, [1, 1, 1, 1, 1, 1]);
        $this->assertSame(6, (int) $this->eventScore->fresh()->totalScore);
        $this->assertSame('ANG', $this->archer->fresh()->currentGradingDominant);
    }

    public function test_initial_capture_creates_the_grading_and_uses_arrow_totals(): void
    {
        $this->grading->delete();
        $this->capture(1, [10, 9, 9, 9, 7, 6]);
        $this->assertSame(50, (int) $this->eventScore->fresh()->totalScore);
        $this->assertRound(1, 50, 50, 50);
        $this->assertSame(1, Archergrading::count());
        $this->assertSame((string) Archergrading::first()->id, (string) Scorecard::first()->archergrading_id);
    }

    public function test_round_edit_form_keeps_cumulative_and_event_totals_separate(): void
    {
        $this->round(1, [10, 9, 9, 9, 7, 6], 50);
        Scorecard::query()->update(['total' => 105]);
        $this->post(route('event.editScore'), [
            'event' => $this->event->id, 'archer' => $this->archer->id, 'round' => 1, 'cat' => 1,
        ])->assertOk()
            ->assertSee("id='cum_total' name='cum_total' value='50'", false)
            ->assertSee('const previousCumulative = 0;', false)
            ->assertSee('const otherRoundsTotal = 55;', false);
    }

    public function test_edit_cannot_update_an_arrow_from_another_archer_event_or_round(): void
    {
        $first = $this->round(1, [10, 9, 9, 9, 7, 6], 50);
        $foreign = $this->round(2, [8, 8, 8, 8, 8, 8], 98)->first();
        foreach ([['round' => 2], ['round' => 1, 'archer_id' => 999], ['round' => 1, 'event_id' => 999]] as $attributes) {
            $foreign->forceFill($attributes)->save();
            $scores = $first->pluck('arrow', 'id')->all();
            unset($scores[$first->first()->id]);
            $scores[$foreign->id] = 10;
            $this->postJson(route('event.updateScore'), $this->editPayload(1, $scores))
                ->assertUnprocessable()->assertJsonValidationErrors('scores');
            $this->assertSame(8, (int) $foreign->fresh()->arrow);
            $this->assertSame(0, (int) $this->eventScore->fresh()->totalScore);
        }
    }

    public function test_edit_rejects_incomplete_or_invalid_arrows_without_changing_scores(): void
    {
        $first = $this->round(1, [10, 9, 9, 9, 7, 6], 50);
        $scores = $first->pluck('arrow', 'id')->all();
        $incomplete = $scores;
        array_pop($incomplete);
        $invalid = $scores;
        $invalid[$first->last()->id] = 'invalid';
        foreach ([$incomplete, $invalid] as $values) {
            $this->postJson(route('event.updateScore'), $this->editPayload(1, $values))->assertUnprocessable();
        }
        $this->assertSame(50, (int) Scorecard::sum('arrow'));
    }

    public function test_migration_repairs_asma_and_certificate_without_altering_other_data(): void
    {
        $this->seedAsmaBackup();
        $other = $this->eventScore->replicate();
        $other->archer_id = 999;
        $other->totalScore = 495;
        $other->save();
        $otherArrow = $this->round(1, [1, 2, 3, 4, 5, 6], 21)->first();
        Scorecard::where('id', '>=', $otherArrow->id)->update(['archer_id' => 999]);
        $beforeOther = $other->fresh()->getAttributes();
        $beforeOtherArrows = Scorecard::where('archer_id', 999)->get()->toArray();
        $beforeGrades = $this->grading->fresh()->getAttributes();
        $beforeArrows = Scorecard::where('archer_id', $this->archer->id)->pluck('arrow', 'id')->all();
        $beforeEmail = $this->eventScore->fresh()->certificate_email_sent_at;

        $this->repairMigration()->up();
        $this->repairMigration()->up();

        $cumulative = 0;
        foreach ([50, 55, 56, 55, 57, 47, 48, 49, 46] as $index => $total) {
            $cumulative += $total;
            $this->assertRound($index + 1, $total, $cumulative, 463);
        }
        $this->assertSame(463, (int) $this->eventScore->fresh()->totalScore);
        $this->assertSame($beforeOther, $other->fresh()->getAttributes());
        $this->assertSame($beforeOtherArrows, Scorecard::where('archer_id', 999)->get()->toArray());
        $this->assertSame($beforeArrows, Scorecard::where('archer_id', $this->archer->id)->pluck('arrow', 'id')->all());
        $this->assertSame($beforeGrades, $this->grading->fresh()->getAttributes());
        $this->assertSame('AS1', $this->archer->fresh()->currentGradingDominant);
        $this->assertSame('sent', $this->eventScore->fresh()->certificate_email_status);
        $this->assertEquals($beforeEmail, $this->eventScore->fresh()->certificate_email_sent_at);

        $this->mock(CertificatePdfStamper::class)->shouldReceive('stamp')->once()
            ->withArgs(fn ($template, $data) => $data['score'] == 463 && $data['grading'] === 'AS1')
            ->andReturn('%PDF-test');
        $certificate = app(GradingController::class)->buildCertificate($this->eventScore->fresh());
        $this->assertSame(463, (int) $certificate['data']['score']);
    }

    public function test_repair_does_nothing_without_the_exact_archer_and_event(): void
    {
        $this->seedAsmaBackup();
        $this->event->update(['doe' => '2026-11-21']);
        $this->repairMigration()->up();
        $this->assertSame(413, (int) $this->eventScore->fresh()->totalScore);
    }

    public function test_repair_stops_without_partial_updates_if_audited_arrow_scores_have_changed(): void
    {
        $this->seedAsmaBackup();
        Scorecard::first()->update(['arrow' => 0]);
        try {
            $this->repairMigration()->up();
            $this->fail('The repair should require review of changed scores.');
        } catch (RuntimeException $exception) {
            $this->assertStringContainsString('differ from the audited', $exception->getMessage());
        }
        $this->assertSame(413, (int) $this->eventScore->fresh()->totalScore);
        $this->assertSame(0, (int) Scorecard::first()->cumtotal);
    }

    private function round(int $round, array $arrows, int $cumulative)
    {
        return collect($arrows)->map(fn ($arrow) => Scorecard::create([
            'event_id' => $this->event->id, 'archer_id' => $this->archer->id,
            'archergrading_id' => $this->grading->id, 'round' => $round, 'arrow' => $arrow,
            'roundtotal' => array_sum($arrows), 'cumtotal' => $cumulative, 'total' => $cumulative,
            'currentPR' => 0, 'requiredPR' => 0,
        ]));
    }

    private function editPayload(int $round, array $scores): array
    {
        return [
            'event' => $this->event->id, 'archer' => $this->archer->id, 'cat' => 1,
            'round' => $round, 'scores' => [$round => $scores],
            'round_total' => 9999, 'cum_total' => 0, 'total' => 9999, 'current_pr' => 9999,
        ];
    }

    private function edit(int $round, array $scores): void
    {
        $this->post(route('event.updateScore'), $this->editPayload($round, $scores))
            ->assertRedirect(route('events.showEvent', $this->event->id))->assertSessionHasNoErrors();
    }

    private function capturePayload(int $round, array $arrows): array
    {
        return [
            'event' => $this->event->id, 'archer' => $this->archer->id, 'eventcategory' => 'Grading',
            'round' => $round, 'scores' => [$round => $arrows], 'gradefor' => 'AS1', 'figure' => 368,
            'round_total' => 9999, 'cum_total' => 0, 'total' => 9999,
        ];
    }

    private function capture(int $round, array $arrows, array $overrides = []): void
    {
        $this->withoutExceptionHandling();
        $this->post(route('grading.confirmscores'), array_replace($this->capturePayload($round, $arrows), $overrides))
            ->assertRedirect(route('events.showEvent', $this->event->id))->assertSessionHasNoErrors();
        $this->withExceptionHandling();
    }

    private function assertRound(int $round, int $roundTotal, int $cumulative, int $total): void
    {
        $rows = Scorecard::where('event_id', $this->event->id)->where('archer_id', $this->archer->id)->where('round', $round)->get();
        $this->assertCount(6, $rows);
        foreach ($rows as $row) {
            $this->assertSame($roundTotal, (int) $row->roundtotal);
            $this->assertSame($cumulative, (int) $row->cumtotal);
            $this->assertSame($total, (int) $row->total);
        }
    }

    private function arrowsForTotal(int $total): array
    {
        $arrows = [];
        for ($i = 0; $i < 6; $i++) {
            $arrows[] = min(10, $total);
            $total -= end($arrows);
        }
        return $arrows;
    }

    private function seedAsmaBackup(): void
    {
        $this->archer->update(['currentGradingDominant' => 'AS1']);
        $this->eventScore->update(['totalScore' => 413, 'timed' => 9]);
        $cumulative = 0;
        foreach ([50, 55, 56, 55, 57, 47, 48, 49, 46] as $index => $total) {
            if ($index > 0) {
                $cumulative += $total;
            }
            $this->round($index + 1, $this->arrowsForTotal($total), $cumulative);
        }
    }

    private function repairMigration()
    {
        return require database_path('migrations/2026_11_23_090000_correct_asma_bhikhoo_event_score_totals.php');
    }
}
