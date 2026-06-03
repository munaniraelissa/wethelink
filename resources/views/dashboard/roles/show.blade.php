@extends('dashboard.app')
@section('content')
<main class="dashboard-content">
  <div class="container-fluid px-3 px-lg-4 py-4">
    <div class="page-heading">
      <div class="page-heading-copy">
        <span class="page-icon"><i class="bi bi-eye" aria-hidden="true"></i></span>
        <div>
          <p class="eyebrow mb-1">{{ __('dashboard.role.management') }}</p>
          <h1 class="h3 mb-1">{{ $role->name }}</h1>
          <p class="text-muted mb-0">{{ __('dashboard.role.view_role_desc') }}</p>
        </div>
      </div>
      <div class="heading-actions">
        <a class="btn btn-outline-secondary btn-sm" href="{{ route('roles.index') }}">
          <i class="bi bi-arrow-left" aria-hidden="true"></i> {{ __('dashboard.common.back') }}
        </a>
      </div>
    </div>

    <section class="row g-3">
      <div class="col-12 col-xl-8">
        <div class="panel">
          <div class="panel-header">
            <div>
              <h2 class="h5 mb-1 section-title"><i class="bi bi-info-circle" aria-hidden="true"></i><span>{{ __('dashboard.role.role_details') }}</span></h2>
              <p class="text-muted mb-0">{{ __('dashboard.role.role_details_desc') }}</p>
            </div>
          </div>
          <div class="row g-3">
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">{{ __('dashboard.role.role_name') }}</label>
                <div class="form-control-plaintext">{{ $role->name }}</div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">{{ __('dashboard.role.status') }}</label>
                <div class="form-control-plaintext">
                  @if($role->is_protected)
                    <span class="badge text-bg-warning">{{ __('dashboard.role.protected') }}</span>
                  @else
                    <span class="badge text-bg-success">{{ __('dashboard.role.editable') }}</span>
                  @endif
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">{{ __('dashboard.role.created_at') }}</label>
                <div class="form-control-plaintext">{{ $role->created_at->format('M d, Y H:i') }}</div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">{{ __('dashboard.role.updated_at') }}</label>
                <div class="form-control-plaintext">{{ $role->updated_at->format('M d, Y H:i') }}</div>
              </div>
            </div>
          </div>
        </div>

        <div class="panel mt-3">
          <div class="panel-header">
            <div>
              <h2 class="h5 mb-1 section-title"><i class="bi bi-check2-square" aria-hidden="true"></i><span>{{ __('dashboard.role.assigned_permissions') }}</span></h2>
              <p class="text-muted mb-0">{{ __('dashboard.role.permissions_list_desc') }}</p>
            </div>
          </div>
          <div class="row g-3">
            @forelse($role->permissions->groupBy('module') as $module => $permissions)
              <div class="col-12">
                <div class="border-bottom pb-3">
                  <h6 class="mb-3 fw-semibold">{{ ucfirst($module) }}</h6>
                  <div class="row g-2">
                    @foreach($permissions as $permission)
                      <div class="col-md-6">
                        <span class="badge bg-primary">{{ $permission->name }}</span>
                      </div>
                    @endforeach
                  </div>
                </div>
              </div>
            @empty
              <div class="col-12">
                <p class="text-muted text-center py-3">{{ __('dashboard.role.no_permissions') }}</p>
              </div>
            @endforelse
          </div>
        </div>
      </div>
      <div class="col-12 col-xl-4">
        <div class="panel h-100">
          <h2 class="h5 mb-3 section-title"><i class="bi bi-tools" aria-hidden="true"></i><span>{{ __('dashboard.common.actions') }}</span></h2>
          <div class="d-flex flex-column gap-2">
            @can('role-edit')
              @if(!$role->is_protected)
                <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-primary">
                  <i class="bi bi-pencil-square" aria-hidden="true"></i> {{ __('dashboard.common.edit') }}
                </a>
              @else
                <button class="btn btn-primary" disabled title="{{ __('dashboard.role.cannot_edit_protected') }}">
                  <i class="bi bi-pencil-square" aria-hidden="true"></i> {{ __('dashboard.common.edit') }}
                </button>
              @endif
            @endcan
            @can('role-delete')
              @if(!$role->is_protected && !in_array($role->name, ['Admin', 'Normal Member']))
                <form action="{{ route('roles.destroy', $role->id) }}" method="POST">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-danger w-100" onclick="return confirm('{{ __('dashboard.common.confirm_delete') }}');">
                    <i class="bi bi-trash" aria-hidden="true"></i> {{ __('dashboard.common.delete') }}
                  </button>
                </form>
              @endif
            @endcan
          </div>
          
          <div class="mt-4 pt-3 border-top">
            <h6 class="mb-3 fw-semibold">{{ __('dashboard.common.info') }}</h6>
            <div class="activity-list">
              <div class="activity-item">
                <span class="activity-dot bg-info"></span>
                <div>
                  <p class="mb-1 small fw-semibold">{{ __('dashboard.role.total_permissions') }}</p>
                  <p class="text-muted small mb-0">{{ $role->permissions->count() }}</p>
                </div>
              </div>
              <div class="activity-item">
                <span class="activity-dot bg-success"></span>
                <div>
                  <p class="mb-1 small fw-semibold">{{ __('dashboard.role.assigned_to_users') }}</p>
                  <p class="text-muted small mb-0">{{ $role->users->count() }} {{ __('dashboard.common.users') }}</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</main>
@endsection
