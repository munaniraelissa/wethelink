<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\CompanyLocation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class AuthRegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_marks_user_pending_and_sends_approval_emails(): void
    {
        Mail::fake();
        putenv('SUPER_ADMIN_EMAIL=superadmin@example.com');

        $company = Company::create([
            'name' => 'Test Company',
            'slug' => 'test-company',
            'status' => 'active',
        ]);

        $location = CompanyLocation::create([
            'company_id' => $company->id,
            'name' => 'Head Office',
            'address' => '123 Test Street',
            'is_head_office' => true,
            'status' => 'active',
        ]);

        $response = $this->postJson('/api/register', [
            'firstname' => 'Jane',
            'lastname' => 'Doe',
            'email' => 'jane@example.com',
            'telephone' => '250788000000',
            'password' => 'secret123',
            'company_id' => $company->id,
            'company_location_id' => $location->id,
        ]);

        $response->assertStatus(200)
            ->assertJsonPath('requires_approval', true)
            ->assertJsonPath('message', 'Registration successful. Your account is pending approval.');

        $user = User::where('email', 'jane@example.com')->firstOrFail();
        $this->assertSame('pending', $user->status);

        Mail::assertQueued(\App\Mail\SuperAdminNewUserRegistrationMail::class);
        Mail::assertQueued(\App\Mail\UserPendingApprovalMail::class);
    }

    public function test_registration_succeeds_without_company_ids(): void
    {
        Mail::fake();

        $response = $this->postJson('/api/register', [
            'firstname' => 'John',
            'lastname' => 'Smith',
            'email' => 'john@example.com',
            'telephone' => '250788222222',
            'password' => 'secret123',
        ]);

        $response->assertStatus(200)
            ->assertJsonPath('requires_approval', true);

        $user = User::where('email', 'john@example.com')->firstOrFail();
        $this->assertNull($user->company_id);
        $this->assertNull($user->company_location_id);
    }
}
