@extends('dashboard.app')
@section('content')
<main class="dashboard-content">
  <div class="container-fluid px-3 px-lg-4 py-4">
    <div class="page-heading">
      <div class="page-heading-copy">
        <span class="page-icon"><i class="bi bi-tags" aria-hidden="true"></i></span>
        <div>
          <p class="eyebrow mb-1">Category Management</p>
          <h1 class="h3 mb-1">Edit Category</h1>
          <p class="text-muted mb-0">Update category details</p>
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
        <form action="{{ route('categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
          @csrf
          @method('PUT')
          @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label">Name *</label>
              <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $category->name) }}" required>
              @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Slug</label>
              <input type="text" name="slug" class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug', $category->slug) }}">
              @error('slug')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label">Parent Category</label>
            <select name="parent_id" class="form-control @error('parent_id') is-invalid @enderror">
              <option value="">None (Top Level)</option>
              @foreach($parentCategories as $parent)
                <option value="{{ $parent->id }}" {{ old('parent_id', $category->parent_id) == $parent->id ? 'selected' : '' }}>{{ $parent->name }}</option>
              @endforeach
            </select>
            @error('parent_id')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="4">{{ old('description', $category->description) }}</textarea>
            @error('description')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          @if($category->image)
            <div class="mb-3">
              <label class="form-label">Current Image</label>
              <div>
                <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" class="img-thumbnail" style="max-width: 200px;">
              </div>
            </div>
          @endif
          <div class="mb-3">
            <label class="form-label">New Image</label>
            <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
            @error('image')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <div class="mb-3">
            <div class="form-check">
                <input type="checkbox"
                      name="is_active"
                      id="is_active"
                      value="1"
                      class="form-check-input"
                      {{ old('is_active', $category->is_active) ? 'checked' : '' }}>
                <label class="form-check-label" for="is_active">
                    Active
                </label>
            </div>

            @error('is_active')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>
          <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">
              <i class="bi bi-save" aria-hidden="true"></i> Update
            </button>
            <a href="{{ route('categories.index') }}" class="btn btn-secondary">Cancel</a>
          </div>
        </form>
      </div>
    </section>
  </div>
</main>
@endsection
