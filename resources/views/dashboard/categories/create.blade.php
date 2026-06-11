@extends('dashboard.app')
@section('content')
<main class="dashboard-content">
  <div class="container-fluid px-3 px-lg-4 py-4">
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="page-heading">
      <div class="page-heading-copy">
        <span class="page-icon"><i class="bi bi-tags" aria-hidden="true"></i></span>
        <div>
          <p class="eyebrow mb-1">{{ __('dashboard.categories.management') }}</p>
          <h1 class="h3 mb-1">{{ __('dashboard.categories.add_new_category') }}</h1>
          <p class="text-muted mb-0">{{ __('dashboard.categories.create_category_desc') }}</p>
        </div>
      </div>
      <div class="heading-actions">
        <a class="btn btn-secondary btn-sm" href="{{ route('categories.index') }}">
          <i class="bi bi-arrow-left" aria-hidden="true"></i> Back
        </a>
      </div>
    </div>

    <section class="panel mt-3">
      <div class="panel-body">
        <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label">{{ __('dashboard.categories.name') }} *</label>
              <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
              @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">{{ __('dashboard.categories.slug') }}</label>
              <input type="text" name="slug" class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug') }}">
              @error('slug')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label">{{ __('dashboard.categories.parent_category') }}</label>
            <select name="parent_id" class="form-control @error('parent_id') is-invalid @enderror">
              <option value="">{{ __('dashboard.categories.none_top_level') }}</option>
              @foreach($parentCategories as $parent)
                <option value="{{ $parent->id }}" {{ old('parent_id') == $parent->id ? 'selected' : '' }}>{{ $parent->name }}</option>
              @endforeach
            </select>
            @error('parent_id')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <div class="mb-3">
            <label class="form-label">{{ __('dashboard.categories.description') }}</label>
            <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="4">{{ old('description') }}</textarea>
            @error('description')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <div class="mb-3">
            <label class="form-label">{{ __('dashboard.categories.image') }}</label>
            <input type="file" name="image" id="image-input" class="form-control @error('image') is-invalid @enderror" accept="image/*">
            @error('image')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <div class="mt-2" id="image-preview-container" style="display: none;">
                <label class="form-label">{{ __('dashboard.categories.image_preview') }}</label><br>
                <img id="image-preview" src="#" alt="Image Preview" style="max-width: 200px; height: auto; border: 1px solid #ddd; padding: 5px; border-radius: 4px;">
            </div>
          </div>
          <div class="mb-3">
            <div class="form-check">
              <input type="checkbox" name="is_active" id="is_active" value="1" class="form-check-input" {{ old('is_active') ? 'checked' : '' }}>
              <label class="form-check-label" for="is_active">{{ __('dashboard.categories.active') }}</label>
            </div>
          </div>
          <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">
              <i class="bi bi-save" aria-hidden="true"></i> {{ __('dashboard.common.save') }}
            </button>
            <a href="{{ route('categories.index') }}" class="btn btn-secondary">{{ __('dashboard.common.cancel') }}</a>
          </div>
        </form>
      </div>
    </section>
  </div>
</main>

<script>
    document.getElementById('image-input').addEventListener('change', function(event) {
        const [file] = event.target.files;
        const preview = document.getElementById('image-preview');
        const previewContainer = document.getElementById('image-preview-container');

        if (file) {
            preview.src = URL.createObjectURL(file);
            previewContainer.style.display = 'block';
        } else {
            preview.src = '#';
            previewContainer.style.display = 'none';
        }
    });
</script>
@endsection
