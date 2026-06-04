{{-- resources/views/companies/show.blade.php --}}
@extends('dashboard.app')

@section('title', $company->name)

@section('content')
<div class="space-y-6">

    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 text-sm text-gray-500">
        <a href="{{ route('companies.index') }}" class="hover:text-indigo-600">Companies</a>
        <i class="fa fa-chevron-right text-[10px]"></i>
        <span class="text-gray-800 font-medium">{{ $company->name }}</span>
    </nav>

    {{-- Header card --}}
    <div class="flex flex-wrap items-start justify-between gap-4 rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
        <div class="flex items-center gap-4">
            @if($company->logo)
                <img src="{{ Storage::url($company->logo) }}" alt="{{ $company->name }}"
                     class="h-16 w-16 rounded-xl object-cover ring-1 ring-gray-200">
            @else
                <div class="flex h-16 w-16 items-center justify-center rounded-xl bg-indigo-100 text-indigo-700 text-xl font-bold">
                    {{ strtoupper(substr($company->name, 0, 2)) }}
                </div>
            @endif
            <div>
                <h1 class="text-xl font-bold text-gray-900">{{ $company->name }}</h1>
                <p class="text-sm text-gray-400">{{ $company->slug }}</p>
                @if($company->industry)
                    <p class="mt-1 text-sm text-gray-500">{{ $company->industry }}</p>
                @endif
            </div>
        </div>
        <div class="flex items-center gap-2">
            @include('companies.partials.status-badge', ['status' => $company->status])
            <a href="{{ route('companies.edit', $company) }}"
               class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-3 py-1.5 text-sm font-medium text-gray-700 hover:bg-gray-50">
                <i class="fa fa-pen text-xs"></i> Edit
            </a>
            <form action="{{ route('companies.destroy', $company) }}" method="POST"
                  onsubmit="return confirm('Delete {{ addslashes($company->name) }}? This cannot be undone.')">
                @csrf @method('DELETE')
                <button type="submit"
                        class="inline-flex items-center gap-2 rounded-lg border border-red-200 bg-red-50 px-3 py-1.5 text-sm font-medium text-red-600 hover:bg-red-100">
                    <i class="fa fa-trash text-xs"></i> Delete
                </button>
            </form>
        </div>
    </div>

    {{-- Detail cards --}}
    <div class="grid grid-cols-1 gap-5 md:grid-cols-2 xl:grid-cols-3">

        {{-- Contact --}}
        <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm space-y-3">
            <h3 class="text-xs font-semibold uppercase tracking-wide text-gray-400">Contact</h3>
            <dl class="space-y-2 text-sm">
                <div class="flex justify-between">
                    <dt class="text-gray-500">Email</dt>
                    <dd class="font-medium text-gray-800">
                        @if($company->email)
                            <a href="mailto:{{ $company->email }}" class="text-indigo-600 hover:underline">{{ $company->email }}</a>
                        @else —
                        @endif
                    </dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-gray-500">Phone</dt>
                    <dd class="font-medium text-gray-800">{{ $company->telephone ?? '—' }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-gray-500">Website</dt>
                    <dd class="font-medium text-gray-800">
                        @if($company->website)
                            <a href="{{ $company->website }}" target="_blank" rel="noopener"
                               class="text-indigo-600 hover:underline">{{ $company->website }}</a>
                        @else —
                        @endif
                    </dd>
                </div>
            </dl>
        </div>

        {{-- Legal --}}
        <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm space-y-3">
            <h3 class="text-xs font-semibold uppercase tracking-wide text-gray-400">Legal &amp; Registration</h3>
            <dl class="space-y-2 text-sm">
                <div class="flex justify-between">
                    <dt class="text-gray-500">Tax Number</dt>
                    <dd class="font-medium text-gray-800">{{ $company->tax_number ?? '—' }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-gray-500">Reg. Number</dt>
                    <dd class="font-medium text-gray-800">{{ $company->registration_number ?? '—' }}</dd>
                </div>
            </dl>
        </div>

        {{-- Business --}}
        <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm space-y-3">
            <h3 class="text-xs font-semibold uppercase tracking-wide text-gray-400">Business Settings</h3>
            <dl class="space-y-2 text-sm">
                <div class="flex justify-between">
                    <dt class="text-gray-500">Credit Limit</dt>
                    <dd class="font-medium text-gray-800">${{ number_format($company->credit_limit, 2) }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-gray-500">Payment Terms</dt>
                    <dd class="font-medium text-gray-800">{{ $company->payment_terms_days }} days</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-gray-500">Created</dt>
                    <dd class="font-medium text-gray-800">{{ $company->created_at->format('d M Y') }}</dd>
                </div>
            </dl>
        </div>

    </div>

    {{-- Locations table --}}
    <div class="rounded-xl border border-gray-200 bg-white shadow-sm">
        <div class="flex items-center justify-between border-b border-gray-100 px-5 py-4">
            <h2 class="text-base font-semibold text-gray-800">
                Locations
                <span class="ml-2 rounded-full bg-gray-100 px-2 py-0.5 text-xs text-gray-500">
                    {{ $company->locations->count() }}
                </span>
            </h2>
            <a href="{{ route('companies.locations.create', $company) }}"
               class="inline-flex items-center gap-2 rounded-lg bg-indigo-600 px-3 py-1.5 text-sm font-medium text-white hover:bg-indigo-700">
                <i class="fa fa-plus text-xs"></i> Add Location
            </a>
        </div>
        @if($company->locations->isNotEmpty())
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-xs uppercase tracking-wide text-gray-400">
                <tr>
                    <th class="px-5 py-3 text-left">Name</th>
                    <th class="px-5 py-3 text-left">City</th>
                    <th class="px-5 py-3 text-left">Manager</th>
                    <th class="px-5 py-3 text-left">Type</th>
                    <th class="px-5 py-3 text-left">Status</th>
                    <th class="px-5 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($company->locations as $location)
                <tr class="hover:bg-gray-50">
                    <td class="px-5 py-3 font-medium text-gray-900">{{ $location->name }}</td>
                    <td class="px-5 py-3 text-gray-600">{{ $location->city ?? '—' }}</td>
                    <td class="px-5 py-3 text-gray-600">{{ $location->manager_name ?? '—' }}</td>
                    <td class="px-5 py-3">
                        @if($location->is_head_office)
                            <span class="rounded-full bg-indigo-50 px-2.5 py-0.5 text-xs font-medium text-indigo-700 ring-1 ring-indigo-200">
                                Head Office
                            </span>
                        @else
                            <span class="text-gray-400 text-xs">Branch</span>
                        @endif
                    </td>
                    <td class="px-5 py-3">
                        @include('companies.partials.status-badge', ['status' => $location->status])
                    </td>
                    <td class="px-5 py-3 text-right">
                        <div class="inline-flex items-center gap-1">
                            <a href="{{ route('companies.locations.show', [$company, $location]) }}"
                               class="rounded p-1.5 text-gray-400 hover:bg-gray-100 hover:text-gray-700" title="View">
                                <i class="fa fa-eye text-xs"></i>
                            </a>
                            <a href="{{ route('companies.locations.edit', [$company, $location]) }}"
                               class="rounded p-1.5 text-gray-400 hover:bg-indigo-50 hover:text-indigo-600" title="Edit">
                                <i class="fa fa-pen text-xs"></i>
                            </a>
                            <form action="{{ route('companies.locations.destroy', [$company, $location]) }}" method="POST"
                                  onsubmit="return confirm('Delete this location?')">
                                @csrf @method('DELETE')
                                <button type="submit"
                                        class="rounded p-1.5 text-gray-400 hover:bg-red-50 hover:text-red-600" title="Delete">
                                    <i class="fa fa-trash text-xs"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div class="py-12 text-center text-gray-400">
            <i class="fa fa-location-dot text-3xl mb-3 block opacity-30"></i>
            No locations yet.
            <a href="{{ route('companies.locations.create', $company) }}" class="ml-1 text-indigo-600 hover:underline">Add one</a>.
        </div>
        @endif
    </div>

</div>
@endsection