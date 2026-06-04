{{-- resources/views/companies/partials/status-badge.blade.php --}}
@php
$map = [
    'active'   => 'bg-green-50 text-green-700 ring-green-200',
    'inactive' => 'bg-gray-100 text-gray-600 ring-gray-200',
    'pending'  => 'bg-yellow-50 text-yellow-700 ring-yellow-200',
    'blocked'  => 'bg-red-50 text-red-700 ring-red-200',
];
$classes = $map[$status] ?? 'bg-gray-100 text-gray-600 ring-gray-200';
@endphp
<span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium ring-1 {{ $classes }}">
    {{ ucfirst($status) }}
</span>