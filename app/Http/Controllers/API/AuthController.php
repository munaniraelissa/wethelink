<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Mail\SuperAdminNewUserRegistrationMail;
use App\Mail\UserPendingApprovalMail;
use App\Models\User;
use App\Models\Company;
use App\Models\CompanyLocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class AuthController extends Controller
{
    use ActionLogTrait;

    public function registerCompany(Request $request)
    {
        $validated = $request->validate([
            // Company Details
            'company_name' => 'required|string|max:255',
            'company_email' => 'nullable|email|max:255',
            'company_telephone' => 'nullable|string|max:100',
            'company_website' => 'nullable|url|max:255',
            'company_tax_number' => 'nullable|string|max:255',
            'company_registration_number' => 'nullable|string|max:255',
            'company_industry' => 'nullable|string|max:255',
            'company_credit_limit' => 'nullable|numeric|min:0',
            'company_payment_terms_days' => 'nullable|integer|min:0',

            // Company Location (Head Office) Details
            'location_name' => 'required|string|max:255',
            'location_email' => 'nullable|email|max:255',
            'location_telephone' => 'nullable|string|max:100',
            'location_manager_name' => 'nullable|string|max:255',
            'location_country' => 'nullable|string|max:100',
            'location_province' => 'nullable|string|max:100',
            'location_district' => 'nullable|string|max:100',
            'location_city' => 'nullable|string|max:100',
            'location_address' => 'required|string|max:500',
            'location_latitude' => 'nullable|numeric|between:-90,90',
            'location_longitude' => 'nullable|numeric|between:-180,180',

            // Admin User Details
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|email|unique:users|max:255',
            'telephone' => 'required|unique:users|string|max:100',
            'password' => 'required|string|min:6|max:255',
        ]);

        try {
            return DB::transaction(function () use ($validated, $request) {
                // Create the company
                $company = Company::create([
                    'name' => $validated['company_name'],
                    'slug' => Str::slug($validated['company_name']),
                    'email' => $validated['company_email'] ?? null,
                    'telephone' => $validated['company_telephone'] ?? null,
                    'website' => $validated['company_website'] ?? null,
                    'tax_number' => $validated['company_tax_number'] ?? null,
                    'registration_number' => $validated['company_registration_number'] ?? null,
                    'industry' => $validated['company_industry'] ?? null,
                    'credit_limit' => $validated['company_credit_limit'] ?? 0,
                    'payment_terms_days' => $validated['company_payment_terms_days'] ?? 0,
                    'status' => 'pending',
                ]);

                // Create the company location (head office)
                $location = CompanyLocation::create([
                    'company_id' => $company->id,
                    'name' => $validated['location_name'],
                    'email' => $validated['location_email'] ?? null,
                    'telephone' => $validated['location_telephone'] ?? null,
                    'manager_name' => $validated['location_manager_name'] ?? null,
                    'country' => $validated['location_country'] ?? null,
                    'province' => $validated['location_province'] ?? null,
                    'district' => $validated['location_district'] ?? null,
                    'city' => $validated['location_city'] ?? null,
                    'address' => $validated['location_address'],
                    'latitude' => $validated['location_latitude'] ?? null,
                    'longitude' => $validated['location_longitude'] ?? null,
                    'is_head_office' => true,
                    'status' => 'active',
                ]);

                // Create the admin user
                $user = User::create([
                    'company_id' => $company->id,
                    'company_location_id' => $location->id,
                    'firstname' => $validated['firstname'],
                    'lastname' => $validated['lastname'],
                    'email' => $validated['email'],
                    'telephone' => $validated['telephone'],
                    'password' => Hash::make($validated['password']),
                    'status' => 'active',
                ]);

                // Assign admin role
                $user->assignRole('admin');

                // Create API token
                $token = $user->createToken('api-token')->plainTextToken;

                Log::info('Company registered successfully', array_merge($this->actionLogContext($request), [
                    'company_id' => $company->id,
                    'company_name' => $company->name,
                    'user_id' => $user->id,
                    'user_email' => $user->email,
                    'location_id' => $location->id,
                ]));

                return response()->json([
                    'message' => 'Company registered successfully',
                    'company' => $company->load('locations'),
                    'location' => $location,
                    'user' => $user->load(['company', 'location', 'roles']),
                    'token' => $token,
                ], 201);
            });
        } catch (\Exception $e) {
            Log::error('Company registration failed', array_merge($this->actionLogContext($request), [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]));

            return response()->json([
                'message' => 'Company registration failed',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function register(Request $request)
    {
        $request->validate([
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|email|unique:users',
            'telephone' => 'required|unique:users',
            'password' => 'required|min:6',

            'company_id' => 'nullable|exists:companies,id',
            'company_location_id' => 'nullable|exists:company_locations,id',
        ]);

        $user = User::create([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'telephone' => $request->telephone,
            'password' => Hash::make($request->password),

            'company_id' => $request->company_id ?? null,
            'company_location_id' => $request->company_location_id ?? null,

            'status' => 'pending',
        ]);

        // Assign default role (buyer)
        $buyerRole = Role::firstOrCreate(['name' => 'supplier', 'guard_name' => 'web']);
        $user->assignRole($buyerRole);

        $superAdminEmail = env('SUPER_ADMIN_EMAIL', config('app.super_admin_email'));
        $superAdminPhone = config('app.super_admin_phone', '+250788565520');
        $signupPendingMessage = config('app.signup_pending_message', 'Registration successful. Your account is pending approval.');

        try {
            if (!empty($superAdminEmail)) {
                Mail::to($superAdminEmail)->send(new SuperAdminNewUserRegistrationMail($user, $signupPendingMessage));
                Log::info('Super admin notification email sent', ['user_id' => $user->id, 'admin_email' => $superAdminEmail]);
            }
        } catch (\Exception $e) {
            Log::error('Failed to send super admin notification email', ['user_id' => $user->id, 'error' => $e->getMessage()]);
        }

        try {
            Mail::to($user->email)->send(new UserPendingApprovalMail($user, $signupPendingMessage));
            Log::info('User pending approval email sent', ['user_id' => $user->id, 'user_email' => $user->email]);
        } catch (\Exception $e) {
            Log::error('Failed to send user pending approval email', ['user_id' => $user->id, 'error' => $e->getMessage()]);
        }

        $token = $user->createToken('api-token')->plainTextToken;

        Log::info('User registered', array_merge($this->actionLogContext($request), [
            'user_id' => $user->id,
            'email' => $user->email,
            'company_id' => $user->company_id,
            'company_location_id' => $user->company_location_id,
        ]));

        return response()->json([
            'message' => $signupPendingMessage,
            'requires_approval' => true,
            'user' => $user,
            'token' => $token,
            'admin_phone' => $superAdminPhone,
            'signup_message' => $signupPendingMessage,
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
