{{-- resources/views/companies/index.blade.php --}}
@extends('dashboard.app')

@section('title', 'Companies')

@section('content')
<div class="space-y-5">

    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Companies</h1>
            <p class="mt-1 text-sm text-gray-500">Manage all registered companies.</p>
        </div>
        <a href="{{ route('companies.create') }}"
           class="inline-flex items-center gap-2 rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
            <i class="fa fa-plus text-xs"></i>
            New Company
        </a>
    </div>

    {{-- Filters --}}
    <form method="GET" action="{{ route('companies.index') }}"
          class="flex flex-wrap items-center gap-3 rounded-xl border border-gray-200 bg-white p-4 shadow-sm">
        <div class="flex-1 min-w-[200px]">
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Search by name, email, industry…"
                   class="w-full rounded-lg border border-gray-300 bg-gray-50 px-3 py-2 text-sm focus:border-indigo-400 focus:outline-none focus:ring-1 focus:ring-indigo-400">
        </div>
        <div>
            <select name="status"
                    class="rounded-lg border border-gray-300 bg-gray-50 px-3 py-2 text-sm focus:border-indigo-400 focus:outline-none focus:ring-1 focus:ring-indigo-400">
                <option value="">All Statuses</option>
                @foreach(['pending','active','inactive','blocked'] as $s)
                    <option value="{{ $s }}" @selected(request('status') === $s)>
                        {{ ucfirst($s) }}
                    </option>
                @endforeach
            </select>
        </div>
        <button type="submit"
                class="inline-flex items-center gap-2 rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700">
            <i class="fa fa-magnifying-glass text-xs"></i> Search
        </button>
        @if(request()->hasAny(['search','status']))
            <a href="{{ route('companies.index') }}"
               class="inline-flex items-center gap-1 text-sm text-gray-500 hover:text-gray-700">
                <i class="fa fa-xmark"></i> Clear
            </a>
        @endif
    </form>

    {{-- Table --}}
    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
        <table class="w-full text-sm">
            <thead class="border-b border-gray-200 bg-gray-50 text-xs uppercase tracking-wide text-gray-500">
                <tr>
                    <th class="px-5 py-3 text-left">Company</th>
                    <th class="px-5 py-3 text-left">Industry</th>
                    <th class="px-5 py-3 text-left">Contact</th>
                    <th class="px-5 py-3 text-left">Locations</th>
                    <th class="px-5 py-3 text-left">Status</th>
                    <th class="px-5 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($companies as $company)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-5 py-3">
                        <div class="flex items-center gap-3">
                            @if($company->logo)
                                <img src="{{ Storage::url($company->logo) }}" alt="{{ $company->name }}"
                                     class="h-9 w-9 rounded-lg object-cover ring-1 ring-gray-200">
                            @else
                                <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-indigo-100 text-indigo-600 font-bold text-sm">
                                    {{ strtoupper(substr($company->name, 0, 2)) }}
                                </div>
                            @endif
                            <div>
                                <p class="font-medium text-gray-900">{{ $company->name }}</p>
                                <p class="text-xs text-gray-400">{{ $company->slug }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-5 py-3 text-gray-600">{{ $company->industry ?? '—' }}</td>
                    <td class="px-5 py-3">
                        <p class="text-gray-600">{{ $company->email ?? '—' }}</p>
                        <p class="text-xs text-gray-400">{{ $company->telephone ?? '' }}</p>
                    </td>
                    <td class="px-5 py-3">
                        <a href="{{ route('companies.locations.index', $company) }}"
                           class="inline-flex items-center gap-1 rounded-full bg-blue-50 px-2.5 py-0.5 text-xs font-medium text-blue-700 hover:bg-blue-100">
                            <i class="fa fa-location-dot text-[10px]"></i>
                            {{ $company->locations_count }}
                        </a>
                    </td>
                    <td class="px-5 py-3">
                        @include('companies.partials.status-badge', ['status' => $company->status])
                    </td>
                    <td class="px-5 py-3 text-right">
                        <div class="inline-flex items-center gap-1">
                            <a href="{{ route('companies.show', $company) }}"
                               class="rounded p-1.5 text-gray-400 hover:bg-gray-100 hover:text-gray-700"
                               title="View">
                                <i class="fa fa-eye text-xs"></i>
                            </a>
                            <a href="{{ route('companies.edit', $company) }}"
                               class="rounded p-1.5 text-gray-400 hover:bg-indigo-50 hover:text-indigo-600"
                               title="Edit">
                                <i class="fa fa-pen text-xs"></i>
                            </a>
                            <form action="{{ route('companies.destroy', $company) }}" method="POST"
                                  onsubmit="return confirm('Delete {{ addslashes($company->name) }}? This cannot be undone.')">
                                @csrf @method('DELETE')
                                <button type="submit"
                                        class="rounded p-1.5 text-gray-400 hover:bg-red-50 hover:text-red-600"
                                        title="Delete">
                                    <i class="fa fa-trash text-xs"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-5 py-12 text-center text-gray-400">
                        <i class="fa fa-building text-3xl mb-3 block opacity-30"></i>
                        No companies found.
                        <a href="{{ route('companies.create') }}" class="ml-1 text-indigo-600 hover:underline">Add one</a>.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if($companies->hasPages())
        <div>{{ $companies->links() }}</div>
    @endif

</div>
@endsection