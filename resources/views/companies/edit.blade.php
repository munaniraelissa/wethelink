{{-- resources/views/companies/edit.blade.php --}}
@extends('dashboard.app')

@section('title', 'Edit — ' . $company->name)

@section('content')
<div class="max-w-4xl space-y-5">

    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 text-sm text-gray-500">
        <a href="{{ route('companies.index') }}" class="hover:text-indigo-600">Companies</a>
        <i class="fa fa-chevron-right text-[10px]"></i>
        <a href="{{ route('companies.show', $company) }}" class="hover:text-indigo-600">{{ $company->name }}</a>
        <i class="fa fa-chevron-right text-[10px]"></i>
        <span class="text-gray-800 font-medium">Edit</span>
    </nav>

    <div>
        <h1 class="text-2xl font-bold text-gray-900">Edit: {{ $company->name }}</h1>
        <p class="mt-1 text-sm text-gray-500">Update the company details below.</p>
    </div>

    @include('companies.partials.form', [
        'action' => route('companies.update', $company),
        'method' => 'PUT',
        'company' => $company,
    ])

</div>
@endsection