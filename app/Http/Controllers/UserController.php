<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Company;
use App\Models\CompanyLocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use App\Mail\AccountActivatedMail;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        abort_if(!auth()->user()?->can('user-list'), 403);

        $query = User::with(['company', 'roles'])->orderBy('id', 'desc');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('firstname', 'like', "%{$search}%")
                    ->orWhere('lastname', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('telephone', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('company_id')) {
            $query->where('company_id', $request->company_id);
        }

        $users = $query->paginate(15);
        $companies = Company::all();
        $statuses = ['pending', 'active', 'inactive', 'suspended'];

        return view('dashboard.users.index', compact('users', 'companies', 'statuses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort_if(!auth()->user()?->can('user-create'), 403);

        $companies = Company::all();
        $roles = Role::query()
            ->orderByRaw("CASE WHEN name = 'Super Admin' THEN 0 ELSE 1 END")
            ->orderBy('name', 'ASC')
            ->get();
        $genders = ['male', 'female', 'other'];
        $statuses = ['pending', 'active', 'inactive', 'suspended'];

        return view('dashboard.users.create', compact('companies', 'roles', 'genders', 'statuses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        abort_if(!auth()->user()?->can('user-create'), 403);

        $validated = $request->validate([
            'firstname' => 'required|string|max:100',
            'lastname' => 'required|string|max:100',
            'othername' => 'nullable|string|max:100',
            'email' => 'required|email|unique:users,email',
            'telephone' => 'required|unique:users,telephone',
            'alternative_phone' => 'nullable|string|max:20',
            'password' => 'required|string|min:8|confirmed',
            'company_id' => 'nullable|exists:companies,id',
            'gender' => 'nullable|in:male,female,other',
            'date_of_birth' => 'nullable|date',
            'id_number' => 'nullable|unique:users,id_number',
            'status' => 'required|in:pending,active,inactive,suspended',
            'roles' => 'nullable|array',
            'roles.*' => 'exists:roles,id',
        ]);

        $user = User::create([
            'firstname' => $validated['firstname'],
            'lastname' => $validated['lastname'],
            'othername' => $validated['othername'] ?? null,
            'email' => $validated['email'],
            'telephone' => $validated['telephone'],
            'alternative_phone' => $validated['alternative_phone'] ?? null,
            'password' => Hash::make($validated['password']),
            'company_id' => $validated['company_id'] ?? null,
            'gender' => $validated['gender'] ?? null,
            'date_of_birth' => $validated['date_of_birth'] ?? null,
            'id_number' => $validated['id_number'] ?? null,
            'status' => $validated['status'],
            'activated_at' => $validated['status'] === 'active' ? now() : null,
        ]);

        if (!empty($validated['roles'])) {
            $roleNames = Role::whereIn('id', $validated['roles'])->pluck('name')->all();
            $user->syncRoles($roleNames);
        }

        return redirect()->route('users.show', $user)
                        ->with('success', __('users.user_created_successfully'));
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        abort_if(!auth()->user()?->can('user-list'), 403);

        $user->load(['company', 'roles']);

        return view('dashboard.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        abort_if(!auth()->user()?->can('user-edit'), 403);

        $companies = Company::all();
        $roles = Role::query()
            ->orderByRaw("CASE WHEN name = 'Super Admin' THEN 0 ELSE 1 END")
            ->orderBy('name', 'ASC')
            ->get();
        $genders = ['male', 'female', 'other'];
        $statuses = ['pending', 'active', 'inactive', 'suspended'];
        $userRoles = $user->roles->pluck('id')->toArray();

        return view('dashboard.users.edit', compact('user', 'companies', 'roles', 'genders', 'statuses', 'userRoles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        abort_if(!auth()->user()?->can('user-edit'), 403);

        $validated = $request->validate([
            'firstname' => 'required|string|max:100',
            'lastname' => 'required|string|max:100',
            'othername' => 'nullable|string|max:100',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'telephone' => ['required', Rule::unique('users')->ignore($user->id)],
            'alternative_phone' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:8|confirmed',
            'company_id' => 'nullable|exists:companies,id',
            'gender' => 'nullable|in:male,female,other',
            'date_of_birth' => 'nullable|date',
            'id_number' => ['nullable', Rule::unique('users')->ignore($user->id)],
            'status' => 'required|in:pending,active,inactive,suspended',
            'roles' => 'nullable|array',
            'roles.*' => 'exists:roles,id',
        ]);

        $updateData = [
            'firstname' => $validated['firstname'],
            'lastname' => $validated['lastname'],
            'othername' => $validated['othername'] ?? null,
            'email' => $validated['email'],
            'telephone' => $validated['telephone'],
            'alternative_phone' => $validated['alternative_phone'] ?? null,
            'company_id' => $validated['company_id'] ?? null,
            'gender' => $validated['gender'] ?? null,
            'date_of_birth' => $validated['date_of_birth'] ?? null,
            'id_number' => $validated['id_number'] ?? null,
            'status' => $validated['status'],
        ];

        if ($validated['password']) {
            $updateData['password'] = Hash::make($validated['password']);
        }

        if ($validated['status'] === 'active' && !$user->activated_at) {
            $updateData['activated_at'] = now();
        }

        $user->update($updateData);

        if (isset($validated['roles'])) {
            $roleNames = Role::whereIn('id', $validated['roles'])->pluck('name')->all();
            $user->syncRoles($roleNames);
        }

        return redirect()->route('users.show', $user)
                        ->with('success', __('users.user_updated_successfully'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        abort_if(!auth()->user()?->can('user-delete'), 403);

        $user->delete();

        return redirect()->route('users.index')
                        ->with('success', __('users.user_deleted_successfully'));
    }

    /**
     * Change user status
     */
    public function changeStatus(Request $request, User $user)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,active,inactive,suspended',
        ]);

        $wasActivated = $validated['status'] === 'active' && $user->status !== 'active';

        $user->update([
            'status' => $validated['status'],
            'activated_at' => $validated['status'] === 'active' && !$user->activated_at ? now() : $user->activated_at,
        ]);

        if ($wasActivated) {
            Mail::to($user->email)->send(new AccountActivatedMail($user));
        }

        return redirect()->back()
                        ->with('success', __('users.user_status_updated'));
    }

    /**
     * Restore a deleted user
     */
    public function restore($id)
    {
        $user = User::onlyTrashed()->findOrFail($id);
        $user->restore();

        return redirect()->route('users.index')
                        ->with('success', __('users.user_restored_successfully'));
    }

    /**
     * Update authenticated user profile
     */
    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'firstname' => 'required|string|max:100',
            'lastname' => 'required|string|max:100',
            'othername' => 'nullable|string|max:100',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'telephone' => ['required', Rule::unique('users')->ignore($user->id)],
            'alternative_phone' => 'nullable|string|max:20',
            'gender' => 'nullable|in:male,female,other',
            'date_of_birth' => 'nullable|date',
            'id_number' => ['nullable', Rule::unique('users')->ignore($user->id)],
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $updateData = [
            'firstname' => $validated['firstname'],
            'lastname' => $validated['lastname'],
            'othername' => $validated['othername'] ?? null,
            'email' => $validated['email'],
            'telephone' => $validated['telephone'],
            'alternative_phone' => $validated['alternative_phone'] ?? null,
            'gender' => $validated['gender'] ?? null,
            'date_of_birth' => $validated['date_of_birth'] ?? null,
            'id_number' => $validated['id_number'] ?? null,
        ];

        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($user->avatar);
            }
            $updateData['avatar'] = \App\Support\ImageOptimizer::optimizePublic($request->file('avatar')->store('avatars', 'public'));
        }

        $user->update($updateData);

        return redirect()->route('profile')
                        ->with('success', __('users.profile_updated_successfully'));
    }

    public function updatePassword(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'current_password' => ['required', function ($attribute, $value, $fail) use ($user) {
                if (!Hash::check($value, $user->password)) {
                    $fail(__('users.current_password_incorrect'));
                }
            }],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('profile')
            ->with('success', __('users.password_updated_successfully'));
    }
}
