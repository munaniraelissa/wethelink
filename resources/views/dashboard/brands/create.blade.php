@extends('dashboard.app')
@section('content')
<main class="dashboard-content">
  <div class="container-fluid px-3 px-lg-4 py-4">
    <div class="page-heading">
      <div class="page-heading-copy">
        <span class="page-icon"><i class="bi bi-building" aria-hidden="true"></i></span>
        <div>
          <p class="eyebrow mb-1">{{ __('messages.brand_management') }}</p>
          <h1 class="h3 mb-1">{{ __('messages.add_new_brand') }}</h1>
          <p class="text-muted mb-0">{{ __('messages.create_new_brand') }}</p>
        </div>
      </div>
      <div class="heading-actions">
        <a class="btn btn-secondary btn-sm" href="{{ route('brands.index') }}">
          <i class="bi bi-arrow-left" aria-hidden="true"></i> {{ __('messages.back') }}
        </a>
      </div>
    </div>

    @if ($errors->any())
      <div class="alert alert-danger">
        <ul>
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    @if ($message = Session::get('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>{{ __('messages.success') }}!</strong> {{ $message }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif

    <section class="panel mt-3">
      <div class="panel-body">
        <form action="{{ route('brands.store') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label">{{ __('messages.name') }} *</label>
              <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
              @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">{{ __('messages.slug') }}</label>
              <input type="text" name="slug" class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug') }}">
              @error('slug')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label">{{ __('messages.description') }}</label>
            <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="4">{{ old('description') }}</textarea>
            @error('description')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <div class="mb-3">
            <label class="form-label">{{ __('messages.logo') }}</label>
            <input type="file" name="logo" class="form-control @error('logo') is-invalid @enderror" accept="image/*">
            @error('logo')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <div class="mb-3">
            <div class="form-check">
              <input type="checkbox" name="is_active" id="is_active" class="form-check-input" value="1" {{ old('is_active') ? 'checked' : '' }}>
              <label class="form-check-label" for="is_active">{{ __('messages.active') }}</label>
            </div>
          </div>
          <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">
              <i class="bi bi-save" aria-hidden="true"></i> {{ __('messages.save') }}
            </button>
            <a href="{{ route('brands.index') }}" class="btn btn-secondary">{{ __('messages.cancel') }}</a>
          </div>
        </form>
      </div>
    </section>
  </div>
</main>
@endsection
