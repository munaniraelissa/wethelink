@extends('dashboard.app')
@section('content')
<main class="dashboard-content">
    <div class="container-fluid px-3 px-lg-4 py-4">
        <div class="page-heading">
            <div class="page-heading-copy">
                <span class="page-icon"><i class="bi bi-box-seam" aria-hidden="true"></i></span>
                <div>
                    <p class="eyebrow mb-1">{{ __('messages.products') }}</p>
                    <h1 class="h3 mb-1">{{ __('messages.add_product') }}</h1>
                    <p class="text-muted mb-0">{{ __('messages.create_new_product') ?? 'Create a new product' }}</p>
                </div>
            </div>
            <div class="heading-actions">
                <a class="btn btn-secondary btn-sm" href="{{ route('products.index') }}">
                    <i class="bi bi-arrow-left" aria-hidden="true"></i> {{ __('messages.back') }}
                </a>
            </div>
        </div>

        @if ($message = Session::get('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>{{ __('messages.success') }}!</strong> {{ $message }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <section class="panel mt-3">
            <div class="panel-body">
                <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
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
                            <label class="form-label">Slug</label>
                            <input type="text" name="slug" class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug') }}">
                            @error('slug')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">{{ __('messages.sku') }} (Auto-generated if left blank)</label>
                            <input type="text" name="sku" class="form-control @error('sku') is-invalid @enderror" value="{{ old('sku') }}">
                            @error('sku')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">{{ __('messages.barcode') }}</label>
                            <input type="text" name="barcode" class="form-control @error('barcode') is-invalid @enderror" value="{{ old('barcode') }}">
                            @error('barcode')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">{{ __('messages.status') }} *</label>
                            <select name="status" class="form-control @error('status') is-invalid @enderror" required>
                                @foreach($statuses as $status)
                                    <option value="{{ $status }}" {{ old('status') == $status ? 'selected' : '' }}>{{ ucfirst(str_replace('_', ' ', $status)) }}</option>
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
                                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
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
                                            <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
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
                        <input type="text" name="short_description" class="form-control @error('short_description') is-invalid @enderror" value="{{ old('short_description') }}">
                        @error('short_description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('messages.description') }}</label>
                        <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="4">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label class="form-label">{{ __('messages.price') }} *</label>
                            <input type="number" name="price" step="0.01" class="form-control @error('price') is-invalid @enderror" value="{{ old('price') }}" required>
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">{{ __('messages.discount_price') }}</label>
                            <input type="number" name="discount_price" step="0.01" class="form-control @error('discount_price') is-invalid @enderror" value="{{ old('discount_price') }}">
                            @error('discount_price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">{{ __('messages.cost_price') }}</label>
                            <input type="number" name="cost_price" step="0.01" class="form-control @error('cost_price') is-invalid @enderror" value="{{ old('cost_price') }}">
                            @error('cost_price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">{{ __('messages.weight') }}</label>
                            <input type="number" name="weight" step="0.01" class="form-control @error('weight') is-invalid @enderror" value="{{ old('weight') }}">
                            @error('weight')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">{{ __('messages.quantity') }}</label>
                            <input type="number" name="quantity" class="form-control @error('quantity') is-invalid @enderror" value="{{ old('quantity', 0) }}">
                            @error('quantity')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">{{ __('messages.minimum_order_quantity') }}</label>
                            <input type="number" name="minimum_order_quantity" class="form-control @error('minimum_order_quantity') is-invalid @enderror" value="{{ old('minimum_order_quantity', 1) }}">
                            @error('minimum_order_quantity')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">{{ __('messages.unit') }}</label>
                            <input type="text" name="unit" class="form-control @error('unit') is-invalid @enderror" value="{{ old('unit', 'pcs') }}">
                            @error('unit')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Featured Image -->
                    <div class="mb-4">
                        <h5 class="mb-2">{{ __('messages.featured_image') }}</h5>
                        <div class="mb-3">
                            <input type="file" name="featured_image" id="featuredImageInput" class="form-control" accept="image/*">
                        </div>
                        <div id="featuredImagePreview" class="mb-3" style="display: none;">
                            <img id="featuredPreviewImg" src="" alt="{{ __('messages.preview') }}" class="img-thumbnail" style="max-width: 300px;">
                        </div>
                    </div>

                    <!-- Product Variants (Size-Color combinations) -->
                    <div class="mb-4">
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
                    </div>

                    <!-- Product Images -->
                    <div class="mb-4">
                        <h5 class="mb-2">{{ __('messages.product_images') }}</h5>
                        <div class="mb-3">
                            <input type="file" name="new_product_images[]" id="productImagesInput" class="form-control" accept="image/*" multiple>
                        </div>
                        <div id="productImagesPreview" class="d-flex flex-wrap gap-2 mb-3">
                            <!-- Preview will be shown here -->
                        </div>
                    </div>

                    <!-- Product Videos -->
                    <div class="mb-4">
                        <h5 class="mb-2">{{ __('messages.product_videos') }}</h5>
                        <div class="mb-3">
                            <input type="file" name="product_videos[]" id="productVideosInput" class="form-control" accept="video/*" multiple>
                        </div>
                        <div id="productVideosPreview" class="d-flex flex-wrap gap-2 mb-3">
                            <!-- Preview will be shown here -->
                        </div>
                    </div>

                    <!-- Locations -->
                    <div class="mb-4">
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
                                                <input type="checkbox" name="locations[{{ $location->id }}][selected]" value="1" class="form-check-input">
                                            </td>
                                            <td>{{ $location->name }}</td>
                                            <td>
                                                <input type="number" name="locations[{{ $location->id }}][quantity]" class="form-control form-control-sm" min="0" value="0">
                                            </td>
                                        </tr>
                                    @endforeach
                                    @if(count($locations) == 0)
                                        <tr>
                                            <td colspan="3" class="text-center text-muted">{{ __('messages.no_items') ?? 'No locations available. Please add one.' }}</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input type="checkbox" name="featured" id="featured" class="form-check-input" {{ old('featured') ? 'checked' : '' }}>
                            <label class="form-check-label" for="featured">{{ __('messages.featured') }} {{ __('messages.product') }}</label>
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

    <!-- Add Category Modal -->
    <div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="addCategoryForm">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addCategoryModalLabel">{{ __('messages.add_category') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">{{ __('messages.name') }} *</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('messages.close') ?? 'Close' }}</button>
                        <button type="submit" class="btn btn-primary">{{ __('messages.save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Add Brand Modal -->
    <div class="modal fade" id="addBrandModal" tabindex="-1" aria-labelledby="addBrandModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="addBrandForm">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addBrandModalLabel">{{ __('messages.add_brand') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">{{ __('messages.name') }} *</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('messages.close') ?? 'Close' }}</button>
                        <button type="submit" class="btn btn-primary">{{ __('messages.save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Add Size Modal -->
    <div class="modal fade" id="addSizeModal" tabindex="-1" aria-labelledby="addSizeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="addSizeForm">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addSizeModalLabel">{{ __('messages.add_size') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">{{ __('messages.name') }} *</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('messages.close') ?? 'Close' }}</button>
                        <button type="submit" class="btn btn-primary">{{ __('messages.save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Add Color Modal -->
    <div class="modal fade" id="addColorModal" tabindex="-1" aria-labelledby="addColorModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="addColorForm">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addColorModalLabel">{{ __('messages.add_color') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">{{ __('messages.name') }} *</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('messages.close') ?? 'Close' }}</button>
                        <button type="submit" class="btn btn-primary">{{ __('messages.save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sizes = @json($sizes);
            const colors = @json($colors);
            let variantIndex = 0;

            // Featured Image Preview
            const featuredImageInput = document.getElementById('featuredImageInput');
            const featuredPreview = document.getElementById('featuredImagePreview');
            const featuredPreviewImg = document.getElementById('featuredPreviewImg');
            
            featuredImageInput.addEventListener('change', function(e) {
                if (e.target.files && e.target.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(event) {
                        featuredPreviewImg.src = event.target.result;
                        featuredPreview.style.display = 'block';
                    };
                    reader.readAsDataURL(e.target.files[0]);
                } else {
                    featuredPreview.style.display = 'none';
                }
            });

            // Product Images Preview
            const productImagesInput = document.getElementById('productImagesInput');
            const productImagesPreview = document.getElementById('productImagesPreview');
            
            productImagesInput.addEventListener('change', function(e) {
                productImagesPreview.innerHTML = '';
                if (e.target.files.length > 0) {
                    Array.from(e.target.files).forEach((file, index) => {
                        const reader = new FileReader();
                        reader.onload = function(event) {
                            const div = document.createElement('div');
                            div.className = 'position-relative';
                            div.innerHTML = `
                                <img src="${event.target.result}" class="img-thumbnail" style="max-width: 150px;">
                            `;
                            productImagesPreview.appendChild(div);
                        };
                        reader.readAsDataURL(file);
                    });
                }
            });

            // Product Videos Preview
            const productVideosInput = document.getElementById('productVideosInput');
            const productVideosPreview = document.getElementById('productVideosPreview');
            
            productVideosInput.addEventListener('change', function(e) {
                productVideosPreview.innerHTML = '';
                if (e.target.files.length > 0) {
                    Array.from(e.target.files).forEach((file, index) => {
                        const div = document.createElement('div');
                        div.className = 'position-relative';
                        const video = document.createElement('video');
                        video.src = URL.createObjectURL(file);
                        video.controls = true;
                        video.style.maxWidth = '200px';
                        video.style.maxHeight = '150px';
                        div.appendChild(video);
                        productVideosPreview.appendChild(div);
                    });
                }
            });

            // Add Category
            document.getElementById('addCategoryForm').addEventListener('submit', async function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                try {
                    const response = await fetch('{{ route('categories.store') }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        },
                        body: formData
                    });
                    const data = await response.json();
                    if (data.success) {
                        const select = document.getElementById('categorySelect');
                        const option = document.createElement('option');
                        option.value = data.category.id;
                        option.textContent = data.category.name;
                        option.selected = true;
                        select.appendChild(option);
                        const modal = bootstrap.Modal.getInstance(document.getElementById('addCategoryModal'));
                        modal.hide();
                        this.reset();
                    }
                } catch (error) {
                    console.error('Error:', error);
                }
            });

            // Add Brand
            document.getElementById('addBrandForm').addEventListener('submit', async function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                try {
                    const response = await fetch('{{ route('brands.store') }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        },
                        body: formData
                    });
                    const data = await response.json();
                    if (data.success) {
                        const select = document.getElementById('brandSelect');
                        const option = document.createElement('option');
                        option.value = data.brand.id;
                        option.textContent = data.brand.name;
                        option.selected = true;
                        select.appendChild(option);
                        const modal = bootstrap.Modal.getInstance(document.getElementById('addBrandModal'));
                        modal.hide();
                        this.reset();
                    }
                } catch (error) {
                    console.error('Error:', error);
                }
            });

            // Add Size
            document.getElementById('addSizeForm').addEventListener('submit', async function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                try {
                    const response = await fetch('{{ route('sizes.store') }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        },
                        body: formData
                    });
                    const data = await response.json();
                    if (data.success) {
                        sizes.push(data.size);
                        const modal = bootstrap.Modal.getInstance(document.getElementById('addSizeModal'));
                        modal.hide();
                        this.reset();
                    }
                } catch (error) {
                    console.error('Error:', error);
                }
            });

            // Add Color
            document.getElementById('addColorForm').addEventListener('submit', async function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                try {
                    const response = await fetch('{{ route('colors.store') }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        },
                        body: formData
                    });
                    const data = await response.json();
                    if (data.success) {
                        colors.push(data.color);
                        const modal = bootstrap.Modal.getInstance(document.getElementById('addColorModal'));
                        modal.hide();
                        this.reset();
                    }
                } catch (error) {
                    console.error('Error:', error);
                }
            });

            // Add Variant
            document.getElementById('addVariantBtn').addEventListener('click', function() {
                addVariantRow();
            });

            function addVariantRow(variantData = null) {
                const tbody = document.querySelector('#variantsTable tbody');
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>
                        <select name="variants[${variantIndex}][size]" class="form-control form-control-sm">
                            <option value="">Select Size</option>
                            ${sizes.map(s => `<option value="${s.name}" ${variantData && variantData.size === s.name ? 'selected' : ''}>${s.name}</option>`).join('')}
                        </select>
                    </td>
                    <td>
                        <select name="variants[${variantIndex}][color]" class="form-control form-control-sm">
                            <option value="">Select Color</option>
                            ${colors.map(c => `<option value="${c.name}" ${variantData && variantData.color === c.name ? 'selected' : ''}>${c.name}</option>`).join('')}
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

            // Remove Variant
            document.addEventListener('click', function(e) {
                if (e.target.closest('.remove-variant')) {
                    e.target.closest('tr').remove();
                }
            });
        });
    </script>
</main>
@endsection
