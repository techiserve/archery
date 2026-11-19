<?php

namespace Tests\Feature;

use App\Mail\ArcherRegistrationDecisionMail;
use App\Models\Archer;
use App\Models\ArcherRegistration;
use App\Models\User;
use Illuminate\Mail\MailManager;
use Illuminate\Support\Facades\Mail;
use RuntimeException;
use Tests\TestCase;

class ArcherRegistrationTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->app->instance('env', 'testing');

        config([
            'session.driver' => 'array',
            'cache.default' => 'array',
            'database.default' => 'registration_test',
            'database.connections.registration_test' => [
                'driver' => 'sqlite',
                'database' => ':memory:',
                'prefix' => '',
                'foreign_key_constraints' => true,
            ],
        ]);

        Mail::fake();

        foreach ([
            '0001_01_01_000000_create_users_table.php',
            '2025_01_20_094837_create_archers_table.php',
            '2026_11_19_090000_create_archer_registrations_table.php',
        ] as $migration) {
            (require database_path('migrations/'.$migration))->up();
        }
    }

    public function test_public_form_collects_personal_details_without_grading_or_password_fields(): void
    {
        $this->get(route('archer-registrations.create'))->assertOk()
            ->assertSee('name="dob"', false)->assertSee('name="nId"', false)->assertSee('name="hand"', false)
            ->assertDontSee('name="currentProficiency"', false)->assertDontSee('name="password"', false);
    }

    public function test_submission_is_pending_and_does_not_create_an_archer_or_user(): void
    {
        $this->post(route('archer-registrations.store'), $this->personal())
            ->assertRedirect(route('archer-registrations.complete'))->assertSessionHasNoErrors();

        $registration = ArcherRegistration::firstOrFail();
        $this->assertSame('pending', $registration->status);
        $this->assertSame('Left', $registration->hand);
        $this->assertSame('TEST123', $registration->nId);
        $this->assertNull($registration->currentProficiency);
        $this->assertNull($registration->currentGradingDominant);
        $this->assertSame(0, Archer::count());
        $this->assertSame(0, User::count());
        Mail::assertNothingQueued();
        $this->get(route('archer-registrations.complete'))->assertOk()->assertSee('Awaiting approval');
    }

    public function test_public_cannot_submit_proficiency_grades_or_approval_fields(): void
    {
        $this->post(route('archer-registrations.store'), $this->personal() + [
            'status' => 'approved', 'currentProficiency' => 'AM3', 'currentGradingDominant' => 'AS3', 'reviewed_by' => 1,
        ])->assertSessionHasErrors(['status', 'currentProficiency', 'currentGradingDominant', 'reviewed_by']);

        $this->assertSame(0, ArcherRegistration::count());
        $this->assertSame(0, Archer::count());
    }

    public function test_invalid_dates_hands_and_email_are_rejected(): void
    {
        $this->post(route('archer-registrations.store'), array_replace($this->personal(), [
            'dob' => now()->addYear()->toDateString(), 'hand' => 'Other', 'email' => 'invalid',
        ]))->assertSessionHasErrors(['dob', 'hand', 'email']);
        $this->assertSame(0, ArcherRegistration::count());
    }

    public function test_all_personal_fields_reject_missing_blank_and_whitespace_only_submissions(): void
    {
        foreach ([
            [],
            array_fill_keys(ArcherRegistration::PERSONAL_FIELDS, ''),
            array_fill_keys(ArcherRegistration::PERSONAL_FIELDS, " \t "),
            array_fill_keys(ArcherRegistration::PERSONAL_FIELDS, "\u{00A0}\u{200B}"),
        ] as $payload) {
            $this->postJson(route('archer-registrations.store'), $payload)
                ->assertUnprocessable()
                ->assertJsonValidationErrors(ArcherRegistration::PERSONAL_FIELDS);
        }

        $this->assertSame(0, ArcherRegistration::count());
    }

    public function test_preferred_name_and_institute_cannot_be_left_empty_when_other_fields_are_complete(): void
    {
        foreach (['knownAs', 'institute'] as $field) {
            $this->postJson(route('archer-registrations.store'), array_replace($this->personal(), [$field => ' ']))
                ->assertUnprocessable()->assertJsonValidationErrors($field);
        }

        $this->assertSame(0, ArcherRegistration::count());
    }

    public function test_malformed_emails_are_rejected_without_creating_a_registration(): void
    {
        foreach (['not-an-email', 'archer@', 'archer@localhost', 'archer@example..com', 'arch er@example.com'] as $email) {
            $this->postJson(route('archer-registrations.store'), array_replace($this->personal(), ['email' => $email]))
                ->assertUnprocessable()->assertJsonValidationErrors('email');
        }

        $this->assertSame(0, ArcherRegistration::count());
    }

    public function test_personal_details_are_trimmed_and_valid_email_is_normalized(): void
    {
        $this->post(route('archer-registrations.store'), array_replace($this->personal(), [
            'name' => "\u{00A0} TestName \u{200B}",
            'knownAs' => ' Test ',
            'institute' => ' Test Institute ',
            'email' => '  Archer+Registration@Example.COM  ',
        ]))->assertSessionHasNoErrors()->assertRedirect(route('archer-registrations.complete'));

        $registration = ArcherRegistration::firstOrFail();
        $this->assertSame('TestName', $registration->name);
        $this->assertSame('Test', $registration->knownAs);
        $this->assertSame('Test Institute', $registration->institute);
        $this->assertSame('archer+registration@example.com', $registration->email);
    }

    public function test_duplicate_ids_are_blocked_but_siblings_can_share_an_email(): void
    {
        ArcherRegistration::create($this->personal());
        $this->post(route('archer-registrations.store'), $this->personal())->assertSessionHasErrors('nId');
        $this->post(route('archer-registrations.store'), array_replace($this->personal(), ['nId' => 'TEST456']))
            ->assertSessionHasNoErrors();
        $this->assertSame(2, ArcherRegistration::count());
    }

    public function test_ids_already_in_the_archers_table_cannot_register_again(): void
    {
        Archer::create(['name' => 'Existing', 'nId' => 'TEST123']);
        $this->post(route('archer-registrations.store'), $this->personal())->assertSessionHasErrors('nId');
        $this->assertSame(0, ArcherRegistration::count());
    }

    public function test_guests_and_scorers_cannot_manage_registrations(): void
    {
        $registration = ArcherRegistration::create($this->personal());
        $this->get(route('archer-registrations.index'))->assertRedirect(route('login'));

        $this->signIn('scorer');
        $this->get(route('archer-registrations.index'))->assertForbidden();
        $this->get(route('archer-registrations.edit', $registration))->assertForbidden();
        $this->put(route('archer-registrations.update', $registration), $this->approval())->assertForbidden();
        $this->assertSame(0, Archer::count());
    }

    public function test_admin_can_save_a_draft_and_set_levels_before_approval(): void
    {
        $registration = ArcherRegistration::create($this->personal());
        $this->signIn();
        $this->put(route('archer-registrations.update', $registration), array_replace($this->approval(), [
            'decision' => 'save', 'knownAs' => 'Updated nickname', 'review_notes' => 'Reviewed ID.',
        ]))->assertSessionHasNoErrors()->assertRedirect(route('archer-registrations.edit', $registration));

        $registration->refresh();
        $this->assertSame('pending', $registration->status);
        $this->assertSame('Updated nickname', $registration->knownAs);
        $this->assertSame('AS1', $registration->currentGradingDominant);
        $this->assertSame(0, Archer::count());
        $this->get(route('archer-registrations.edit', $registration))->assertOk()->assertSee('Reviewed ID.');
        Mail::assertNothingQueued();
    }

    public function test_approval_creates_one_archer_with_the_admins_values_and_review_audit(): void
    {
        $registration = ArcherRegistration::create($this->personal());
        $admin = $this->signIn();
        $payload = array_replace($this->approval(), ['name' => 'Corrected', 'clubMember' => '1']);

        $this->put(route('archer-registrations.update', $registration), $payload)->assertSessionHasNoErrors();
        $registration->refresh();
        $archer = $registration->archer;

        $this->assertSame('approved', $registration->status);
        $this->assertSame($admin->id, $registration->reviewed_by);
        $this->assertNotNull($registration->reviewed_at);
        $this->assertSame('Corrected', $archer->name);
        $this->assertSame('1995-05-20', $archer->dob);
        $this->assertSame('Left', $archer->hand);
        $this->assertSame('AS1', $archer->currentGradingDominant);
        $this->assertSame('ANG', $archer->currentGradingWeak);
        $this->assertSame('AS1', $archer->currentProficiency);
        $this->assertNotEmpty($archer->generatedId);
        $this->assertTrue((bool) $archer->clubMember);

        $this->put(route('archer-registrations.update', $registration), $payload)->assertSessionHasErrors();
        $this->assertSame(1, Archer::count());
        Mail::assertQueued(ArcherRegistrationDecisionMail::class, 1);
        $this->get(route('archer-registrations.edit', $registration))->assertOk()->assertSee('Edit approved archer')
            ->assertDontSee('value="approve"', false);
    }

    public function test_approval_requires_valid_grading_values_and_rolls_back_invalid_submissions(): void
    {
        $registration = ArcherRegistration::create($this->personal());
        $this->signIn();
        $this->put(route('archer-registrations.update', $registration), array_replace($this->approval(), [
            'currentProficiency' => null, 'currentGradingDominant' => 'INVALID',
        ]))->assertSessionHasErrors(['currentProficiency', 'currentGradingDominant']);
        $this->assertSame('pending', $registration->fresh()->status);
        $this->assertSame(0, Archer::count());
    }

    public function test_rejection_requires_a_reason_and_never_creates_an_archer(): void
    {
        $registration = ArcherRegistration::create($this->personal());
        $this->signIn();
        $this->put(route('archer-registrations.update', $registration), $this->personal() + ['decision' => 'reject'])
            ->assertSessionHasErrors('rejection_reason');
        $this->put(route('archer-registrations.update', $registration), $this->personal() + [
            'decision' => 'reject', 'rejection_reason' => 'Please provide a corrected identity document.',
        ])->assertSessionHasNoErrors();

        $registration->refresh();
        $this->assertSame('rejected', $registration->status);
        $this->assertNull($registration->active_identity);
        $this->assertNotNull($registration->reviewed_at);
        $this->assertSame(0, Archer::count());

        $this->post(route('archer-registrations.store'), $this->personal())->assertSessionHasNoErrors();
        $this->assertSame(2, ArcherRegistration::count());
    }

    public function test_admin_list_filters_status_and_search_without_exposing_personal_data_publicly(): void
    {
        ArcherRegistration::create($this->personal());
        $rejected = ArcherRegistration::create(array_replace($this->personal(), ['nId' => 'TEST789', 'name' => 'RejectedName']));
        $rejected->forceFill(['status' => 'rejected', 'rejection_reason' => 'Duplicate'])->save();

        $this->signIn();
        $this->get(route('archer-registrations.index'))->assertOk()->assertSee('TestName')->assertDontSee('RejectedName');
        $this->get(route('archer-registrations.index', ['status' => 'rejected', 'q' => 'RejectedName']))
            ->assertOk()->assertSee('RejectedName')->assertDontSee('TestName');
    }

    public function test_admin_can_reject_a_registration_if_an_archer_was_added_manually_in_the_meantime(): void
    {
        $registration = ArcherRegistration::create($this->personal());
        Archer::create(['name' => 'Manually added', 'nId' => 'TEST123']);
        $this->signIn();

        $this->put(route('archer-registrations.update', $registration), $this->personal() + [
            'decision' => 'reject', 'rejection_reason' => 'Already registered by the club.',
        ])->assertSessionHasNoErrors();

        $this->assertSame('rejected', $registration->fresh()->status);
        $this->assertSame(1, Archer::count());
    }

    public function test_approval_queues_an_email_to_the_saved_archers_email_with_reference_and_archer_number(): void
    {
        $registration = ArcherRegistration::create($this->personal());
        $this->signIn();
        $this->put(route('archer-registrations.update', $registration), array_replace($this->approval(), [
            'name' => 'Corrected',
            'email' => 'corrected-archer@example.com',
            'review_notes' => 'Private review notes must not be emailed.',
        ]))->assertSessionHasNoErrors()->assertSessionHas('success');

        $registration->refresh();
        Mail::assertQueued(ArcherRegistrationDecisionMail::class, function ($mail) use ($registration) {
            $this->assertTrue($mail->hasTo('corrected-archer@example.com'));
            $this->assertSame('Corrected Archer', $mail->archerName);
            $this->assertSame('approved', $mail->registrationStatus);
            $this->assertSame(sprintf('REG-%06d', $registration->id), $mail->reference);
            $this->assertSame($registration->archer->generatedId, $mail->archerNumber);
            $this->assertTrue($mail->afterCommit);
            $mail->assertSeeInHtml('Your archer registration has been approved.');
            $mail->assertSeeInHtml($registration->archer->generatedId);
            $mail->assertDontSeeInHtml('Private review notes must not be emailed.');

            return true;
        });
    }

    public function test_rejection_email_includes_the_reason_but_not_internal_notes(): void
    {
        $registration = ArcherRegistration::create($this->personal());
        $this->signIn();
        $reason = "Please confirm the ID document.\nBring the original to the club.";
        $this->put(route('archer-registrations.update', $registration), $this->personal() + [
            'decision' => 'reject',
            'rejection_reason' => $reason,
            'review_notes' => 'Private review note.',
        ])->assertSessionHasNoErrors();

        Mail::assertQueued(ArcherRegistrationDecisionMail::class, function ($mail) use ($reason) {
            $this->assertTrue($mail->hasTo('archer@example.com'));
            $this->assertSame('rejected', $mail->registrationStatus);
            $this->assertSame($reason, $mail->rejectionReason);
            $mail->assertSeeInHtml('Your archer registration has been rejected.');
            $mail->assertSeeInHtml('Please confirm the ID document.');
            $mail->assertSeeInHtml('Bring the original to the club.');
            $mail->assertDontSeeInHtml('Private review note.');

            return true;
        });
        $this->assertSame(0, Archer::count());
    }

    public function test_rejection_reason_is_escaped_in_email_html(): void
    {
        $mail = new ArcherRegistrationDecisionMail('Test Archer', 'rejected', 'REG-000001', rejectionReason: '<script>unsafe()</script> & additional details');
        $html = $mail->render();

        $this->assertStringContainsString('&lt;script&gt;unsafe()&lt;/script&gt;', $html);
        $this->assertStringContainsString('&amp; additional details', $html);
        $this->assertStringNotContainsString('<script>', $html);
    }

    public function test_failed_email_queueing_does_not_undo_approval(): void
    {
        $registration = ArcherRegistration::create($this->personal());
        $this->signIn();
        Mail::shouldReceive('to')->once()->andThrow(new RuntimeException('Test queue unavailable.'));

        $this->put(route('archer-registrations.update', $registration), $this->approval())
            ->assertRedirect(route('archer-registrations.edit', $registration))
            ->assertSessionHas('warning');

        $this->assertSame('approved', $registration->fresh()->status);
        $this->assertSame(1, Archer::count());
    }

    public function test_real_queued_mail_pipeline_builds_the_email_using_a_non_delivering_mailer(): void
    {
        config(['mail.default' => 'array', 'queue.default' => 'sync']);
        Mail::swap(new MailManager($this->app));
        $registration = ArcherRegistration::create($this->personal());
        $this->signIn();

        $this->put(route('archer-registrations.update', $registration), $this->approval())
            ->assertSessionHasNoErrors()->assertSessionMissing('warning');

        $messages = Mail::mailer()->getSymfonyTransport()->messages();
        $this->assertCount(1, $messages);
        $message = $messages->first()->getOriginalMessage();
        $this->assertSame('archer@example.com', $message->getTo()[0]->getAddress());
        $this->assertStringContainsString('registration approved', $message->getSubject());
        $this->assertStringContainsString('Your archer registration has been approved.', $message->getHtmlBody());
        $this->assertStringContainsString('Your archer registration has been approved.', $message->getTextBody());
    }

    public function test_rejection_reason_is_preserved_verbatim_in_the_plain_text_email(): void
    {
        config(['mail.default' => 'array', 'queue.default' => 'sync']);
        Mail::swap(new MailManager($this->app));
        $reason = "Name & ID do not match.\nPlease provide the <original> document.";
        Mail::to('archer@example.com')->queue(new ArcherRegistrationDecisionMail(
            archerName: "Test O'Connor",
            registrationStatus: 'rejected',
            reference: 'REG-000001',
            rejectionReason: $reason,
        ));

        $message = Mail::mailer()->getSymfonyTransport()->messages()->first()->getOriginalMessage();
        $this->assertStringContainsString($reason, $message->getTextBody());
        $this->assertStringContainsString("Test O'Connor", $message->getTextBody());
        $this->assertStringContainsString('Name &amp; ID do not match.', $message->getHtmlBody());
        $this->assertStringContainsString('&lt;original&gt;', $message->getHtmlBody());
    }

    private function signIn(string $role = 'admin'): User
    {
        $user = User::create(['name' => 'Review Admin', 'email' => $role.'@example.com', 'password' => 'test-password', 'role' => $role]);
        $this->actingAs($user);

        return $user;
    }

    private function personal(): array
    {
        return ['name' => 'TestName', 'surname' => 'Archer', 'knownAs' => 'Test', 'dob' => '1995-05-20', 'nId' => 'TEST123', 'gender' => 'Female', 'hand' => 'Left', 'email' => 'archer@example.com', 'institute' => 'Test Institute'];
    }

    private function approval(): array
    {
        return $this->personal() + ['decision' => 'approve', 'ageCategory' => 'Adult', 'agegroupProficiency' => 'Adult', 'currentGradingDominant' => 'AS1', 'currentGradingWeak' => 'ANG', 'currentProficiency' => 'AS1'];
    }
}
