<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    use ActionLogTrait;

    public function __construct()
    {
        $this->middleware('auth:sanctum');
        $this->middleware('permission:user-list|user-create|user-edit|user-delete', ['only' => ['index','show']]);
        $this->middleware('permission:user-create', ['only' => ['store']]);
        $this->middleware('permission:user-edit', ['only' => ['update','setStatus']]);
        $this->middleware('permission:user-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $query = User::with(['company', 'location', 'roles'])->orderBy('id', 'desc');

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($w) use ($q) {
                $w->where('firstname', 'like', "%{$q}%")
                    ->orWhere('lastname', 'like', "%{$q}%")
                    ->orWhere('email', 'like', "%{$q}%")
                    ->orWhere('telephone', 'like', "%{$q}%");
            });
        }

        $perPage = (int) $request->input('per_page', 15);
        $users = $query->paginate($perPage);

        return response()->json($users);
    }

    public function store(Request $request)
    {
        $request->validate([
            'firstname' => 'required|string|max:100',
            'lastname' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'telephone' => 'required|unique:users,telephone',
            'password' => 'required|min:6',
            'company_id' => 'nullable|exists:companies,id',
            'company_location_id' => 'nullable|exists:company_locations,id',
            'roles' => 'nullable|array',
            'roles.*' => 'exists:roles,id',
            'status' => ['nullable', Rule::in(['active', 'inactive'])],
        ]);

        $user = User::create([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'telephone' => $request->telephone,
            'password' => Hash::make($request->password),
            'company_id' => $request->company_id,
            'company_location_id' => $request->company_location_id,
            'status' => $request->input('status', 'active'),
        ]);

        if ($request->filled('roles')) {
            $roleNames = Role::whereIn('id', $request->input('roles'))->pluck('name')->all();
            $user->syncRoles($roleNames);
        }

        $user->load(['company', 'location', 'roles']);

        Log::info('User created', array_merge($this->actionLogContext($request), ['user_id' => $user->id]));

        return response()->json([
            'message' => 'User created successfully',
            'user' => $user,
        ], 201);
    }

    public function show(User $user)
    {
        $user->load(['company', 'location', 'roles']);

        return response()->json(['user' => $user]);
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'firstname' => 'sometimes|required|string|max:100',
            'lastname' => 'sometimes|required|string|max:100',
            'email' => ['sometimes', 'required', 'email', Rule::unique('users', 'email')->ignore($user->id)],
            'telephone' => ['sometimes', 'required', Rule::unique('users', 'telephone')->ignore($user->id)],
            'password' => 'nullable|min:6',
            'company_id' => 'nullable|exists:companies,id',
            'company_location_id' => 'nullable|exists:company_locations,id',
            'roles' => 'nullable|array',
            'roles.*' => 'exists:roles,id',
            'status' => ['nullable', Rule::in(['active', 'inactive'])],
        ]);

        $data = $request->only(['firstname', 'lastname', 'email', 'telephone', 'company_id', 'company_location_id', 'status']);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        if ($request->filled('roles')) {
            $roleNames = Role::whereIn('id', $request->input('roles'))->pluck('name')->all();
            $user->syncRoles($roleNames);
        }

        $user->load(['company', 'location', 'roles']);

        Log::info('User updated', array_merge($this->actionLogContext($request), ['user_id' => $user->id]));

        return response()->json([
            'message' => 'User updated successfully',
            'user' => $user,
        ]);
    }

    public function setStatus(Request $request, User $user)
    {
        $request->validate([
            'status' => ['required', Rule::in(['active', 'inactive'])],
        ]);

        $user->status = $request->status;
        $user->save();

        Log::info('User status changed', array_merge($this->actionLogContext($request), ['user_id' => $user->id, 'status' => $request->status]));

        return response()->json([
            'message' => 'User status updated',
            'user' => $user,
        ]);
    }

    public function destroy(User $user)
    {
        $user->delete();

        Log::info('User deleted', array_merge($this->actionLogContext(), ['user_id' => $user->id]));

        return response()->json([
            'message' => 'User deleted successfully',
        ]);
    }
}

