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
              <span class="metric-label">{{ __('dashboard.index.revenue') }}</span>
              <span class="metric-icon"><i class="bi bi-currency-dollar" aria-hidden="true"></i></span>
            </div>
            <div class="metric-value">$48,240</div>
            <div class="metric-meta">
              <span class="text-success">+12.5%</span>
              <span>{{ __('dashboard.index.from_last_month') }}</span>
            </div>
          </article>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
          <article class="metric-card metric-success">
            <div class="metric-top">
              <span class="metric-label">{{ __('dashboard.index.orders') }}</span>
              <span class="metric-icon"><i class="bi bi-bag-check" aria-hidden="true"></i></span>
            </div>
            <div class="metric-value">1,284</div>
            <div class="metric-meta">
              <span class="text-success">+8.2%</span>
              <span>{{ __('dashboard.index.new_orders') }}</span>
            </div>
          </article>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
          <article class="metric-card metric-warning">
            <div class="metric-top">
              <span class="metric-label">{{ __('dashboard.index.customers') }}</span>
              <span class="metric-icon"><i class="bi bi-people" aria-hidden="true"></i></span>
            </div>
            <div class="metric-value">8,742</div>
            <div class="metric-meta">
              <span class="text-success">+5.1%</span>
              <span>{{ __('dashboard.index.active_users') }}</span>
            </div>
          </article>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
          <article class="metric-card metric-danger">
            <div class="metric-top">
              <span class="metric-label">{{ __('dashboard.index.tickets') }}</span>
              <span class="metric-icon"><i class="bi bi-life-preserver" aria-hidden="true"></i></span>
            </div>
            <div class="metric-value">36</div>
            <div class="metric-meta">
              <span class="text-danger">3 {{ __('dashboard.index.urgent') }}</span>
              <span>{{ __('dashboard.index.need_review') }}</span>
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
              <a class="btn btn-light btn-sm" href="charts.blade.php">{{ __('dashboard.index.view_details') }}</a>
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
              <div class="activity-item"><span class="activity-dot bg-primary"></span><div><p class="mb-1 fw-semibold">{{ __('dashboard.index.new_campaign') }}</p><p class="text-muted small mb-0">{{ __('dashboard.index.campaign_desc') }}</p></div></div>
              <div class="activity-item"><span class="activity-dot bg-success"></span><div><p class="mb-1 fw-semibold">{{ __('dashboard.index.payment_cleared') }}</p><p class="text-muted small mb-0">{{ __('dashboard.index.payment_desc') }}</p></div></div>
              <div class="activity-item"><span class="activity-dot bg-warning"></span><div><p class="mb-1 fw-semibold">{{ __('dashboard.index.support_queue') }}</p><p class="text-muted small mb-0">{{ __('dashboard.index.support_desc') }}</p></div></div>
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
          <a class="btn btn-outline-secondary btn-sm" href="users.html">{{ __('dashboard.index.manage_users') }}</a>
        </div>
        <div class="table-responsive">
          <table class="table align-middle mb-0">
            <thead><tr><th scope="col">{{ __('dashboard.index.table_user') }}</th><th scope="col">{{ __('dashboard.index.table_role') }}</th><th scope="col">{{ __('dashboard.index.table_team') }}</th><th scope="col">{{ __('dashboard.index.table_status') }}</th><th scope="col">{{ __('dashboard.index.table_joined') }}</th><th scope="col" class="text-end">{{ __('dashboard.common.action') }}</th></tr></thead>
            <tbody>
              <tr>
                <td>
                  <div class="d-flex align-items-center gap-2">
                    <img class="avatar-img avatar-sm" src="../dashboard/assets/images/avatar/avatar-1.jpg" alt="Sarah Ahmed">
                    <div>
                      <p class="fw-semibold mb-0">Sarah Ahmed</p>
                      <p class="text-muted small mb-0">sarah@example.com</p>
                    </div>
                  </div>
                </td>
                <td>Admin</td>
                <td>Operations</td>
                <td><span class="badge text-bg-success">{{ __('dashboard.statuses.active') }}</span></td>
                <td>Jan 12, 2026</td>
                <td class="text-end"><a class="btn btn-light btn-sm" href="/user-details.blade.php">{{ __('dashboard.common.view') }}</a></td>
              </tr>
              <tr>
                <td>
                  <div class="d-flex align-items-center gap-2">
                    <img class="avatar-img avatar-sm" src="../dashboard/assets/images/avatar/avatar-2.jpg" alt="Rafi Khan">
                    <div>
                      <p class="fw-semibold mb-0">Rafi Khan</p>
                      <p class="text-muted small mb-0">rafi@example.com</p>
                    </div>
                  </div>
                </td>
                <td>Manager</td>
                <td>Sales</td>
                <td><span class="badge text-bg-success">{{ __('dashboard.statuses.active') }}</span></td>
                <td>Feb 03, 2026</td>
                <td class="text-end"><a class="btn btn-light btn-sm" href="/user-details.blade.php">{{ __('dashboard.common.view') }}</a></td>
              </tr>
              <tr>
                <td>
                  <div class="d-flex align-items-center gap-2">
                    <img class="avatar-img avatar-sm" src="../dashboard/assets/images/avatar/avatar-3.jpg" alt="Nadia Islam">
                    <div>
                      <p class="fw-semibold mb-0">Nadia Islam</p>
                      <p class="text-muted small mb-0">nadia@example.com</p>
                    </div>
                  </div>
                </td>
                <td>Editor</td>
                <td>Content</td>
                <td><span class="badge text-bg-warning">{{ __('dashboard.statuses.pending') }}</span></td>
                <td>Mar 18, 2026</td>
                <td class="text-end"><a class="btn btn-light btn-sm" href="/user-details.blade.php">{{ __('dashboard.common.view') }}</a></td>
              </tr>
              <tr>
                <td>
                  <div class="d-flex align-items-center gap-2">
                    <img class="avatar-img avatar-sm" src="../dashboard/assets/images/avatar/avatar-4.jpg" alt="Mina Torres">
                    <div>
                      <p class="fw-semibold mb-0">Mina Torres</p>
                      <p class="text-muted small mb-0">mina@example.com</p>
                    </div>
                  </div>
                </td>
                <td>Viewer</td>
                <td>Finance</td>
                <td><span class="badge text-bg-secondary">{{ __('dashboard.statuses.suspended') }}</span></td>
                <td>Apr 07, 2026</td>
                <td class="text-end"><a class="btn btn-light btn-sm" href="/user-details.blade.php">{{ __('dashboard.common.view') }}</a></td>
              </tr>
              <tr>
                <td>
                  <div class="d-flex align-items-center gap-2">
                    <img class="avatar-img avatar-sm" src="../dashboard/assets/images/avatar/avatar-5.jpg" alt="Jon Oliver">
                    <div>
                      <p class="fw-semibold mb-0">Jon Oliver</p>
                      <p class="text-muted small mb-0">jon@example.com</p>
                    </div>
                  </div>
                </td>
                <td>Analyst</td>
                <td>Data</td>
                <td><span class="badge text-bg-success">{{ __('dashboard.statuses.active') }}</span></td>
                <td>Apr 22, 2026</td>
                <td class="text-end"><a class="btn btn-light btn-sm" href="/user-details.blade.php">{{ __('dashboard.common.view') }}</a></td>
              </tr>
            </tbody>
          </table>
        </div>
      </section>
    </div>
  </main>

@endsection