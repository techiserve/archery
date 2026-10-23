<?php

namespace Tests\Feature;

use App\Models\Archer;
use App\Models\CertificateEmailBatch;
use App\Models\Event;
use App\Models\Eventcategory;
use App\Models\Eventscore;
use App\Models\User;
use App\Services\CertificateEmailTracker;
use DOMDocument;
use DOMXPath;
use Tests\TestCase;

class CertificateEmailStatusTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        config([
            'database.default' => 'certificate_email_test',
            'database.connections.certificate_email_test' => [
                'driver' => 'sqlite',
                'database' => ':memory:',
                'prefix' => '',
                'foreign_key_constraints' => true,
            ],
        ]);

        foreach ([
            '0001_01_01_000000_create_users_table.php',
            '2025_02_20_160206_create_eventscores_table.php',
            '2026_07_23_150000_create_certificate_email_batches_table.php',
            '2026_09_21_090100_add_certificate_email_tracking_to_eventscores_table.php',
        ] as $migration) {
            (require database_path('migrations/' . $migration))->up();
        }

        $this->actingAs(User::create([
            'name' => 'Test Admin',
            'email' => 'admin@example.com',
            'password' => 'test-password',
            'role' => 'admin',
        ]));
    }

    public function test_scores_have_a_status_cell_for_each_row_and_exclude_ineligible_archers(): void
    {
        $html = $this->renderScores();
        $document = new DOMDocument;
        $document->loadHTML($html, LIBXML_NOERROR | LIBXML_NOWARNING);
        $xpath = new DOMXPath($document);

        $this->assertSame(13, $xpath->query('//table[@id="archers-table"]/thead/tr/th')->length);
        $cells = $xpath->query('//table[@id="archers-table"]/tbody/tr/td[contains(@class,"certificate-email-status-cell")]');
        $this->assertCount(4, $cells);
        $this->assertStringContainsString('Email sent', $cells->item(0)->textContent);
        $this->assertStringContainsString('Failed to send', $cells->item(1)->textContent);
        $this->assertStringContainsString('Not Sent', $cells->item(2)->textContent);
        $this->assertSame(html_entity_decode('&mdash;', ENT_QUOTES, 'UTF-8'), trim($cells->item(3)->textContent));

        foreach ($xpath->query('//table[@id="archers-table"]/tbody/tr') as $row) {
            $this->assertSame(13, $xpath->query('./td', $row)->length);
        }
    }

    public function test_non_certificate_events_keep_their_existing_columns(): void
    {
        $html = $this->renderScores(false);
        $this->assertStringNotContainsString('>Certificate Email</th>', $html);
        $document = new DOMDocument;
        $document->loadHTML($html, LIBXML_NOERROR | LIBXML_NOWARNING);
        $xpath = new DOMXPath($document);
        $this->assertSame(12, $xpath->query('//table[@id="archers-table"]/thead/tr/th')->length);
        $this->assertSame(0, $xpath->query('//td[contains(@class,"certificate-email-status-cell")]')->length);
    }

    public function test_batch_updates_include_current_statuses_only_for_that_events_batch_rows(): void
    {
        $sent = $this->score('sent');
        $failed = $this->score('failed');
        $pending = $this->score('queued');
        $otherEvent = $this->score('sent', 31);
        $this->score('sent');

        $batch = CertificateEmailBatch::create([
            'user_id' => auth()->id(),
            'event_id' => 29,
            'status' => 'processing',
            'total' => 3,
            'sent' => 1,
            'failed' => 1,
            'event_score_ids' => [$sent->id, $failed->id, $pending->id, $otherEvent->id],
        ]);

        $response = $this->getJson(route('certificate-email-batches.show', $batch))
            ->assertOk()
            ->assertJsonCount(3, 'batch.email_statuses');
        $statuses = collect($response->json('batch.email_statuses'))->keyBy('event_score_id');
        $this->assertStringContainsString('Email sent', $statuses[$sent->id]['html']);
        $this->assertStringContainsString('Failed to send', $statuses[$failed->id]['html']);
        $this->assertStringContainsString('Not Sent (Queued)', $statuses[$pending->id]['html']);

        app(CertificateEmailTracker::class)->start($pending, 'archer@example.com');
        app(CertificateEmailTracker::class)->sent($pending);
        $response = $this->getJson(route('certificate-email-batches.show', $batch))->assertOk();
        $statuses = collect($response->json('batch.email_statuses'))->keyBy('event_score_id');
        $this->assertStringContainsString('Email sent', $statuses[$pending->id]['html']);
    }

    public function test_other_users_cannot_read_a_batchs_email_statuses(): void
    {
        $batch = CertificateEmailBatch::create([
            'user_id' => auth()->id(),
            'event_id' => 29,
            'event_score_ids' => [],
        ]);
        $otherUser = User::create([
            'name' => 'Other Admin',
            'email' => 'other@example.com',
            'password' => 'test-password',
            'role' => 'admin',
        ]);

        $this->actingAs($otherUser)
            ->getJson(route('certificate-email-batches.show', $batch))
            ->assertForbidden();
    }

    private function score(?string $status, int $eventId = 29): Eventscore
    {
        return Eventscore::create([
            'event_id' => $eventId,
            'archer_id' => 1,
            'status' => '1',
            'totalScore' => 400,
            'timed' => 9,
            'certificate_email_status' => $status,
            'certificate_email_address' => 'archer@example.com',
            'certificate_email_sent_at' => $status === 'sent' ? now() : null,
            'certificate_email_error' => $status === 'failed' ? 'Missing or invalid email address.' : null,
        ]);
    }

    private function renderScores(bool $showStatus = true): string
    {
        $scores = collect(['sent', 'failed', null, 'failed'])->map(fn ($status) => $this->score($status));

        return view('events.scoring', [
            'archers' => $scores,
            'pples' => collect([(new Archer)->forceFill([
                'id' => 1,
                'name' => 'Test',
                'surname' => 'Archer',
                'currentGradingDominant' => 'ANG',
                'gradingfor' => 'AS1',
            ])]),
            'event' => (new Event)->forceFill(['id' => 29, 'name' => 'Test Grading', 'doe' => '2026-06-13', 'status' => '1']),
            'category' => new Eventcategory(['name' => 'Grading', 'rounds' => 9]),
            'cat' => '1',
            'catname' => 'Grading',
            'institutes' => collect(),
            'certificateEligibleScoreIds' => $scores->take(3)->pluck('id')->map(fn ($id) => (string) $id),
            'allCertificateEligibleScoreIds' => collect(),
            'showCertificateEmailStatus' => $showStatus,
        ])->render();
    }
}
