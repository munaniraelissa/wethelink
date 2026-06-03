@extends('dashboard.app')

@section('content')
<div class="container-fluid">
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="page-title">{{ __('users.edit_user') }}</h1>
                <p class="text-muted">{{ __('users.update_user_details') }}</p>
            </div>
            <div class="col-md-4 text-end">
                <a href="{{ route('users.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> {{ __('users.back') }}
                </a>
            </div>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>{{ __('users.error') }}!</strong>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">{{ $user->firstname }} {{ $user->lastname }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('users.update', $user) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Personal Information -->
                        <div class="mb-4">
                            <h6 class="fw-bold text-primary mb-3">{{ __('users.personal_information') }}</h6>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="firstname" class="form-label">{{ __('users.firstname') }} *</label>
                                    <input type="text" class="form-control @error('firstname') is-invalid @enderror" 
                                           id="firstname" name="firstname" value="{{ old('firstname', $user->firstname) }}" required>
                                    @error('firstname')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="lastname" class="form-label">{{ __('users.lastname') }} *</label>
                                    <input type="text" class="form-control @error('lastname') is-invalid @enderror" 
                                           id="lastname" name="lastname" value="{{ old('lastname', $user->lastname) }}" required>
                                    @error('lastname')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="othername" class="form-label">{{ __('users.othername') }}</label>
                                    <input type="text" class="form-control @error('othername') is-invalid @enderror" 
                                           id="othername" name="othername" value="{{ old('othername', $user->othername) }}">
                                    @error('othername')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="gender" class="form-label">{{ __('users.gender') }}</label>
                                    <select class="form-select @error('gender') is-invalid @enderror" 
                                            id="gender" name="gender">
                                        <option value="">{{ __('users.select_gender') }}</option>
                                        @foreach ($genders as $gender)
                                            <option value="{{ $gender }}" {{ old('gender', $user->gender) === $gender ? 'selected' : '' }}>
                                                {{ __('users.gender_' . $gender) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('gender')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="date_of_birth" class="form-label">{{ __('users.date_of_birth') }}</label>
                                    <input type="date" class="form-control @error('date_of_birth') is-invalid @enderror" 
                                           id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth', $user->date_of_birth) }}">
                                    @error('date_of_birth')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="id_number" class="form-label">{{ __('users.id_number') }}</label>
                                    <input type="text" class="form-control @error('id_number') is-invalid @enderror" 
                                           id="id_number" name="id_number" value="{{ old('id_number', $user->id_number) }}">
                                    @error('id_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Contact Information -->
                        <div class="mb-4">
                            <h6 class="fw-bold text-primary mb-3">{{ __('users.contact_information') }}</h6>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">{{ __('users.email') }} *</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                           id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="telephone" class="form-label">{{ __('users.telephone') }} *</label>
                                    <input type="tel" class="form-control @error('telephone') is-invalid @enderror" 
                                           id="telephone" name="telephone" value="{{ old('telephone', $user->telephone) }}" required>
                                    @error('telephone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="alternative_phone" class="form-label">{{ __('users.alternative_phone') }}</label>
                                <input type="tel" class="form-control @error('alternative_phone') is-invalid @enderror" 
                                       id="alternative_phone" name="alternative_phone" value="{{ old('alternative_phone', $user->alternative_phone) }}">
                                @error('alternative_phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Company Assignment -->
                        <div class="mb-4">
                            <h6 class="fw-bold text-primary mb-3">{{ __('users.company_assignment') }}</h6>
                            
                            <div class="mb-3">
                                <label for="company_id" class="form-label">{{ __('users.company') }}</label>
                                <select class="form-select @error('company_id') is-invalid @enderror" 
                                        id="company_id" name="company_id">
                                    <option value="">{{ __('users.select_company') }}</option>
                                    @foreach ($companies as $company)
                                        <option value="{{ $company->id }}" {{ old('company_id', $user->company_id) == $company->id ? 'selected' : '' }}>
                                            {{ $company->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('company_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Authentication -->
                        <div class="mb-4">
                            <h6 class="fw-bold text-primary mb-3">{{ __('users.authentication') }}</h6>
                            
                            <div class="alert alert-info">
                                <small>{{ __('users.leave_password_blank') }}</small>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="password" class="form-label">{{ __('users.password') }}</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                           id="password" name="password">
                                    <small class="form-text text-muted">{{ __('users.password_min_8') }}</small>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="password_confirmation" class="form-label">{{ __('users.confirm_password') }}</label>
                                    <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" 
                                           id="password_confirmation" name="password_confirmation">
                                    @error('password_confirmation')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Status and Roles -->
                        <div class="mb-4">
                            <h6 class="fw-bold text-primary mb-3">{{ __('users.account_settings') }}</h6>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="status" class="form-label">{{ __('users.status') }} *</label>
                                    <select class="form-select @error('status') is-invalid @enderror" 
                                            id="status" name="status" required>
                                        <option value="">{{ __('users.select_status') }}</option>
                                        @foreach ($statuses as $status)
                                            <option value="{{ $status }}" {{ old('status', $user->status) === $status ? 'selected' : '' }}>
                                                {{ __('users.status_' . $status) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">{{ __('users.roles') }}</label>
                                <div class="border rounded p-3">
                                    @forelse ($roles as $role)
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="role_{{ $role->id }}" 
                                                   name="roles[]" value="{{ $role->id }}" 
                                                   {{ in_array($role->id, old('roles', $userRoles)) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="role_{{ $role->id }}">
                                                {{ $role->name }}
                                            </label>
                                        </div>
                                    @empty
                                        <p class="text-muted mb-0">{{ __('users.no_roles_available') }}</p>
                                    @endforelse
                                </div>
                                @error('roles')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-0">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle"></i> {{ __('users.update_user') }}
                            </button>
                            <a href="{{ route('users.show', $user) }}" class="btn btn-secondary">
                                {{ __('users.cancel') }}
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="card-title">{{ __('users.account_information') }}</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted small">
                        <strong>{{ __('users.member_since') }}:</strong><br>
                        {{ $user->created_at->format('d M Y \a\t H:i') }}
                    </p>
                    <p class="text-muted small">
                        <strong>{{ __('users.last_updated') }}:</strong><br>
                        {{ $user->updated_at->format('d M Y \a\t H:i') }}
                    </p>
                    @if ($user->last_login_at)
                        <p class="text-muted small">
                            <strong>{{ __('users.last_login') }}:</strong><br>
                            {{ $user->last_login_at->format('d M Y \a\t H:i') }}
                        </p>
                    @endif
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">{{ __('users.information') }}</h5>
                </div>
                <div class="card-body text-muted small">
                    <p><strong>{{ __('users.required_fields') }}:</strong> {{ __('users.marked_with_asterisk') }}</p>
                    <hr>
                    <p>
                        <strong>{{ __('users.password') }}:</strong><br>
                        {{ __('users.password_info') }}
                    </p>
                    <hr>
                    <p>
                        <strong>{{ __('users.user_status') }}:</strong><br>
                        <ul class="ps-3 mb-0">
                            <li><strong>pending:</strong> {{ __('users.pending_info') }}</li>
                            <li><strong>active:</strong> {{ __('users.active_info') }}</li>
                            <li><strong>inactive:</strong> {{ __('users.inactive_info') }}</li>
                            <li><strong>suspended:</strong> {{ __('users.suspended_info') }}</li>
                        </ul>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
