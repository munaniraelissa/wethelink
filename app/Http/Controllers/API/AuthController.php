<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    use ActionLogTrait;

    public function register(Request $request)
    {
        $request->validate([
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|email|unique:users',
            'telephone' => 'required|unique:users',
            'password' => 'required|min:6',

            'company_id' => 'required|exists:companies,id',
            'company_location_id' => 'required|exists:company_locations,id',
        ]);

        $user = User::create([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'telephone' => $request->telephone,
            'password' => Hash::make($request->password),

            'company_id' => $request->company_id,
            'company_location_id' => $request->company_location_id,

            'status' => 'active',
        ]);

        // Assign default role (buyer)
        $user->assignRole('buyer');

        $token = $user->createToken('api-token')->plainTextToken;

        Log::info('User registered', array_merge($this->actionLogContext($request), [
            'user_id' => $user->id,
            'email' => $user->email,
            'company_id' => $user->company_id,
            'company_location_id' => $user->company_location_id,
        ]));

        return response()->json([
            'message' => 'User registered successfully',
            'user' => $user,
            'token' => $token,
        ]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            Log::warning('Failed login attempt', array_merge($this->actionLogContext($request), [
                'email' => $request->email,
            ]));

            return response()->json([
                'message' => 'Invalid credentials',
            ], 401);
        }

        if ($user->status !== 'active') {
            Log::warning('Login denied for inactive user', array_merge($this->actionLogContext($request), [
                'user_id' => $user->id,
                'email' => $user->email,
                'status' => $user->status,
            ]));

            return response()->json([
                'message' => 'Account not active',
            ], 403);
        }

        $token = $user->createToken('api-token')->plainTextToken;

        Log::info('User logged in', array_merge($this->actionLogContext($request), [
            'user_id' => $user->id,
            'email' => $user->email,
        ]));

        return response()->json([
            'message' => 'Login successful',
            'user' => $user->load(['company', 'location', 'roles']),
            'token' => $token,
        ]);
    }

    public function logout(Request $request)
    {
        // Safely delete the current access token (Sanctum)
        $token = $request->user()->currentAccessToken();

        if ($token) {
            // help static analyzers by specifying the token type
            /* @var \Laravel\Sanctum\PersonalAccessToken $token */
            $token->delete();

            Log::info('User logged out', array_merge($this->actionLogContext($request), [
                'user_id' => $request->user()->id,
                'token_id' => $token->id,
            ]));
        } else {
            Log::warning('Logout called without active token', array_merge($this->actionLogContext($request), [
                'user_id' => optional($request->user())->id,
            ]));
        }

        return response()->json([
            'message' => 'Logged out successfully',
        ]);
    }

    public function me(Request $request)
    {
        return response()->json([
            'user' => $request->user()->load([
                'company',
                'location',
                'roles',
            ]),
        ]);
    }
}
