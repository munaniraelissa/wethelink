<?php

namespace Tests\Feature;

use App\Mail\AccountActivatedMail;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class AccountActivationMailTest extends TestCase
{
    use RefreshDatabase;

    public function testActivationSendsAnEmailToTheUser(): void
    {
        Mail::fake();

        $admin = User::create([
            'firstname' => 'System',
            'lastname' => 'Admin',
            'email' => 'admin@example.com',
            'telephone' => '2500000000',
            'password' => 'password123',
            'status' => 'active',
        ]);

        $user = User::create([
            'firstname' => 'Jane',
            'lastname' => 'Doe',
            'email' => 'jane@example.com',
            'telephone' => '2501111111',
            'password' => 'password123',
            'status' => 'pending',
        ]);

        $this->actingAs($admin);

        $response = $this->post(route('users.change-status', $user), [
            'status' => 'active',
        ]);

        $response->assertRedirect();
        Mail::assertQueued(AccountActivatedMail::class, function (AccountActivatedMail $mail) use ($user) {
            return $mail->hasTo($user->email);
        });
    }
}
