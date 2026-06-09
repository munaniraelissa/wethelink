{{-- resources/views/companies/locations/index.blade.php --}}
@extends('dashboard.app')

@section('title', $company->name . ' — Locations')

@section('content')
<div class="space-y-5">

    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 text-sm text-gray-500">
        <a href="{{ route('companies.index') }}" class="hover:text-indigo-600">Companies</a>
        <i class="fa fa-chevron-right text-[10px]"></i>
        <a href="{{ route('companies.show', $company) }}" class="hover:text-indigo-600">{{ $company->name }}</a>
        <i class="fa fa-chevron-right text-[10px]"></i>
        <span class="text-gray-800 font-medium">Locations</span>
    </nav>

    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Locations</h1>
            <p class="mt-1 text-sm text-gray-500">All branches and offices for <span class="font-medium text-gray-700">{{ $company->name }}</span>.</p>
        </div>
        <a href="{{ route('companies.locations.create', $company) }}"
           class="inline-flex items-center gap-2 rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
            <i class="fa fa-plus text-xs"></i>
            New Location
        </a>
    </div>

    {{-- Table --}}
    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
        <table class="w-full text-sm">
            <thead class="border-b border-gray-200 bg-gray-50 text-xs uppercase tracking-wide text-gray-500">
                <tr>
                    <th class="px-5 py-3 text-left">Name</th>
                    <th class="px-5 py-3 text-left">Address</th>
                    <th class="px-5 py-3 text-left">Contact</th>
                    <th class="px-5 py-3 text-left">Manager</th>
                    <th class="px-5 py-3 text-left">Type</th>
                    <th class="px-5 py-3 text-left">Status</th>
                    <th class="px-5 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($locations as $location)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-5 py-3">
                        <p class="font-medium text-gray-900">{{ $location->name }}</p>
                    </td>
                    <td class="px-5 py-3 text-gray-600">
                        <p>{{ collect([$location->city, $location->district, $location->province])->filter()->implode(', ') ?: '—' }}</p>
                        <p class="text-xs text-gray-400">{{ $location->country ?? '' }}</p>
                    </td>
                    <td class="px-5 py-3">
                        <p class="text-gray-600">{{ $location->email ?? '—' }}</p>
                        <p class="text-xs text-gray-400">{{ $location->telephone ?? '' }}</p>
                    </td>
                    <td class="px-5 py-3 text-gray-600">{{ $location->manager_name ?? '—' }}</td>
                    <td class="px-5 py-3">
                        @if($location->is_head_office)
                            <span class="inline-flex items-center rounded-full bg-indigo-50 px-2.5 py-0.5 text-xs font-medium text-indigo-700 ring-1 ring-indigo-200">
                                <i class="fa fa-star text-[9px] mr-1"></i> Head Office
                            </span>
                        @else
                            <span class="text-xs text-gray-400">Branch</span>
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
                                  onsubmit="return confirm('Delete {{ addslashes($location->name) }}? This cannot be undone.')">
                                @csrf @method('DELETE')
                                <button type="submit"
                                        class="rounded p-1.5 text-gray-400 hover:bg-red-50 hover:text-red-600" title="Delete">
                                    <i class="fa fa-trash text-xs"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-5 py-12 text-center text-gray-400">
                        <i class="fa fa-location-dot text-3xl mb-3 block opacity-30"></i>
                        No locations yet.
                        <a href="{{ route('companies.locations.create', $company) }}" class="ml-1 text-indigo-600 hover:underline">Add one</a>.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if($locations->hasPages())
        <div>{{ $locations->links() }}</div>
    @endif

</div>
@endsection