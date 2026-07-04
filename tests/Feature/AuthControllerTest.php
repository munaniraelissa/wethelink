<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testInactiveUserCannotLogInAndSeesActivationMessage(): void
    {
        $user = User::create([
            'firstname' => 'Jane',
            'lastname' => 'Doe',
            'email' => 'jane@example.com',
            'telephone' => '2501111111',
            'password' => Hash::make('password123'),
            'status' => 'pending',
        ]);

        $response = $this->from(route('login'))->post(route('login.submit'), [
            'email' => $user->email,
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('login'));
        $response->assertSessionHas('inactive_account');
        $this->assertGuest();
    }
}
