@extends('dashboard.app')
@section('content')
  <main class="dashboard-content">
    <div class="container-fluid px-3 px-lg-4 py-4">
      <div class="page-heading">
        <div class="page-heading-copy">
          <span class="page-icon"><i class="bi bi-speedometer2" aria-hidden="true"></i></span>
          <div>
            <p class="eyebrow mb-1">{{ __('dashboard.index.overview') }}</p>
            <h1 class="h3 mb-1">{{ __('dashboard.index.title') }}</h1>
            <p class="text-muted mb-0">{{ __('dashboard.index.description') }}</p>
          </div>
        </div>
        <div class="heading-actions"><button class="btn btn-outline-secondary btn-sm" type="button"><i class="bi bi-download" aria-hidden="true"></i> {{ __('dashboard.common.export') }}</button><button class="btn btn-primary btn-sm" type="button"><i class="bi bi-file-earmark-plus" aria-hidden="true"></i> {{ __('dashboard.common.create_report') }}</button></div>
      </div>

      <section class="row g-3 mt-1" aria-label="Dashboard metrics">
        <div class="col-12 col-sm-6 col-xl-3">
          <article class="metric-card metric-primary">
            <div class="metric-top">
              <span class="metric-label">{{ __('products.products') }}</span>
              <span class="nav-icon"><i class="bi bi-box-seam" aria-hidden="true"></i></span>
            </div>
            <div class="metric-value">{{ number_format($metrics['productCount'] ?? 0) }}</div>
            <div class="metric-meta">
              <span class="text-success">{{ number_format($metrics['productCount'] ?? 0) }}</span>
              <span>{{ __('products.products') }}</span>
            </div>
          </article>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
          <article class="metric-card metric-success">
            <div class="metric-top">
              <span class="metric-label">{{ __('messages.categories') }}</span>
              <span class="metric-icon"><i class="bi bi-bag-check" aria-hidden="true"></i></span>
            </div>
            <div class="metric-value">{{ number_format($metrics['categoryCounts'] ?? 0) }}</div>
            <div class="metric-meta">
              <span class="text-success">{{ number_format($metrics['categoryCounts'] ?? 0) }}</span>
              <span>{{ __('messages.categories') }}</span>
            </div>
          </article>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
          <article class="metric-card metric-warning">
            <div class="metric-top">
              <span class="metric-label">{{ __('users.company') }}</span>
              <span class="metric-icon"><i class="bi bi-building" aria-hidden="true"></i></span>
            </div>
            <div class="metric-value">{{ number_format($metrics['companies'] ?? 0) }}</div>
            <div class="metric-meta">
              <span class="text-success">{{ number_format($metrics['companies'] ?? 0) }}</span>
              <span>{{ __('users.company') }}</span>
            </div>
          </article>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
          <article class="metric-card metric-danger">
            <div class="metric-top">
              <span class="metric-label">{{ __('dashboard.sidebar.users') }}</span>
              <span class="metric-icon"><i class="bi bi-people" aria-hidden="true"></i></span>
            </div>
            <div class="metric-value">{{ number_format($metrics['active_users'] ?? 0) }}</div>
            <div class="metric-meta">
              <span class="text-danger">{{ number_format($metrics['active_users'] ?? 0) }}</span>
              <span>{{ __('dashboard.index.active_users') }}</span>
            </div>
          </article>
        </div>
      </section>

      <section class="row g-3 mt-1">
        <div class="col-12 col-xl-8">
          <div class="panel">
            <div class="panel-header">
              <div>
                <h2 class="h5 mb-1 section-title"><i class="bi bi-graph-up-arrow" aria-hidden="true"></i><span>{{ __('dashboard.index.sales_performance') }}</span></h2>
                <p class="text-muted mb-0">{{ __('dashboard.index.monthly_revenue') }}</p>
              </div>
              <a class="btn btn-light btn-sm" href="{{ route('charts') }}">{{ __('dashboard.index.view_details') }}</a>
            </div>

            <div class="chart-bars" aria-label="Sales performance chart">
              <div class="chart-column bar-42"><span></span><small>{{ __('dashboard.months.jan') }}</small></div>
              <div class="chart-column bar-58"><span></span><small>{{ __('dashboard.months.feb') }}</small></div>
              <div class="chart-column bar-51"><span></span><small>{{ __('dashboard.months.mar') }}</small></div>
              <div class="chart-column bar-72"><span></span><small>{{ __('dashboard.months.apr') }}</small></div>
              <div class="chart-column bar-66"><span></span><small>{{ __('dashboard.months.may') }}</small></div>
              <div class="chart-column bar-83"><span></span><small>{{ __('dashboard.months.jun') }}</small></div>
            </div>
          </div>
        </div>

        <div class="col-12 col-xl-4">
          <div class="panel h-100">
            <div class="panel-header">
              <div>
                <h2 class="h5 mb-1 section-title"><i class="bi bi-activity" aria-hidden="true"></i><span>{{ __('dashboard.index.team_activity') }}</span></h2>
                <p class="text-muted mb-0">{{ __('dashboard.index.recent_updates') }}</p>
              </div>
            </div>

            <div class="activity-list">
              @forelse($recentActivities as $activity)
                <div class="activity-item">
                  <span class="activity-dot {{ $activity['icon_class'] }}"></span>
                  <div>
                    <p class="mb-1 fw-semibold">{{ $activity['title'] }}</p>
                    <p class="text-muted small mb-0">{{ $activity['description'] }}</p>
                  </div>
                </div>
              @empty
                <div class="activity-item">
                  <div>
                    <p class="mb-1 fw-semibold">{{ __('dashboard.common.no_data') }}</p>
                  </div>
                </div>
              @endforelse
            </div>
          </div>
        </div>
      </section>

      <section class="panel mt-3">
        <div class="panel-header">
          <div>
            <h2 class="h5 mb-1 section-title"><i class="bi bi-people" aria-hidden="true"></i><span>{{ __('dashboard.index.recent_users') }}</span></h2>
            <p class="text-muted mb-0">{{ __('dashboard.index.latest_activity') }}</p>
          </div>
          <a class="btn btn-outline-secondary btn-sm" href="{{ route('users.index') }}">{{ __('dashboard.index.manage_users') }}</a>
        </div>
        <div class="table-responsive">
          <table class="table align-middle mb-0">
            <thead>
              <tr>
                <th scope="col">{{ __('dashboard.index.table_user') }}</th>
                <th scope="col">{{ __('dashboard.index.table_role') }}</th>
                <th scope="col">{{ __('users.company') }}</th>
                <th scope="col">{{ __('dashboard.index.table_status') }}</th>
                <th scope="col">{{ __('dashboard.index.table_joined') }}</th>
                <th scope="col" class="text-end">{{ __('dashboard.common.action') }}</th>
              </tr>
            </thead>
            <tbody>
              @foreach($users as $user)
                <tr>
                  <td>
                    <div class="d-flex align-items-center gap-2">
                      {{-- <img class="avatar-img avatar-sm" src="{{ $user->avatar ? asset('storage/' . $user->avatar) : asset('dashboard/assets/images/avatar/avatar-1.jpg') }}" alt="{{ trim($user->firstname . ' ' . $user->lastname) }}"> --}}
                      <div>
                        <p class="fw-semibold mb-0">{{ trim($user->firstname . ' ' . $user->lastname) ?: $user->email }}</p>
                        <p class="text-muted small mb-0">{{ $user->email }}</p>
                      </div>
                    </div>
                  </td>
                  <td>{{ $user->roles->first()->name ?? 'User' }}</td>
                  <td>
                    @if ($user->company)
                        <span class="badge bg-light text-dark">{{ $user->company->name }}</span>
                    @else
                        <span class="badge bg-secondary">-</span>
                    @endif</td>
                  <td>
                    @php
                      $statusClass = match($user->status ?? 'active') {
                        'active' => 'text-bg-success',
                        'pending' => 'text-bg-warning',
                        'suspended' => 'text-bg-secondary',
                        default => 'text-bg-info'
                      };
                    @endphp
                    <span class="badge {{ $statusClass }}">{{ __('dashboard.statuses.' . ($user->status ?? 'active')) }}</span>
                  </td>
                  <td>{{ $user->created_at->format('M d, Y') }}</td>
                  <td class="text-end">
                    <a class="btn btn-light btn-sm" href="{{ route('users.show', $user) }}">{{ __('dashboard.common.view') }}</a>
                  </td>
                </tr>
              @endforeach
              @if($users->isEmpty())
                <tr>
                  <td colspan="6" class="text-center py-4 text-muted">
                    {{ __('dashboard.common.no_data') }}
                  </td>
                </tr>
              @endif
            </tbody>
          </table>
        </div>
      </section>

      <section class="panel mt-3">
        <div class="panel-header">
          <div>
            <h2 class="h5 mb-1 section-title"><i class="bi bi-box-seam" aria-hidden="true"></i><span>{{ __('dashboard.index.recent_products') ?? 'Recent Products' }}</span></h2>
            <p class="text-muted mb-0">{{ __('dashboard.index.latest_products_added') ?? 'Latest products added to your store' }}</p>
          </div>
          <a class="btn btn-outline-secondary btn-sm" href="{{ route('products.index') }}">{{ __('dashboard.index.manage_products') ?? 'Manage Products' }}</a>
        </div>
        <div class="table-responsive">
          <table class="table align-middle mb-0">
            <thead>
              <tr>
                <th scope="col">{{ __('messages.product') ?? 'Product' }}</th>
                <th scope="col">{{ __('messages.sku') ?? 'SKU' }}</th>
                <th scope="col">{{ __('messages.category') ?? 'Category' }}</th>
                <th scope="col">{{ __('messages.price') ?? 'Price' }}</th>
                <th scope="col">{{ __('messages.status') ?? 'Status' }}</th>
                <th scope="col" class="text-end">{{ __('dashboard.common.action') }}</th>
              </tr>
            </thead>
            <tbody>
              @foreach($products as $product)
                <tr>
                  <td>
                    <div class="d-flex align-items-center gap-2">
                      @php $featured = $product->images->where('is_featured', true)->first() ?? $product->images->first(); @endphp
                      @if($featured)
                        <img class="avatar-img avatar-sm" src="{{ asset('storage/' . $featured->image) }}" alt="{{ $product->name }}">
                      @else
                        <div class="avatar-sm bg-light d-flex align-items-center justify-content-center border rounded">
                          <i class="bi bi-box text-muted"></i>
                        </div>
                      @endif
                      <div>
                        <p class="fw-semibold mb-0">{{ $product->name }}</p>
                        <p class="text-muted small mb-0">{{ $product->brand->name ?? '' }}</p>
                      </div>
                    </div>
                  </td>
                  <td>{{ $product->sku }}</td>
                  <td>{{ $product->category->name ?? 'N/A' }}</td>
                  <td>{{ number_format($product->price, 2) }}</td>
                  <td>
                    @php
                      $statusClass = match($product->status) {
                        'published' => 'text-bg-success',
                        'draft' => 'text-bg-warning',
                        'out_of_stock' => 'text-bg-danger',
                        'inactive' => 'text-bg-secondary',
                        default => 'text-bg-info'
                      };
                    @endphp
                    <span class="badge {{ $statusClass }}">{{ ucfirst(str_replace('_', ' ', $product->status)) }}</span>
                  </td>
                  <td class="text-end">
                    <a class="btn btn-light btn-sm" href="{{ route('products.show', $product) }}">{{ __('dashboard.common.view') }}</a>
                  </td>
                </tr>
              @endforeach
              @if($products->isEmpty())
                <tr>
                  <td colspan="6" class="text-center py-4 text-muted">
                    {{ __('messages.no_items') ?? 'No products found.' }}
                  </td>
                </tr>
              @endif
            </tbody>
          </table>
        </div>
      </section>
    </div>
  </main>

@endsection