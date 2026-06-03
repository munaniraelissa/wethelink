@extends('dashboard.app')
@section('content')
<main class="dashboard-content">
  <div class="container-fluid px-3 px-lg-4 py-4">
    <div class="page-heading">
      <div class="page-heading-copy">
        <span class="page-icon"><i class="bi bi-shield-lock" aria-hidden="true"></i></span>
        <div>
          <p class="eyebrow mb-1">{{ __('dashboard.role.management') }}</p>
          <h1 class="h3 mb-1">{{ __('dashboard.role.roles') }}</h1>
          <p class="text-muted mb-0">{{ __('dashboard.role.manage_roles_desc') }}</p>
        </div>
      </div>
      <div class="heading-actions">
        <a class="btn btn-primary btn-sm" href="{{ route('roles.create') }}">
          <i class="bi bi-plus-circle" aria-hidden="true"></i> {{ __('dashboard.role.add_role') }}
        </a>
      </div>
    </div>

    @if ($message = Session::get('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>{{ __('dashboard.common.success') }}!</strong> {{ $message }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif

    @if ($message = Session::get('warning'))
      <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>{{ __('dashboard.common.warning') }}!</strong> {{ $message }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif

    @if ($message = Session::get('error'))
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>{{ __('dashboard.common.error') }}!</strong> {{ $message }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif

    <section class="panel mt-3">
      <div class="panel-header">
        <div>
          <h2 class="h5 mb-1 section-title"><i class="bi bi-table" aria-hidden="true"></i><span>{{ __('dashboard.role.role_list') }}</span></h2>
          <p class="text-muted mb-0">{{ __('dashboard.role.search_roles_desc') }}</p>
        </div>
        <div class="d-flex flex-wrap gap-2">
          <input class="form-control form-control-sm table-search" type="search" placeholder="{{ __('dashboard.role.search_roles') }}" data-table-search="rolesTable" aria-label="{{ __('dashboard.role.search_roles') }}">
          @can('role-create')
            <a class="btn btn-primary btn-sm" href="{{ route('roles.create') }}">
              <i class="bi bi-plus-circle" aria-hidden="true"></i> {{ __('dashboard.role.add_role') }}
            </a>
          @endcan
        </div>
      </div>
      <div class="table-responsive">
        <table class="table align-middle mb-0" id="rolesTable" data-searchable-table>
          <thead>
            <tr>
              <th scope="col">{{ __('dashboard.role.name') }}</th>
              <th scope="col">{{ __('dashboard.role.permissions_count') }}</th>
              <th scope="col">{{ __('dashboard.role.status') }}</th>
              <th scope="col" class="text-end">{{ __('dashboard.common.action') }}</th>
            </tr>
          </thead>
          <tbody>
            @forelse($roles as $role)
              <tr>
                <td>
                  <p class="fw-semibold mb-0">{{ $role->name }}</p>
                  @if($role->is_protected)
                    <span class="badge bg-warning">{{ __('dashboard.role.protected') }}</span>
                  @endif
                </td>
                <td>
                  <span class="badge bg-info">{{ $role->permissions->count() }}</span>
                </td>
                <td>
                  @if($role->is_protected)
                    <span class="badge text-bg-warning">{{ __('dashboard.role.locked') }}</span>
                  @else
                    <span class="badge text-bg-success">{{ __('dashboard.role.editable') }}</span>
                  @endif
                </td>
                <td class="text-end">
                  @can('role-list')
                    <a class="btn btn-light btn-sm" href="{{ route('roles.show', $role->id) }}">
                      {{ __('dashboard.common.view') }}
                    </a>
                  @endcan
                  @can('role-edit')
                    @if(!$role->is_protected)
                      <a class="btn btn-light btn-sm" href="{{ route('roles.edit', $role->id) }}">
                        {{ __('dashboard.common.edit') }}
                      </a>
                    @else
                      <button class="btn btn-light btn-sm" disabled title="{{ __('dashboard.role.cannot_edit_protected') }}">
                        {{ __('dashboard.common.edit') }}
                      </button>
                    @endif
                  @endcan
                  @can('role-delete')
                    @if(!$role->is_protected && !in_array($role->name, ['Admin', 'Normal Member']))
                      <form action="{{ route('roles.destroy', $role->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('{{ __('dashboard.common.confirm_delete') }}');">
                          {{ __('dashboard.common.delete') }}
                        </button>
                      </form>
                    @endif
                  @endcan
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="4" class="text-center py-4">
                  <p class="text-muted">{{ __('dashboard.common.no_data') }}</p>
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
      @if($roles->hasPages())
        <div class="d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-3 mt-3">
          <p class="text-muted small mb-0">
            {{ __('dashboard.common.showing') }} 
            {{ $roles->firstItem() }} 
            {{ __('dashboard.common.to') }} 
            {{ $roles->lastItem() }} 
            {{ __('dashboard.common.of') }} 
            {{ $roles->total() }}
          </p>
          {{ $roles->links() }}
        </div>
      @endif
    </section>
  </div>
</main>
@endsection
