@extends('dashboard.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">{{ __('subscriptions.packages') }}</h5>
                    @can('subscription-create')
                        <a href="{{ route('subscription-packages.create') }}" class="btn btn-primary btn-sm">
                            <i class="bi bi-plus-circle"></i> {{ __('subscriptions.create_package') }}
                        </a>
                    @endcan
                </div>
                <div class="card-body">
                    <form method="GET" class="mb-3">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="text" name="search" class="form-control" placeholder="{{ __('subscriptions.search') }}" value="{{ request('search') }}">
                            </div>
                            <div class="col-md-4">
                                <select name="status" class="form-select">
                                    <option value="">{{ __('subscriptions.filter') }}</option>
                                    @foreach($statuses as $status)
                                        <option value="{{ $status }}" {{ request('status') === $status ? 'selected' : '' }}>
                                            {{ __('subscriptions.status_' . $status) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-outline-primary w-100">{{ __('subscriptions.search') }}</button>
                            </div>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>{{ __('subscriptions.id') }}</th>
                                    <th>{{ __('subscriptions.package_name') }}</th>
                                    <th>{{ __('subscriptions.pricing_monthly') }}</th>
                                    <th>{{ __('subscriptions.max_locations') }}</th>
                                    <th>{{ __('subscriptions.max_users') }}</th>
                                    <th>{{ __('subscriptions.status') }}</th>
                                    <th>{{ __('subscriptions.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($packages as $package)
                                    <tr>
                                        <td>{{ $package->id }}</td>
                                        <td>{{ $package->name }}</td>
                                        <td>${{ number_format($package->pricing_monthly, 2) }}</td>
                                        <td>{{ $package->max_locations }}</td>
                                        <td>{{ $package->max_users }}</td>
                                        <td>
                                            <span class="badge bg-{{ $package->status === 'active' ? 'success' : ($package->status === 'inactive' ? 'warning' : 'danger') }}">
                                                {{ __('subscriptions.status_' . $package->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('subscription-packages.show', $package) }}" class="btn btn-sm btn-info" title="{{ __('subscriptions.view') }}">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            @can('subscription-edit')
                                                <a href="{{ route('subscription-packages.edit', $package) }}" class="btn btn-sm btn-warning" title="{{ __('subscriptions.edit') }}">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                            @endcan
                                            @can('subscription-delete')
                                                <form action="{{ route('subscription-packages.destroy', $package) }}" method="POST" class="d-inline" onsubmit="return confirm('{{ __('subscriptions.delete') }}?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" title="{{ __('subscriptions.delete') }}">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            @endcan
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted">{{ __('subscriptions.no_packages_found') }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center">
                        {{ $packages->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
