@extends('dashboard.app')

@section('content')
<div class="container-fluid">
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="page-title">{{ __('users.users_management') }}</h1>
                <p class="text-muted">{{ __('users.manage_system_users') }}</p>
            </div>
            <div class="col-md-4 text-end">
                <a href="{{ route('users.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> {{ __('users.add_new_user') }}
                </a>
            </div>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>{{ __('users.error') }}!</strong>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <div class="row g-3">
                <div class="col-md-4">
                    <form method="GET" action="{{ route('users.index') }}" class="d-flex gap-2">
                        <input type="text" name="search" class="form-control" 
                               placeholder="{{ __('users.search_users') }}" 
                               value="{{ request('search') }}">
                        <button type="submit" class="btn btn-outline-primary">
                            <i class="bi bi-search"></i>
                        </button>
                    </form>
                </div>
                <div class="col-md-3">
                    <select name="status" class="form-select" onchange="filterByStatus(this)">
                        <option value="">{{ __('users.all_statuses') }}</option>
                        @foreach ($statuses as $status)
                            <option value="{{ $status }}" {{ request('status') === $status ? 'selected' : '' }}>
                                {{ __('users.status_' . $status) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="company_id" class="form-select" onchange="filterByCompany(this)">
                        <option value="">{{ __('users.all_companies') }}</option>
                        @foreach ($companies as $company)
                            <option value="{{ $company->id }}" {{ request('company_id') == $company->id ? 'selected' : '' }}>
                                {{ $company->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>{{ __('users.id') }}</th>
                            <th>{{ __('users.name') }}</th>
                            <th>{{ __('users.email') }}</th>
                            <th>{{ __('users.telephone') }}</th>
                            <th>{{ __('users.company') }}</th>
                            <th>{{ __('users.status') }}</th>
                            <th>{{ __('users.joined_date') }}</th>
                            <th>{{ __('users.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                            <tr>
                                <td>#{{ $user->id }}</td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        @if ($user->avatar)
                                            <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->firstname }}" 
                                                 class="rounded-circle" width="32" height="32">
                                        @else
                                            <div class="avatar rounded-circle bg-light d-flex align-items-center justify-content-center" 
                                                 style="width: 32px; height: 32px;">
                                                <span class="text-muted">{{ strtoupper(substr($user->firstname, 0, 1)) }}</span>
                                            </div>
                                        @endif
                                        <div>
                                            <div class="fw-bold">{{ $user->firstname }} {{ $user->lastname }}</div>
                                            @if ($user->roles->count())
                                                <small class="text-muted">{{ $user->roles->pluck('name')->join(', ') }}</small>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->telephone }}</td>
                                <td>
                                    @if ($user->company)
                                        <span class="badge bg-light text-dark">{{ $user->company->name }}</span>
                                    @else
                                        <span class="badge bg-secondary">-</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-{{ $user->status === 'active' ? 'success' : ($user->status === 'inactive' ? 'danger' : 'warning') }}">
                                        {{ __('users.status_' . $user->status) }}
                                    </span>
                                </td>
                                <td>{{ $user->created_at->format('d M Y') }}</td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('users.show', $user) }}" class="btn btn-outline-info" 
                                           title="{{ __('users.view') }}">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('users.edit', $user) }}" class="btn btn-outline-warning" 
                                           title="{{ __('users.edit') }}">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form method="POST" action="{{ route('users.destroy', $user) }}" 
                                              style="display: inline;" 
                                              onsubmit="return confirm('{{ __('users.confirm_delete') }}');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger" 
                                                    title="{{ __('users.delete') }}">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-5">
                                    {{ __('users.no_users_found') }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
            <nav class="d-flex justify-content-between align-items-center">
                <div class="text-muted small">
                    {{ __('users.showing') }} {{ $users->firstItem() ?? 0 }} {{ __('users.to') }} 
                    {{ $users->lastItem() ?? 0 }} {{ __('users.of') }} {{ $users->total() }}
                </div>
                {{ $users->links('pagination::bootstrap-4') }}
            </nav>
        </div>
    </div>
</div>

<script>
function filterByStatus(select) {
    const url = new URL(window.location);
    if (select.value) {
        url.searchParams.set('status', select.value);
    } else {
        url.searchParams.delete('status');
    }
    window.location = url;
}

function filterByCompany(select) {
    const url = new URL(window.location);
    if (select.value) {
        url.searchParams.set('company_id', select.value);
    } else {
        url.searchParams.delete('company_id');
    }
    window.location = url;
}
</script>
@endsection
