@extends('backend.layouts.app')

@section('title', 'Dashboard')

@section('content')
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2 align-items-center">
        <div class="col-sm-6">
          <h1 class="m-0">Overview</h1>
          <p class="text-muted mb-0 small">Snapshot of orders, revenue, and catalog health.</p>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right bg-transparent mb-0">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active">Dashboard</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-3 col-md-6">
          <div class="small-box bg-info">
            <div class="inner">
              <h3>{{ $pendingOrdersCount ?? 0 }}</h3>
              <p>Pending orders</p>
            </div>
            <div class="icon"><i class="fas fa-shopping-basket"></i></div>
            <a href="{{ route('admin.orders') }}" class="small-box-footer">Manage orders <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <div class="col-lg-3 col-md-6">
          <div class="small-box bg-success">
            <div class="inner">
              <h3>₹{{ number_format((float)($totalRevenue ?? 0), 2) }}</h3>
              <p>Total revenue</p>
            </div>
            <div class="icon"><i class="fas fa-chart-line"></i></div>
            <a href="{{ route('admin.orders') }}" class="small-box-footer">View orders <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <div class="col-lg-3 col-md-6">
          <div class="small-box bg-warning">
            <div class="inner">
              <h3>{{ $totalUsers ?? 0 }}</h3>
              <p>Registered users</p>
            </div>
            <div class="icon"><i class="fas fa-user-plus"></i></div>
            <a href="{{ route('admin.users') }}" class="small-box-footer">Users <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <div class="col-lg-3 col-md-6">
          <div class="small-box bg-danger">
            <div class="inner">
              <h3>{{ $totalProducts ?? 0 }}</h3>
              <p>Products</p>
            </div>
            <div class="icon"><i class="fas fa-box-open"></i></div>
            <a href="{{ route('admin.products') }}" class="small-box-footer">Catalog <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-xl-8">
          <div class="card admin-card-shadow">
            <div class="card-header border-0">
              <h3 class="card-title"><i class="fas fa-chart-area mr-2 text-teal"></i>Weekly activity</h3>
            </div>
            <div class="card-body">
              <canvas id="admin-dashboard-chart" height="280" style="max-height:280px;"></canvas>
            </div>
          </div>
        </div>
        <div class="col-xl-4">
          <div class="card admin-card-shadow">
            <div class="card-header border-0">
              <h3 class="card-title"><i class="fas fa-bolt mr-2 text-teal"></i>Quick actions</h3>
            </div>
            <div class="card-body">
              <div class="d-grid gap-2">
                <a href="{{ route('admin.products.create') }}" class="btn btn-outline-primary btn-sm text-left"><i class="fas fa-plus mr-2"></i>New product</a>
                <a href="{{ route('admin.orders') }}" class="btn btn-outline-secondary btn-sm text-left"><i class="fas fa-list mr-2"></i>Orders</a>
                <a href="{{ route('admin.blog.posts.create') }}" class="btn btn-outline-secondary btn-sm text-left"><i class="fas fa-pen mr-2"></i>New blog post</a>
                <a href="{{ route('admin.contact.inquiries') }}" class="btn btn-outline-secondary btn-sm text-left"><i class="fas fa-envelope mr-2"></i>Inquiries</a>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-12">
          <div class="card admin-card-shadow">
            <div class="card-header border-0">
              <h3 class="card-title"><i class="fas fa-clock mr-2 text-teal"></i>Recent orders</h3>
              <div class="card-tools">
                <a href="{{ route('admin.orders') }}" class="btn btn-sm btn-primary">View all</a>
              </div>
            </div>
            <div class="card-body table-responsive p-0">
              <table class="table table-hover mb-0">
                <thead>
                  <tr>
                    <th>Order</th>
                    <th>Status</th>
                    <th>Payment</th>
                    <th class="text-right">Total</th>
                    <th>Date</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse(($recentOrders ?? collect()) as $o)
                    <tr>
                      <td class="font-weight-bold">{{ $o->order_number ?? ('#'.$o->id) }}</td>
                      <td><span class="badge badge-light border">{{ $o->status }}</span></td>
                      <td><span class="badge badge-secondary">{{ $o->payment_status }}</span></td>
                      <td class="text-right">₹{{ number_format((float)$o->total, 2) }}</td>
                      <td class="text-muted small">{{ optional($o->created_at)->format('d M Y') }}</td>
                    </tr>
                  @empty
                    <tr><td colspan="5" class="text-center text-muted py-4">No recent orders.</td></tr>
                  @endforelse
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection

@push('scripts')
<script>
  $(function () {
    var canvas = document.getElementById('admin-dashboard-chart');
    if (!canvas || typeof Chart === 'undefined') return;
    var ctx = canvas.getContext('2d');
    new Chart(ctx, {
      type: 'line',
      data: {
        labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
        datasets: [{
          label: 'Placeholder trend',
          borderColor: '#14b8a6',
          backgroundColor: 'rgba(20, 184, 166, 0.12)',
          data: [12, 19, 14, 22, 18, 24, 20],
          fill: true,
          lineTension: 0.3,
          pointRadius: 3,
          pointBackgroundColor: '#14b8a6'
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        legend: { display: false },
        scales: {
          yAxes: [{ ticks: { beginAtZero: true } }]
        }
      }
    });
  });
</script>
@endpush
