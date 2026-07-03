@extends('dashboard.app')

@section('content')
<div class="container-fluid px-3 px-lg-4 py-4">
    <div class="page-heading d-flex justify-content-between align-items-center">
        <div class="page-heading-copy">
            <span class="page-icon"><i class="bi bi-stars" aria-hidden="true"></i></span>
            <div>
                <p class="eyebrow mb-1">Content</p>
                <h1 class="h3 mb-1">Homepage Features</h1>
                <p class="text-muted mb-0">Update the featured cards shown on the storefront homepage.</p>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('dashboard.homepage-features.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row g-4">
            <div class="col-12">
                <div class="panel">
                    <div class="panel-header">
                        <div>
                            <h2 class="h5 mb-1 section-title"><i class="bi bi-stars" aria-hidden="true"></i><span>Homepage Features</span></h2>
                            <p class="text-muted mb-0">Manage the small feature cards shown below the hero section.</p>
                        </div>
                    </div>
                    <div class="row g-4">
                        @foreach($features as $index => $feature)
                            <div class="col-12 col-lg-6">
                                <div class="border rounded p-3 h-100">
                                    <div class="mb-3">
                                        <label class="form-label">Title</label>
                                        <input type="text" name="features[{{ $index }}][title]" class="form-control" value="{{ old('features.' . $index . '.title', $feature->title) }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Icon class</label>
                                        <input type="text" name="features[{{ $index }}][icon_class]" class="form-control" value="{{ old('features.' . $index . '.icon_class', $feature->icon_class) }}" placeholder="fa fa-check">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Description</label>
                                        <textarea name="features[{{ $index }}][description]" class="form-control" rows="3">{{ old('features.' . $index . '.description', $feature->description) }}</textarea>
                                    </div>
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Sort order</label>
                                            <input type="number" name="features[{{ $index }}][sort_order]" class="form-control" value="{{ old('features.' . $index . '.sort_order', $feature->sort_order) }}">
                                        </div>
                                        <div class="col-md-6 d-flex align-items-end">
                                            <label class="form-check-label">
                                                <input type="hidden" name="features[{{ $index }}][is_active]" value="0">
                                                <input type="checkbox" name="features[{{ $index }}][is_active]" value="1" {{ old('features.' . $index . '.is_active', $feature->is_active) ? 'checked' : '' }}>
                                                Visible on homepage
                                            </label>
                                        </div>
                                    </div>
                                    <input type="hidden" name="features[{{ $index }}][id]" value="{{ $feature->id }}">
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="panel">
                    <div class="panel-header">
                        <div>
                            <h2 class="h5 mb-1 section-title"><i class="bi bi-image" aria-hidden="true"></i><span>Homepage Hero Slider</span></h2>
                            <p class="text-muted mb-0">Manage the main hero carousel shown on the homepage.</p>
                        </div>
                    </div>
                    <div class="row g-4">
                        @foreach($heroSlides as $index => $slide)
                            <div class="col-12 col-lg-6">
                                <div class="border rounded p-3 h-100">
                                    <div class="mb-3">
                                        <label class="form-label">Title</label>
                                        <input type="text" name="hero_slides[{{ $index }}][title]" class="form-control" value="{{ old('hero_slides.' . $index . '.title', $slide->title) }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Subtitle</label>
                                        <input type="text" name="hero_slides[{{ $index }}][subtitle]" class="form-control" value="{{ old('hero_slides.' . $index . '.subtitle', $slide->subtitle) }}">
                                    </div>
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Button text</label>
                                            <input type="text" name="hero_slides[{{ $index }}][button_text]" class="form-control" value="{{ old('hero_slides.' . $index . '.button_text', $slide->button_text) }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Button URL</label>
                                            <input type="text" name="hero_slides[{{ $index }}][button_url]" class="form-control" value="{{ old('hero_slides.' . $index . '.button_url', $slide->button_url) }}">
                                        </div>
                                    </div>
                                    <div class="mb-3 mt-3">
                                        <label class="form-label">Upload image</label>
                                        <input type="file" name="hero_images[{{ $index }}]" class="form-control" accept="image/*">
                                        @if(!empty($slide->image_path))
                                            <div class="mt-2">
                                                <small class="text-muted">Current image:</small><br>
                                                <img src="{{ asset($slide->image_path) }}" alt="{{ $slide->title }}" style="max-height: 80px; border-radius: 6px;">
                                            </div>
                                        @endif
                                        <input type="hidden" name="hero_slides[{{ $index }}][image_path]" value="{{ old('hero_slides.' . $index . '.image_path', $slide->image_path) }}">
                                    </div>
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Sort order</label>
                                            <input type="number" name="hero_slides[{{ $index }}][sort_order]" class="form-control" value="{{ old('hero_slides.' . $index . '.sort_order', $slide->sort_order) }}">
                                        </div>
                                        <div class="col-md-6 d-flex align-items-end">
                                            <label class="form-check-label">
                                                <input type="hidden" name="hero_slides[{{ $index }}][is_active]" value="0">
                                                <input type="checkbox" name="hero_slides[{{ $index }}][is_active]" value="1" {{ old('hero_slides.' . $index . '.is_active', $slide->is_active) ? 'checked' : '' }}>
                                                Visible on homepage
                                            </label>
                                        </div>
                                    </div>
                                    <input type="hidden" name="hero_slides[{{ $index }}][id]" value="{{ $slide->id }}">
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-4">
            <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
    </form>
</div>
@endsection
