@extends('dashboard.app')
@section('content')
<main class="dashboard-content">
    <div class="container-fluid px-3 px-lg-4 py-4">
        <div class="page-heading">
            <div class="page-heading-copy">
                <span class="page-icon"><i class="bi bi-box-seam" aria-hidden="true"></i></span>
                <div>
                    <p class="eyebrow mb-1">{{ __('messages.products') }}</p>
                    <h1 class="h3 mb-1">{{ __('messages.edit_product') ?? 'Edit Product' }}</h1>
                    <p class="text-muted mb-0">{{ __('messages.edit_product_details') ?? 'Update product information' }}</p>
                </div>
            </div>
            <div class="heading-actions">
                <a class="btn btn-secondary btn-sm" href="{{ route('products.index') }}">
                    <i class="bi bi-arrow-left" aria-hidden="true"></i> {{ __('messages.back') }}
                </a>
            </div>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>{{ __('messages.error') ?? 'Whoops!' }}</strong> {{ __('messages.validation_errors') ?? 'There were some problems with your input.' }}
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
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
                <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">{{ __('messages.name') }} *</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $product->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Slug</label>
                            <input type="text" name="slug" class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug', $product->slug) }}">
                            @error('slug')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">{{ __('messages.sku') }}</label>
                            <input type="text" name="sku" class="form-control @error('sku') is-invalid @enderror" value="{{ old('sku', $product->sku) }}">
                            @error('sku')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">{{ __('messages.barcode') }}</label>
                            <input type="text" name="barcode" class="form-control @error('barcode') is-invalid @enderror" value="{{ old('barcode', $product->barcode) }}">
                            @error('barcode')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">{{ __('messages.status') }} *</label>
                            <select name="status" class="form-control @error('status') is-invalid @enderror" required>
                                @foreach($statuses as $status)
                                    <option value="{{ $status }}" {{ old('status', $product->status) == $status ? 'selected' : '' }}>{{ ucfirst(str_replace('_', ' ', $status)) }}</option>
                                @endforeach
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="d-flex align-items-end">
                                <div class="flex-grow-1">
                                    <label class="form-label">{{ __('messages.category') }} *</label>
                                    <select name="category_id" id="categorySelect" class="form-control @error('category_id') is-invalid @enderror" required>
                                        <option value="">Select {{ __('messages.category') }}</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <button type="button" class="btn btn-outline-primary btn-sm ms-2 mb-1" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                                    <i class="bi bi-plus"></i>
                                </button>
                            </div>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="d-flex align-items-end">
                                <div class="flex-grow-1">
                                    <label class="form-label">{{ __('messages.brand') }}</label>
                                    <select name="brand_id" id="brandSelect" class="form-control @error('brand_id') is-invalid @enderror">
                                        <option value="">Select {{ __('messages.brand') }}</option>
                                        @foreach($brands as $brand)
                                            <option value="{{ $brand->id }}" {{ old('brand_id', $product->brand_id) == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <button type="button" class="btn btn-outline-primary btn-sm ms-2 mb-1" data-bs-toggle="modal" data-bs-target="#addBrandModal">
                                    <i class="bi bi-plus"></i>
                                </button>
                            </div>
                            @error('brand_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Short Description</label>
                        <input type="text" name="short_description" class="form-control @error('short_description') is-invalid @enderror" value="{{ old('short_description', $product->short_description) }}">
                        @error('short_description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('messages.description') }}</label>
                        <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="4">{{ old('description', $product->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    {{-- <div class="row">
                        <div class="col-md-3 mb-3">
                            <label class="form-label">{{ __('messages.price') }} *</label>
                            <input type="number" name="price" step="0.01" class="form-control @error('price') is-invalid @enderror" value="{{ old('price', $product->price) }}" required>
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">{{ __('messages.discount_price') }}</label>
                            <input type="number" name="discount_price" step="0.01" class="form-control @error('discount_price') is-invalid @enderror" value="{{ old('discount_price', $product->discount_price) }}">
                            @error('discount_price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">{{ __('messages.cost_price') }}</label>
                            <input type="number" name="cost_price" step="0.01" class="form-control @error('cost_price') is-invalid @enderror" value="{{ old('cost_price', $product->cost_price) }}">
                            @error('cost_price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">{{ __('messages.weight') }}</label>
                            <input type="number" name="weight" step="0.01" class="form-control @error('weight') is-invalid @enderror" value="{{ old('weight', $product->weight) }}">
                            @error('weight')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div> --}}
                    <div class="row">
                        {{-- <div class="col-md-4 mb-3">
                            <label class="form-label">{{ __('messages.quantity') }}</label>
                            <input type="number" name="quantity" class="form-control @error('quantity') is-invalid @enderror" value="{{ old('quantity', $product->quantity) }}">
                            @error('quantity')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div> --}}
                        <div class="col-md-4 mb-3">
                            <label class="form-label">{{ __('messages.price') }} *</label>
                            <input type="number" name="price" step="0.01" class="form-control @error('price') is-invalid @enderror" value="{{ old('price', $product->price) }}" required>
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">{{ __('messages.minimum_order_quantity') }}</label>
                            <input type="number" name="minimum_order_quantity" class="form-control @error('minimum_order_quantity') is-invalid @enderror" value="{{ old('minimum_order_quantity', $product->minimum_order_quantity) }}">
                            @error('minimum_order_quantity')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">{{ __('messages.unit') }}</label>
                            <input type="text" name="unit" class="form-control @error('unit') is-invalid @enderror" value="{{ old('unit', $product->unit) }}">
                            @error('unit')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Product Variants (Size-Color combinations) -->
                    {{-- <div class="mb-4">
                        <div class="d-flex align-items-end mb-2">
                            <h5 class="mb-0">{{ __('messages.product_variants') }} (Size & Color)</h5>
                            <button type="button" class="btn btn-outline-primary btn-sm ms-2" data-bs-toggle="modal" data-bs-target="#addSizeModal">
                                <i class="bi bi-plus"></i> {{ __('messages.add_size') }}
                            </button>
                            <button type="button" class="btn btn-outline-primary btn-sm ms-2" data-bs-toggle="modal" data-bs-target="#addColorModal">
                                <i class="bi bi-plus"></i> {{ __('messages.add_color') }}
                            </button>
                            <button type="button" class="btn btn-outline-primary btn-sm ms-2" id="addVariantBtn">
                                <i class="bi bi-plus"></i> {{ __('messages.add_variant') }}
                            </button>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="variantsTable">
                                <thead>
                                    <tr>
                                        <th>{{ __('messages.size') }}</th>
                                        <th>{{ __('messages.color') }}</th>
                                        <th>{{ __('messages.sku') }}</th>
                                        <th>{{ __('messages.barcode') }}</th>
                                        <th>{{ __('messages.price') }} (optional)</th>
                                        <th>{{ __('messages.discount_price') }}</th>
                                        <th>{{ __('messages.cost_price') }}</th>
                                        <th>{{ __('messages.quantity') }}</th>
                                        <th style="width: 60px;"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Variants will be added here dynamically -->
                                </tbody>
                            </table>
                        </div>
                    </div> --}}

                    <!-- Product Images -->
                    <div class="mb-4">
                        <h5 class="mb-2">{{ __('messages.product_images') }}</h5>
                        
                        <!-- Existing Images -->
                        <div class="d-flex flex-wrap gap-2 mb-3">
                            @foreach($product->images as $image)
                                <div class="position-relative">
                                    <img src="{{ asset('storage/' . $image->image) }}" class="img-thumbnail" style="width: 150px; height: 150px; object-fit: cover;">
                                    <div class="form-check mt-1">
                                        <input class="form-check-input" type="checkbox" name="delete_images[]" value="{{ $image->id }}" id="delImg{{ $image->id }}">
                                        <label class="form-check-label small text-danger" for="delImg{{ $image->id }}">Delete</label>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Add New Images</label>
                            <input type="file" name="new_product_images[]" id="productImagesInput" class="form-control" accept="image/*" multiple>
                        </div>
                        @error('new_product_images')
                            <div class="text-danger small mb-2">{{ $message }}</div>
                        @enderror
                        <div id="productImagesPreview" class="d-flex flex-wrap gap-2 mb-3">
                            <!-- Preview of new images will be shown here -->
                        </div>
                    </div>

                    <!-- Product Videos -->
                    <div class="mb-4">
                        <h5 class="mb-2">{{ __('messages.product_videos') }}</h5>
                        
                        <!-- Existing Videos -->
                        <div class="d-flex flex-wrap gap-2 mb-3">
                            @foreach($product->videos as $video)
                                <div class="position-relative">
                                    <video src="{{ asset('storage/' . $video->video) }}" style="max-width: 200px; max-height: 150px;" controls></video>
                                    <div class="form-check mt-1">
                                        <input class="form-check-input" type="checkbox" name="delete_videos[]" value="{{ $video->id }}" id="delVid{{ $video->id }}">
                                        <label class="form-check-label small text-danger" for="delVid{{ $video->id }}">Delete</label>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Add New Videos</label>
                            <input type="file" name="product_videos[]" id="productVideosInput" class="form-control" accept="video/*" multiple>
                        </div>
                        @error('product_videos')
                            <div class="text-danger small mb-2">{{ $message }}</div>
                        @enderror
                        <div id="productVideosPreview" class="d-flex flex-wrap gap-2 mb-3">
                            <!-- Preview of new videos will be shown here -->
                        </div>
                    </div>

                    <!-- Locations -->
                    {{-- <div class="mb-4">
                        <h5 class="mb-2">{{ __('messages.locations') }}</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th style="width:50px">{{ __('messages.select') ?? 'Select' }}</th>
                                        <th>{{ __('messages.locations') }}</th>
                                        <th style="width:200px">{{ __('messages.quantity') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($locations as $location)
                                        <tr>
                                            <td>
                                                <input type="checkbox" name="locations[{{ $location->id }}][selected]" value="1" class="form-check-input" checked>
                                            </td>
                                            <td>{{ $location->name }}</td>
                                            <td>
                                                <input type="number" name="locations[{{ $location->id }}][quantity]" class="form-control form-control-sm" min="0" value="0">
                                            </td>
                                        </tr>
                                    @endforeach
                                    @if(count($locations) == 0)
                                        <tr>
                                            <td colspan="3" class="text-center text-muted">{{ __('messages.no_items') ?? 'No locations available.' }}</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div> --}}

                    <div class="mb-3">
                        <div class="form-check">
                            <input type="checkbox" name="is_featured" id="is_featured" value="1" class="form-check-input" {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_featured">{{ __('messages.featured') }} {{ __('messages.product') }}</label>
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save" aria-hidden="true"></i> {{ __('messages.save') }}
                        </button>
                        <a href="{{ route('products.index') }}" class="btn btn-secondary">{{ __('messages.cancel') }}</a>
                    </div>
                </form>
            </div>
        </section>
    </div>

    <!-- Modals (Category, Brand, Size, Color) omitted for brevity - reuse from create.blade.php -->

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sizes = @json($sizes);
            const colors = @json($colors);
            let variantIndex = 0;

            // Load existing variants
            const existingVariants = @json($product->variants);
            if (existingVariants && existingVariants.length > 0) {
                existingVariants.forEach(v => {
                    addVariantRow(v);
                });
            }

            // Product Images/Videos Preview Logic (Reuse from create.blade.php)
            const productImagesInput = document.getElementById('productImagesInput');
            const productImagesPreview = document.getElementById('productImagesPreview');
            
            productImagesInput.addEventListener('change', function(e) {
                productImagesPreview.innerHTML = '';
                if (e.target.files.length > 0) {
                    Array.from(e.target.files).forEach((file) => {
                        const reader = new FileReader();
                        reader.onload = function(event) {
                            const div = document.createElement('div');
                            div.className = 'position-relative';
                            div.innerHTML = `<img src="${event.target.result}" class="img-thumbnail" style="max-width: 150px;">`;
                            productImagesPreview.appendChild(div);
                        };
                        reader.readAsDataURL(file);
                    });
                }
            });

            // ... (Other event listeners and functions reused from create.blade.php)

            function addVariantRow(variantData = null) {
                const tbody = document.querySelector('#variantsTable tbody');
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>
                        <select name="variants[${variantIndex}][size]" class="form-control form-control-sm">
                            <option value="">Select Size</option>
                            ${sizes.map(s => `<option value="${s.name}" ${variantData && (variantData.size === s.name || variantData.size_id === s.id) ? 'selected' : ''}>${s.name}</option>`).join('')}
                        </select>
                    </td>
                    <td>
                        <select name="variants[${variantIndex}][color]" class="form-control form-control-sm">
                            <option value="">Select Color</option>
                            ${colors.map(c => `<option value="${c.name}" ${variantData && (variantData.color === c.name || variantData.color_id === c.id) ? 'selected' : ''}>${c.name}</option>`).join('')}
                        </select>
                    </td>
                    <td>
                        <input type="text" name="variants[${variantIndex}][sku]" class="form-control form-control-sm" value="${variantData?.sku || ''}">
                    </td>
                    <td>
                        <input type="text" name="variants[${variantIndex}][barcode]" class="form-control form-control-sm" value="${variantData?.barcode || ''}">
                    </td>
                    <td>
                        <input type="number" name="variants[${variantIndex}][price]" step="0.01" class="form-control form-control-sm" value="${variantData?.price || ''}">
                    </td>
                    <td>
                        <input type="number" name="variants[${variantIndex}][discount_price]" step="0.01" class="form-control form-control-sm" value="${variantData?.discount_price || ''}">
                    </td>
                    <td>
                        <input type="number" name="variants[${variantIndex}][cost_price]" step="0.01" class="form-control form-control-sm" value="${variantData?.cost_price || ''}">
                    </td>
                    <td>
                        <input type="number" name="variants[${variantIndex}][quantity]" class="form-control form-control-sm" min="0" value="${variantData?.quantity || 0}">
                    </td>
                    <td>
                        <button type="button" class="btn btn-sm btn-danger remove-variant">
                            <i class="bi bi-trash"></i>
                        </button>
                    </td>
                `;
                tbody.appendChild(tr);
                variantIndex++;
            }

            document.getElementById('addVariantBtn').addEventListener('click', function() {
                addVariantRow();
            });

            document.addEventListener('click', function(e) {
                if (e.target.closest('.remove-variant')) {
                    e.target.closest('tr').remove();
                }
            });
        });
    </script>
</main>
@endsection