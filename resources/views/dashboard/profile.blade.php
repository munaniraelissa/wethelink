@extends('dashboard.app')

@section('content')
<main class="dashboard-content">
  <div class="container-fluid px-3 px-lg-4 py-4">
    <div class="page-heading">
      <div class="page-heading-copy">
        <span class="page-icon"><i class="bi bi-person-badge" aria-hidden="true"></i></span>
        <div>
          <p class="eyebrow mb-1">{{ __('users.account') }}</p>
          <h1 class="h3 mb-1">{{ __('users.profile') }}</h1>
          <p class="text-muted mb-0">{{ __('users.manage_profile_details') }}</p>
        </div>
      </div>
    </div>

    @if (session('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif

    @if ($errors->any())
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>{{ __('users.validation_error') }}</strong>
        <ul class="mb-0">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif

    <section class="row g-3">
      <div class="col-12 col-xl-4">
        <div class="panel h-100 text-center profile-card">
          <img class="avatar-img avatar-xl profile-photo" src="{{ $user->avatar ? asset('storage/' . $user->avatar) : 'https://via.placeholder.com/150' }}" alt="{{ $user->firstname }} {{ $user->lastname }}" style="width: 120px; height: 120px; object-fit: cover;">
          <h2 class="h5 mt-3 mb-1">{{ $user->firstname }} {{ $user->lastname }}</h2>
          <p class="text-muted mb-3">{{ $user->email }}</p>
          @if ($user->roles->count())
            <div class="d-flex justify-content-center gap-2 flex-wrap">
              @foreach ($user->roles as $role)
                <span class="badge text-bg-primary">{{ $role->name }}</span>
              @endforeach
            </div>
          @endif
          <div class="info-list mt-4 text-start">
            <div><span>{{ __('users.email') }}</span><strong>{{ $user->email }}</strong></div>
            <div><span>{{ __('users.telephone') }}</span><strong>{{ $user->telephone }}</strong></div>
            <div><span>{{ __('users.status') }}</span><strong><span class="badge bg-{{ $user->status === 'active' ? 'success' : 'warning' }}">{{ __('users.status_' . $user->status) }}</span></strong></div>
          </div>
        </div>
      </div>

      <div class="col-12 col-xl-8">
        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="panel">
          @csrf
          @method('PUT')

          <div class="panel-header">
            <div>
              <h2 class="h5 mb-1 section-title"><i class="bi bi-person-gear" aria-hidden="true"></i><span>{{ __('users.profile_settings') }}</span></h2>
              <p class="text-muted mb-0">{{ __('users.update_profile_info') }}</p>
            </div>
          </div>

          <!-- Personal Information -->
          <div class="card mb-3">
            <div class="card-header">
              <h5 class="card-title">{{ __('users.personal_information') }}</h5>
            </div>
            <div class="card-body">
              <div class="row g-3">
                <div class="col-md-6">
                  <label class="form-label" for="firstname">{{ __('users.firstname') }}</label>
                  <input class="form-control @error('firstname') is-invalid @enderror" id="firstname" type="text" name="firstname" value="{{ $user->firstname }}" required>
                  @error('firstname')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                <div class="col-md-6">
                  <label class="form-label" for="lastname">{{ __('users.lastname') }}</label>
                  <input class="form-control @error('lastname') is-invalid @enderror" id="lastname" type="text" name="lastname" value="{{ $user->lastname }}" required>
                  @error('lastname')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                <div class="col-md-6">
                  <label class="form-label" for="othername">{{ __('users.othername') }}</label>
                  <input class="form-control @error('othername') is-invalid @enderror" id="othername" type="text" name="othername" value="{{ $user->othername }}">
                  @error('othername')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                <div class="col-md-6">
                  <label class="form-label" for="gender">{{ __('users.gender') }}</label>
                  <select class="form-select @error('gender') is-invalid @enderror" id="gender" name="gender">
                    <option value="">{{ __('users.select_gender') }}</option>
                    <option value="male" {{ $user->gender === 'male' ? 'selected' : '' }}>{{ __('users.gender_male') }}</option>
                    <option value="female" {{ $user->gender === 'female' ? 'selected' : '' }}>{{ __('users.gender_female') }}</option>
                    <option value="other" {{ $user->gender === 'other' ? 'selected' : '' }}>{{ __('users.gender_other') }}</option>
                  </select>
                  @error('gender')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                <div class="col-md-6">
                  <label class="form-label" for="date_of_birth">{{ __('users.date_of_birth') }}</label>
                  <input class="form-control @error('date_of_birth') is-invalid @enderror" id="date_of_birth" type="date" name="date_of_birth" value="{{ $user->date_of_birth ? $user->date_of_birth->format('Y-m-d') : '' }}">
                  @error('date_of_birth')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                <div class="col-md-6">
                  <label class="form-label" for="id_number">{{ __('users.id_number') }}</label>
                  <input class="form-control @error('id_number') is-invalid @enderror" id="id_number" type="text" name="id_number" value="{{ $user->id_number }}">
                  @error('id_number')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
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
              <div class="row g-3">
                <div class="col-md-6">
                  <label class="form-label" for="email">{{ __('users.email') }}</label>
                  <input class="form-control @error('email') is-invalid @enderror" id="email" type="email" name="email" value="{{ $user->email }}" required>
                  @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                <div class="col-md-6">
                  <label class="form-label" for="telephone">{{ __('users.telephone') }}</label>
                  <input class="form-control @error('telephone') is-invalid @enderror" id="telephone" type="tel" name="telephone" value="{{ $user->telephone }}" required>
                  @error('telephone')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                <div class="col-md-6">
                  <label class="form-label" for="alternative_phone">{{ __('users.alternative_phone') }}</label>
                  <input class="form-control @error('alternative_phone') is-invalid @enderror" id="alternative_phone" type="tel" name="alternative_phone" value="{{ $user->alternative_phone }}">
                  @error('alternative_phone')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>
            </div>
          </div>

          <!-- Avatar Upload -->
          <div class="card mb-3">
            <div class="card-header">
              <h5 class="card-title">{{ __('users.profile_photo') }}</h5>
            </div>
            <div class="card-body">
              <div class="row g-3">
                <div class="col-12">
                  <label class="form-label" for="avatar">{{ __('users.choose_avatar') }}</label>
                  <input class="form-control @error('avatar') is-invalid @enderror" id="avatar" type="file" name="avatar" accept="image/*">
                  <small class="form-text text-muted">{{ __('users.max_file_size') }}</small>
                  @error('avatar')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                  @enderror
                </div>
              </div>
            </div>
          </div>

          <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('dashboard.index') }}" class="btn btn-secondary">
              <i class="bi bi-x-circle" aria-hidden="true"></i> {{ __('dashboard.common.cancel') }}
            </a>
            <button class="btn btn-primary" type="submit">
              <i class="bi bi-check2-circle" aria-hidden="true"></i> {{ __('dashboard.common.save') }}
            </button>
          </div>
        </form>
      </div>
    </section>
  </div>
</main>
@endsection
