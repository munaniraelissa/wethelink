@extends('dashboard.app')

@section('content')
<div class="container-fluid">
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="page-title">{{ __('users.user_details') }}</h1>
                <p class="text-muted">{{ __('users.view_user_information') }}</p>
            </div>
            <div class="col-md-4 text-end">
                <a href="{{ route('users.edit', $user) }}" class="btn btn-warning">
                    <i class="bi bi-pencil"></i> {{ __('users.edit') }}
                </a>
                <a href="{{ route('users.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> {{ __('users.back') }}
                </a>
            </div>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-8">
            <!-- Personal Information -->
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="card-title">{{ __('users.personal_information') }}</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <p class="text-muted small mb-1">{{ __('users.firstname') }}</p>
                            <p class="fw-bold">{{ $user->firstname }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <p class="text-muted small mb-1">{{ __('users.lastname') }}</p>
                            <p class="fw-bold">{{ $user->lastname }}</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <p class="text-muted small mb-1">{{ __('users.othername') }}</p>
                            <p class="fw-bold">{{ $user->othername ?? '-' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <p class="text-muted small mb-1">{{ __('users.gender') }}</p>
                            <p class="fw-bold">{{ $user->gender ? __('users.gender_' . $user->gender) : '-' }}</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <p class="text-muted small mb-1">{{ __('users.date_of_birth') }}</p>
                            <p class="fw-bold">{{ $user->date_of_birth ? $user->date_of_birth->format('d M Y') : '-' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <p class="text-muted small mb-1">{{ __('users.id_number') }}</p>
                            <p class="fw-bold">{{ $user->id_number ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Information -->
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="card-title">{{ __('users.contact_information') }}</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <p class="text-muted small mb-1">{{ __('users.email') }}</p>
                            <p class="fw-bold">
                                <a href="mailto:{{ $user->email }}">{{ $user->email }}</a>
                            </p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <p class="text-muted small mb-1">{{ __('users.email_verified') }}</p>
                            <p class="fw-bold">
                                @if ($user->email_verified_at)
                                    <span class="badge bg-success">{{ __('users.verified') }}</span>
                                    <br>
                                    <small class="text-muted">{{ $user->email_verified_at->format('d M Y H:i') }}</small>
                                @else
                                    <span class="badge bg-warning">{{ __('users.not_verified') }}</span>
                                @endif
                            </p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <p class="text-muted small mb-1">{{ __('users.telephone') }}</p>
                            <p class="fw-bold">
                                <a href="tel:{{ $user->telephone }}">{{ $user->telephone }}</a>
                            </p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <p class="text-muted small mb-1">{{ __('users.alternative_phone') }}</p>
                            <p class="fw-bold">
                                @if ($user->alternative_phone)
                                    <a href="tel:{{ $user->alternative_phone }}">{{ $user->alternative_phone }}</a>
                                @else
                                    -
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Company Assignment -->
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="card-title">{{ __('users.company_assignment') }}</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted small mb-1">{{ __('users.company') }}</p>
                    <p class="fw-bold">
                        @if ($user->company)
                            <a href="#" class="badge bg-primary">{{ $user->company->name }}</a>
                        @else
                            <span class="badge bg-secondary">{{ __('users.not_assigned') }}</span>
                        @endif
                    </p>
                </div>
            </div>

            <!-- Roles and Permissions -->
            @if ($user->roles->count())
                <div class="card mb-3">
                    <div class="card-header">
                        <h5 class="card-title">{{ __('users.roles_and_permissions') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach ($user->roles as $role)
                                <div class="col-md-6 mb-2">
                                    <div class="badge bg-info p-2">
                                        <div class="fw-bold">{{ $role->name }}</div>
                                        @if ($role->permissions->count())
                                            <small class="d-block">{{ $role->permissions->count() }} {{ __('users.permissions') }}</small>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <div class="col-lg-4">
            <!-- User Avatar -->
            <div class="card mb-3">
                <div class="card-body text-center">
                    @if ($user->avatar)
                        <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->firstname }}" 
                             class="rounded-circle mb-3" style="width: 120px; height: 120px; object-fit: cover;">
                    @else
                        <div class="avatar rounded-circle bg-light d-flex align-items-center justify-content-center mx-auto mb-3" 
                             style="width: 120px; height: 120px; font-size: 48px;">
                            {{ strtoupper(substr($user->firstname, 0, 1)) }}
                        </div>
                    @endif
                    <h4 class="card-title">{{ $user->firstname }} {{ $user->lastname }}</h4>
                    <p class="text-muted">{{ $user->email }}</p>
                </div>
            </div>

            <!-- Account Status -->
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="card-title">{{ __('users.account_status') }}</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted small mb-2">{{ __('users.status') }}</p>
                    <p class="mb-3">
                        <span class="badge bg-{{ $user->status === 'active' ? 'success' : ($user->status === 'inactive' ? 'danger' : 'warning') }} p-2">
                            {{ __('users.status_' . $user->status) }}
                        </span>
                    </p>

                    <p class="text-muted small mb-1">{{ __('users.member_since') }}</p>
                    <p class="fw-bold mb-3">{{ $user->created_at->format('d M Y \a\t H:i') }}</p>

                    @if ($user->activated_at)
                        <p class="text-muted small mb-1">{{ __('users.activated_at') }}</p>
                        <p class="fw-bold mb-3">{{ $user->activated_at->format('d M Y \a\t H:i') }}</p>
                    @endif

                    @if ($user->last_login_at)
                        <p class="text-muted small mb-1">{{ __('users.last_login') }}</p>
                        <p class="fw-bold mb-3">{{ $user->last_login_at->format('d M Y \a\t H:i') }}</p>
                        <p class="text-muted small mb-1">{{ __('users.last_login_ip') }}</p>
                        <p class="fw-bold">{{ $user->last_login_ip ?? '-' }}</p>
                    @else
                        <p class="text-muted small">{{ __('users.never_logged_in') }}</p>
                    @endif
                </div>
            </div>

            <!-- Actions -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">{{ __('users.actions') }}</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('users.edit', $user) }}" class="btn btn-warning">
                            <i class="bi bi-pencil"></i> {{ __('users.edit_user') }}
                        </a>
                        <form method="POST" action="{{ route('users.destroy', $user) }}" 
                              onsubmit="return confirm('{{ __('users.confirm_delete') }}');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger w-100">
                                <i class="bi bi-trash"></i> {{ __('users.delete_user') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
