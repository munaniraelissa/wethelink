@extends('dashboard.app')
@section('content')
<main class="dashboard-content">
  <div class="container-fluid px-3 px-lg-4 py-4">
    <div class="page-heading">
      <div class="page-heading-copy">
        <span class="page-icon"><i class="bi bi-shield-plus" aria-hidden="true"></i></span>
        <div>
          <p class="eyebrow mb-1">{{ __('dashboard.role.management') }}</p>
          <h1 class="h3 mb-1">{{ __('dashboard.role.create_role') }}</h1>
          <p class="text-muted mb-0">{{ __('dashboard.role.create_role_desc') }}</p>
        </div>
      </div>
      <div class="heading-actions">
        <a class="btn btn-outline-secondary btn-sm" href="{{ route('roles.index') }}">
          <i class="bi bi-arrow-left" aria-hidden="true"></i> {{ __('dashboard.common.back') }}
        </a>
      </div>
    </div>

    @if ($errors->any())
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>{{ __('dashboard.common.validation_error') }}!</strong>
        <ul class="mb-0">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif

    <section class="row g-3">
      <div class="col-12 col-xl-8">
        <form action="{{ route('roles.store') }}" method="POST" class="panel needs-validation">
          @csrf
          <div class="panel-header">
            <div>
              <h2 class="h5 mb-1 section-title"><i class="bi bi-shield-plus" aria-hidden="true"></i><span>{{ __('dashboard.role.role_information') }}</span></h2>
              <p class="text-muted mb-0">{{ __('dashboard.role.role_info_desc') }}</p>
            </div>
          </div>
          <div class="row g-3">
            <div class="col-12">
              <label class="form-label" for="name">{{ __('dashboard.role.role_name') }}</label>
              <input class="form-control @error('name') is-invalid @enderror" id="name" type="text" name="name" value="{{ old('name') }}" required>
              <div class="invalid-feedback">{{ __('dashboard.role.name_required') }}</div>
              @error('name')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
              @enderror
            </div>
          </div>

          <div class="panel-header mt-4">
            <div>
              <h2 class="h5 mb-1 section-title"><i class="bi bi-check2-square" aria-hidden="true"></i><span>{{ __('dashboard.role.permissions') }}</span></h2>
              <p class="text-muted mb-0">{{ __('dashboard.role.select_permissions') }}</p>
            </div>
          </div>

          <div class="row g-3">
            @forelse($permissions as $module => $perms)
              <div class="col-12">
                <div class="border-bottom pb-3 mb-3">
                  <div class="form-check form-switch">
                    <input class="form-check-input module-checkbox" type="checkbox" id="module_{{ $module }}" data-module="{{ $module }}">
                    <label class="form-check-label fw-semibold" for="module_{{ $module }}">
                      {{ ucfirst($module) }}
                    </label>
                  </div>
                </div>
                <div class="row g-2 ms-3">
                  @foreach($perms as $permission)
                    <div class="col-md-6">
                      <div class="form-check">
                        <input class="form-check-input permission-checkbox" type="checkbox" id="perm_{{ $permission->id }}" name="permissions[]" value="{{ $permission->id }}" data-module="{{ $module }}">
                        <label class="form-check-label" for="perm_{{ $permission->id }}">
                          {{ $permission->name }}
                        </label>
                      </div>
                    </div>
                  @endforeach
                </div>
              </div>
            @empty
              <div class="col-12">
                <p class="text-muted">{{ __('dashboard.role.no_permissions') }}</p>
              </div>
            @endforelse
          </div>

          <div class="d-flex flex-wrap justify-content-end gap-2 mt-4">
            <a class="btn btn-outline-secondary" href="{{ route('roles.index') }}">{{ __('dashboard.common.cancel') }}</a>
            <button class="btn btn-primary" type="submit">
              <i class="bi bi-check-circle" aria-hidden="true"></i> {{ __('dashboard.role.create_role') }}
            </button>
          </div>
        </form>
      </div>
      <div class="col-12 col-xl-4">
        <div class="panel h-100">
          <h2 class="h5 mb-3 section-title"><i class="bi bi-info-circle" aria-hidden="true"></i><span>{{ __('dashboard.common.info') }}</span></h2>
          <div class="activity-list">
            <div class="activity-item">
              <span class="activity-dot bg-success"></span>
              <div>
                <p class="mb-1 fw-semibold">{{ __('dashboard.role.define_role') }}</p>
                <p class="text-muted small mb-0">{{ __('dashboard.role.define_role_desc') }}</p>
              </div>
            </div>
            <div class="activity-item">
              <span class="activity-dot bg-primary"></span>
              <div>
                <p class="mb-1 fw-semibold">{{ __('dashboard.role.assign_permissions') }}</p>
                <p class="text-muted small mb-0">{{ __('dashboard.role.assign_permissions_desc') }}</p>
              </div>
            </div>
            <div class="activity-item">
              <span class="activity-dot bg-info"></span>
              <div>
                <p class="mb-1 fw-semibold">{{ __('dashboard.role.use_role') }}</p>
                <p class="text-muted small mb-0">{{ __('dashboard.role.use_role_desc') }}</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</main>

<script>
  document.querySelectorAll('.module-checkbox').forEach(checkbox => {
    checkbox.addEventListener('change', function() {
      const module = this.dataset.module;
      const isChecked = this.checked;
      document.querySelectorAll(`.permission-checkbox[data-module="${module}"]`).forEach(perm => {
        perm.checked = isChecked;
      });
    });
  });

  document.querySelectorAll('.permission-checkbox').forEach(checkbox => {
    checkbox.addEventListener('change', function() {
      const module = this.dataset.module;
      const allChecked = document.querySelectorAll(`.permission-checkbox[data-module="${module}"]`);
      const checkedPerms = document.querySelectorAll(`.permission-checkbox[data-module="${module}"]:checked`);
      const moduleCheckbox = document.getElementById(`module_${module}`);
      moduleCheckbox.checked = allChecked.length === checkedPerms.length;
    });
  });
</script>
@endsection
