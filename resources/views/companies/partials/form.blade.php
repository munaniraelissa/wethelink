{{-- resources/views/companies/partials/form.blade.php --}}
{{-- Usage: include with $company (or null for create) and $action, $method --}}

<form action="{{ $action }}" method="POST" enctype="multipart/form-data" class="space-y-6">
    @csrf
    @if($method ?? false)
        @method($method)
    @endif

    {{-- Basic Info --}}
    <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
        <h2 class="mb-4 text-base font-semibold text-gray-800">Basic Information</h2>
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">

            {{-- Name --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Company Name <span class="text-red-500">*</span>
                </label>
                <input type="text" name="name" value="{{ old('name', $company->name ?? '') }}"
                       class="w-full rounded-lg border @error('name') border-red-400 bg-red-50 @else border-gray-300 @enderror px-3 py-2 text-sm focus:border-indigo-400 focus:outline-none focus:ring-1 focus:ring-indigo-400">
                @error('name')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Email --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email', $company->email ?? '') }}"
                       class="w-full rounded-lg border @error('email') border-red-400 bg-red-50 @else border-gray-300 @enderror px-3 py-2 text-sm focus:border-indigo-400 focus:outline-none focus:ring-1 focus:ring-indigo-400">
                @error('email')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Telephone --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Telephone</label>
                <input type="text" name="telephone" value="{{ old('telephone', $company->telephone ?? '') }}"
                       class="w-full rounded-lg border @error('telephone') border-red-400 bg-red-50 @else border-gray-300 @enderror px-3 py-2 text-sm focus:border-indigo-400 focus:outline-none focus:ring-1 focus:ring-indigo-400">
                @error('telephone')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Website --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Website</label>
                <input type="url" name="website" value="{{ old('website', $company->website ?? '') }}"
                       placeholder="https://"
                       class="w-full rounded-lg border @error('website') border-red-400 bg-red-50 @else border-gray-300 @enderror px-3 py-2 text-sm focus:border-indigo-400 focus:outline-none focus:ring-1 focus:ring-indigo-400">
                @error('website')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Industry --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Industry</label>
                <input type="text" name="industry" value="{{ old('industry', $company->industry ?? '') }}"
                       class="w-full rounded-lg border @error('industry') border-red-400 bg-red-50 @else border-gray-300 @enderror px-3 py-2 text-sm focus:border-indigo-400 focus:outline-none focus:ring-1 focus:ring-indigo-400">
                @error('industry')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Status --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Status <span class="text-red-500">*</span>
                </label>
                <select name="status"
                        class="w-full rounded-lg border @error('status') border-red-400 bg-red-50 @else border-gray-300 @enderror px-3 py-2 text-sm focus:border-indigo-400 focus:outline-none focus:ring-1 focus:ring-indigo-400">
                    @foreach(['pending','active','inactive','blocked'] as $s)
                        <option value="{{ $s }}" @selected(old('status', $company->status ?? 'pending') === $s)>
                            {{ ucfirst($s) }}
                        </option>
                    @endforeach
                </select>
                @error('status')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

        </div>
    </div>

    {{-- Legal Info --}}
    <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
        <h2 class="mb-4 text-base font-semibold text-gray-800">Legal &amp; Registration</h2>
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tax Number</label>
                <input type="text" name="tax_number" value="{{ old('tax_number', $company->tax_number ?? '') }}"
                       class="w-full rounded-lg border @error('tax_number') border-red-400 bg-red-50 @else border-gray-300 @enderror px-3 py-2 text-sm focus:border-indigo-400 focus:outline-none focus:ring-1 focus:ring-indigo-400">
                @error('tax_number')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Registration Number</label>
                <input type="text" name="registration_number" value="{{ old('registration_number', $company->registration_number ?? '') }}"
                       class="w-full rounded-lg border @error('registration_number') border-red-400 bg-red-50 @else border-gray-300 @enderror px-3 py-2 text-sm focus:border-indigo-400 focus:outline-none focus:ring-1 focus:ring-indigo-400">
                @error('registration_number')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

        </div>
    </div>

    {{-- Business Settings --}}
    <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
        <h2 class="mb-4 text-base font-semibold text-gray-800">Business Settings</h2>
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Credit Limit</label>
                <div class="relative">
                    <span class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-sm text-gray-400">$</span>
                    <input type="number" name="credit_limit" step="0.01" min="0"
                           value="{{ old('credit_limit', $company->credit_limit ?? 0) }}"
                           class="w-full rounded-lg border @error('credit_limit') border-red-400 bg-red-50 @else border-gray-300 @enderror pl-7 pr-3 py-2 text-sm focus:border-indigo-400 focus:outline-none focus:ring-1 focus:ring-indigo-400">
                </div>
                @error('credit_limit')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Payment Terms (days)</label>
                <input type="number" name="payment_terms_days" min="0"
                       value="{{ old('payment_terms_days', $company->payment_terms_days ?? 0) }}"
                       class="w-full rounded-lg border @error('payment_terms_days') border-red-400 bg-red-50 @else border-gray-300 @enderror px-3 py-2 text-sm focus:border-indigo-400 focus:outline-none focus:ring-1 focus:ring-indigo-400">
                @error('payment_terms_days')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

        </div>
    </div>

    {{-- Logo --}}
    <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
        <h2 class="mb-4 text-base font-semibold text-gray-800">Logo</h2>

        @if(!empty($company->logo))
            <div class="mb-4 flex items-center gap-4">
                <img src="{{ Storage::url($company->logo) }}" alt="Current logo"
                     class="h-16 w-16 rounded-xl object-cover ring-1 ring-gray-200">
                <p class="text-sm text-gray-500">Current logo. Upload a new one to replace it.</p>
            </div>
        @endif

        <label class="block cursor-pointer rounded-lg border-2 border-dashed border-gray-300 p-6 text-center hover:border-indigo-400 hover:bg-indigo-50 transition-colors">
            <i class="fa fa-cloud-arrow-up text-2xl text-gray-400 mb-2 block"></i>
            <span class="text-sm text-gray-500">Click to upload (JPEG, PNG, WebP — max 2 MB)</span>
            <input type="file" name="logo" accept="image/*" class="sr-only"
                   onchange="document.getElementById('logo-preview-name').textContent = this.files[0]?.name ?? ''">
        </label>
        <p id="logo-preview-name" class="mt-2 text-xs text-indigo-600"></p>
        @error('logo')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>

    {{-- Actions --}}
    <div class="flex items-center justify-end gap-3">
        <a href="{{ route('companies.index') }}"
           class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">
            Cancel
        </a>
        <button type="submit"
                class="inline-flex items-center gap-2 rounded-lg bg-indigo-600 px-5 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
            <i class="fa fa-floppy-disk text-xs"></i>
            {{ isset($company) ? 'Save Changes' : 'Create Company' }}
        </button>
    </div>
</form>