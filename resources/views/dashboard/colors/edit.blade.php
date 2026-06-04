@extends('dashboard.app')
@section('content')
<main class="dashboard-content">
  <div class="container-fluid px-3 px-lg-4 py-4">
    <div class="page-heading">
      <div class="page-heading-copy">
        <span class="page-icon"><i class="bi bi-palette" aria-hidden="true"></i></span>
        <div>
          <p class="eyebrow mb-1">{{ __('messages.colors') }}</p>
          <h1 class="h3 mb-1">{{ __('messages.edit_color') }}</h1>
          <p class="text-muted mb-0">{{ __('messages.update_color') ?? 'Update color details' }}</p>
        </div>
      </div>
      <div class="heading-actions">
        <a class="btn btn-secondary btn-sm" href="{{ route('colors.index') }}">
          <i class="bi bi-arrow-left" aria-hidden="true"></i> {{ __('messages.back') }}
        </a>
      </div>
    </div>

    <section class="panel mt-3">
      <div class="panel-body">
        <form action="{{ route('colors.update', $color->id) }}" method="POST">
          @csrf
          @method('PUT')
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label">{{ __('messages.name') }} *</label>
              <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $color->name) }}" required>
              @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">{{ __('messages.code') }}</label>
              <input type="text" name="code" class="form-control @error('code') is-invalid @enderror" value="{{ old('code', $color->code) }}">
              @error('code')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label">{{ __('messages.sort_order') }}</label>
              <input type="number" name="sort_order" class="form-control @error('sort_order') is-invalid @enderror" value="{{ old('sort_order', $color->sort_order) }}">
              @error('sort_order')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-md-6 mb-3">
              <div class="form-check mt-4">
                <input type="checkbox" name="is_active" id="is_active" class="form-check-input" {{ old('is_active', $color->is_active) ? 'checked' : '' }}>
                <label class="form-check-label" for="is_active">{{ __('messages.is_active') }}</label>
              </div>
            </div>
          </div>
          <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">
              <i class="bi bi-save" aria-hidden="true"></i> {{ __('messages.update') }}
            </button>
            <a href="{{ route('colors.index') }}" class="btn btn-secondary">{{ __('messages.cancel') }}</a>
          </div>
        </form>
      </div>
    </section>
  </div>
</main>
@endsection
