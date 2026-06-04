{{-- resources/views/companies/create.blade.php --}}
@extends('dashboard.app')

@section('title', 'New Company')

@section('content')
<div class="max-w-4xl space-y-5">

    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 text-sm text-gray-500">
        <a href="{{ route('companies.index') }}" class="hover:text-indigo-600">Companies</a>
        <i class="fa fa-chevron-right text-[10px]"></i>
        <span class="text-gray-800 font-medium">New Company</span>
    </nav>

    <div>
        <h1 class="text-2xl font-bold text-gray-900">New Company</h1>
        <p class="mt-1 text-sm text-gray-500">Fill in the details below to register a new company.</p>
    </div>

    @include('companies.partials.form', [
        'action' => route('companies.store'),
        'method' => null,
    ])

</div>
@endsection