@extends('dashboard.app')
@section('content')
<main class="dashboard-content">
    <div class="container-fluid px-3 px-lg-4 py-4">
        <div class="page-heading">
            <div class="page-heading-copy">
                <span class="page-icon"><i class="bi bi-box-seam" aria-hidden="true"></i></span>
                <div>
                    <p class="eyebrow mb-1">Product Management</p>
                    <h5 class="mb-0">Edit Product</h5>
                    <p class="text-muted mb-0">Update product details</p>
                </div>
            </div>
            <div class="heading-actions">
                <a class="btn btn-secondary btn-sm" href="{{ route('products.index') }}">
                    <i class="bi bi-arrow-left" aria-hidden="true"></i> Back
                </a>
            </div>
        </div>

        <section class="panel mt-3">
            <div class="panel-body">
                <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Name *</label>
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
                            <label class="form-label">SKU *</label>
                            <input type="text" name="sku" class="form-control @error('sku') is-invalid @enderror" value="{{ old('sku', $product->sku) }}" required>
                            @error('sku')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Barcode</label>
                            <input type="text" name="barcode" class="form-control @error('barcode') is-invalid @enderror" value="{{ old('barcode', $product->barcode) }}">
                            @error('barcode')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Status *</label>
                            <select name="status" class="form-control @error('status') is-invalid @enderror" required>
                                @foreach(['draft', 'published', 'out_of_stock', 'inactive'] as $status)
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
                                    <label class="form-label">Category *</label>
                                    <select name="category_id" id="categorySelect" class="form-control @error('category_id') is-invalid @enderror" required>
                                        <option value="">Select Category</option>
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
                                    <label class="form-label">Brand</label>
                                    <select name="brand_id" id="brandSelect" class="form-control @error('brand_id') is-invalid @enderror">
                                        <option value="">Select Brand</option>
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
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="4">{{ old('description', $product->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Price *</label>
                            <input type="number" name="price" step="0.01" class="form-control @error('price') is-invalid @enderror" value="{{ old('price', $product->price) }}" required>
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Discount Price</label>
                            <input type="number" name="discount_price" step="0.01" class="form-control @error('discount_price') is-invalid @enderror" value="{{ old('discount_price', $product->discount_price) }}">
                            @error('discount_price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Cost Price</label>
                            <input type="number" name="cost_price" step="0.01" class="form-control @error('cost_price') is-invalid @enderror" value="{{ old('cost_price', $product->cost_price) }}">
                            @error('cost_price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Weight</label>
                            <input type="number" name="weight" step="0.01" class="form-control @error('weight') is-invalid @enderror" value="{{ old('weight', $product->weight) }}">
                            @error('weight')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Quantity</label>
                            <input type="number" name="quantity" class="form-control @error('quantity') is-invalid @enderror" value="{{ old('quantity', $product->quantity) }}">
                            @error('quantity')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Min Order Quantity</label>
                            <input type="number" name="minimum_order_quantity" class="form-control @error('minimum_order_quantity') is-invalid @enderror" value="{{ old('minimum_order_quantity', $product->minimum_order_quantity) }}">
                            @error('minimum_order_quantity')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Unit</label>
                            <input type="text" name="unit" class="form-control @error('unit') is-invalid @enderror" value="{{ old('unit', $product->unit) }}">
                            @error('unit')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Product Variants (Size-Color combinations) -->
                    <div class="mb-4">
                        <div class="d-flex align-items-end mb-2">
                            <h5 class="mb-0">Product Variants (Size & Color)</h5>
                            <button type="button" class="btn btn-outline-primary btn-sm ms-2" data-bs-toggle="modal" data-bs-target="#addSizeModal">
                                <i class="bi bi-plus"></i> Add Size
                            </button>
                            <button type="button" class="btn btn-outline-primary btn-sm ms-2" data-bs-toggle="modal" data-bs-target="#addColorModal">
                                <i class="bi bi-plus"></i> Add Color
                            </button>
                            <button type="button" class="btn btn-outline-primary btn-sm ms-2" id="addVariantBtn">
                                <i class="bi bi-plus"></i> Add Variant
                            </button>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="variantsTable">
                                <thead>
                                    <tr>
                                        <th>Size</th>
                                        <th>Color</th>
                                        <th>Variant SKU</th>
                                        <th>Barcode</th>
                                        <th>Price (optional)</th>
                                        <th>Discount Price</th>
                                        <th>Cost Price</th>
                                        <th>Quantity</th>
                                        <th style="width: 60px;"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Variants will be added here dynamically -->
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Existing Product Images -->
                    @if($product->images->count() > 0)
                        <div class="mb-4">
                            <h5 class="mb-2">Existing Images (Drag to reorder)</h5>
                            <div id="existingImagesContainer" class="d-flex flex-wrap gap-3">
                                @foreach($product->images->sortBy('sort_order') as $index => $image)
                                    <div class="image-item card" data-id="{{ $image->id }}">
                                        <img src="{{ asset('storage/' . $image->image_url) }}" class="card-img-top" style="height: 120px; object-fit: cover;">
                                        <div class="card-body p-2">
                                            <div class="form-check mb-1">
                                                <input type="radio" name="featured_image_id" value="{{ $image->id }}" class="form-check-input" {{ $image->is_featured ? 'checked' : '' }} id="featured-{{ $image->id }}">
                                                <label class="form-check-label" for="featured-{{ $image->id }}">Featured</label>
                                            </div>
                                            <input type="hidden" name="existing_images[{{ $index }}][id]" value="{{ $image->id }}">
                                            <input type="hidden" name="existing_images[{{ $index }}][sort_order]" class="sort-order-input" value="{{ $image->sort_order }}">
                                            <form action="{{ route('products.images.delete', ['product' => $product->id, 'image' => $image->id]) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                                            </form>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Add New Product Images -->
                    <div class="mb-4">
                        <h5 class="mb-2">Add New Images</h5>
                        <div class="mb-3">
                            <input type="file" name="new_product_images[]" class="form-control" accept="image/*" multiple>
                        </div>
                    </div>

                    <!-- Existing Videos -->
                    @if($product->videos->count() > 0)
                        <div class="mb-4">
                            <h5 class="mb-2">Existing Videos</h5>
                            <div class="d-flex flex-wrap gap-3">
                                @foreach($product->videos as $video)
                                    <div class="video-item card" style="width: 200px;">
                                        <video class="card-img-top" style="height: 120px; object-fit: cover;" controls>
                                            <source src="{{ asset('storage/' . $video->video) }}">
                                        </video>
                                        <div class="card-body p-2">
                                            <form action="{{ route('products.videos.delete', ['product' => $product->id, 'video' => $video->id]) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                                            </form>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Product Videos -->
                    <div class="mb-4">
                        <h5 class="mb-2">Add New Videos</h5>
                        <div class="mb-3">
                            <input type="file" name="product_videos[]" class="form-control" accept="video/*" multiple>
                        </div>
                    </div>

                    <!-- Locations -->
                    <div class="mb-4">
                        <h5 class="mb-2">Locations</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th style="width:50px;">Select</th>
                                        <th>Location</th>
                                        <th style="width:200px;">Quantity</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($locations as $location)
                                        @php
                                            $selectedLocation = $product->companyLocations->firstWhere('id', $location->id);
                                            $locationQty = $selectedLocation ? $selectedLocation->pivot->quantity : 0;
                                        @endphp
                                        <tr>
                                            <td>
                                                <input type="checkbox" name="locations[{{ $location->id }}][selected]" value="1" class="form-check-input" {{ $selectedLocation ? 'checked' : '' }}>
                                            </td>
                                            <td>{{ $location->name }}</td>
                                            <td>
                                                <input type="number" name="locations[{{ $location->id }}][quantity]" class="form-control form-control-sm" min="0" value="{{ $locationQty }}">
                                            </td>
                                        </tr>
                                    @endforeach
                                    @if(count($locations) == 0)
                                        <tr>
                                            <td colspan="3" class="text-center text-muted">No locations available. Please add one.</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input type="checkbox" name="featured" id="featured" class="form-check-input" {{ old('featured', $product->featured) ? 'checked' : '' }}>
                            <label class="form-check-label" for="featured">Featured Product</label>
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save" aria-hidden="true"></i> Update
                        </button>
                        <a href="{{ route('products.index') }}" class="btn btn-secondary">Cancel</a>
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
                        <h5 class="modal-title" id="addCategoryModalLabel">Add New Category</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Name *</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
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
                        <h5 class="modal-title" id="addBrandModalLabel">Add New Brand</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Name *</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
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
                        <h5 class="modal-title" id="addSizeModalLabel">Add New Size</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Name *</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
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
                        <h5 class="modal-title" id="addColorModalLabel">Add New Color</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Name *</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- SortableJS for drag and drop -->
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sizes = @json($sizes);
            const colors = @json($colors);
            const existingVariants = @json($product->variants);
            let variantIndex = 0;

            // Initialize Sortable for existing images
            const existingImagesContainer = document.getElementById('existingImagesContainer');
            if (existingImagesContainer) {
                new Sortable(existingImagesContainer, {
                    animation: 150,
                    onEnd: function() {
                        updateSortOrder();
                    }
                });
            }

            function updateSortOrder() {
                const items = document.querySelectorAll('#existingImagesContainer .image-item');
                items.forEach((item, index) => {
                    const sortInput = item.querySelector('.sort-order-input');
                    if (sortInput) {
                        sortInput.value = index;
                    }
                });
            }

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
                        <input type="text" name="variants[${variantIndex}][sku]" class="form-control form-control-sm" value="${variantData?.sku ?? ''}">
                    </td>
                    <td>
                        <input type="text" name="variants[${variantIndex}][barcode]" class="form-control form-control-sm" value="${variantData?.barcode ?? ''}">
                    </td>
                    <td>
                        <input type="number" name="variants[${variantIndex}][price]" step="0.01" class="form-control form-control-sm" value="${variantData?.price ?? ''}">
                    </td>
                    <td>
                        <input type="number" name="variants[${variantIndex}][discount_price]" step="0.01" class="form-control form-control-sm" value="${variantData?.discount_price ?? ''}">
                    </td>
                    <td>
                        <input type="number" name="variants[${variantIndex}][cost_price]" step="0.01" class="form-control form-control-sm" value="${variantData?.cost_price ?? ''}">
                    </td>
                    <td>
                        <input type="number" name="variants[${variantIndex}][quantity]" class="form-control form-control-sm" min="0" value="${variantData?.quantity ?? 0}">
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

            // Load existing variants
            if (existingVariants.length > 0) {
                existingVariants.forEach(variant => {
                    addVariantRow(variant);
                });
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
