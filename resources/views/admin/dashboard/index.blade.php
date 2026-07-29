{{-- resources/views/admin/dashboard/index.blade.php --}}
@extends('admin.layouts.master')

@section('title', 'لوحة التحكم')
@section('page-title', 'لوحة التحكم')

@section('content')
<div class="row g-4 mb-4">
    <!-- Total Orders -->
    <div class="col-xl-3 col-md-6">
        <div class="card stat-card border-start border-4 border-primary">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-xs text-uppercase text-primary mb-1">إجمالي الطلبات</div>
                    <div class="h3 mb-0 font-weight-bold">{{ number_format($stats['total_orders']) }}</div>
                </div>
                <div class="stat-icon bg-gradient-primary text-white">
                    <i class="bi bi-cart3"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Revenue -->
    <div class="col-xl-3 col-md-6">
        <div class="card stat-card border-start border-4 border-success">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-xs text-uppercase text-success mb-1">إجمالي الإيرادات</div>
                    <div class="h3 mb-0 font-weight-bold">{{ number_format($stats['total_revenue'], 2) }} ر.س</div>
                </div>
                <div class="stat-icon bg-gradient-success text-white">
                    <i class="bi bi-currency-dollar"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Customers -->
    <div class="col-xl-3 col-md-6">
        <div class="card stat-card border-start border-4 border-info">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-xs text-uppercase text-info mb-1">العملاء</div>
                    <div class="h3 mb-0 font-weight-bold">{{ number_format($stats['total_customers']) }}</div>
                </div>
                <div class="stat-icon bg-gradient-info text-white">
                    <i class="bi bi-people"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Products -->
    <div class="col-xl-3 col-md-6">
        <div class="card stat-card border-start border-4 border-warning">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-xs text-uppercase text-warning mb-1">المنتجات</div>
                    <div class="h3 mb-0 font-weight-bold">{{ number_format($stats['total_products']) }}</div>
                </div>
                <div class="stat-icon bg-gradient-warning text-white">
                    <i class="bi bi-box-seam"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Sales Chart -->
    <div class="col-xl-8">
        <div class="table-card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-graph-up"></i> إحصائيات المبيعات (آخر 7 أيام)</span>
            </div>
            <div class="card-body">
                <div class="chart-container">
                    <canvas id="salesChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Orders -->
    <div class="col-xl-4">
        <div class="table-card">
            <div class="card-header">
                <i class="bi bi-clock-history"></i> أحدث الطلبات
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    @forelse($stats['recent_orders'] as $order)
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <div class="fw-bold">{{ $order->order_number }}</div>
                            <small class="text-muted">{{ $order->customer->full_name ?? 'غير معروف' }}</small>
                        </div>
                        <span class="badge bg-{{ $order->status_badge }}">{{ __($order->status) }}</span>
                    </div>
                    @empty
                    <div class="list-group-item text-center text-muted">لا توجد طلبات</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mt-2">
    <!-- Low Stock Alert -->
    <div class="col-12">
        <div class="table-card">
            <div class="card-header text-danger">
                <i class="bi bi-exclamation-triangle"></i> تنبيه: منتجات على وشك النفاد
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>المنتج</th>
                            <th>SKU</th>
                            <th>الكمية المتبقية</th>
                            <th>السعر</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($stats['low_stock_products'] as $product)
                        <tr>
                            <td>{{ $product->name }}</td>
                            <td><code>{{ $product->sku }}</code></td>
                            <td><span class="badge bg-danger">{{ $product->quantity }}</span></td>
                            <td>{{ number_format($product->price, 2) }} ر.س</td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="text-center text-muted">لا توجد منتجات منخفضة</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
const ctx = document.getElementById('salesChart').getContext('2d');
new Chart(ctx, {
    type: 'line',
    data: {
        labels: {!! json_encode($chartData['labels']) !!},
        datasets: [{
            label: 'الطلبات',
            data: {!! json_encode($chartData['orders']) !!},
            borderColor: '#4e73df',
            backgroundColor: 'rgba(78, 115, 223, 0.1)',
            tension: 0.4,
            fill: true
        }, {
            label: 'الإيرادات',
            data: {!! json_encode($chartData['revenue']) !!},
            borderColor: '#1cc88a',
            backgroundColor: 'rgba(28, 200, 138, 0.1)',
            tension: 0.4,
            fill: true,
            yAxisID: 'y1'
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        interaction: { mode: 'index', intersect: false },
        scales: {
            y: { beginAtZero: true, position: 'right' },
            y1: { beginAtZero: true, position: 'left', grid: { drawOnChartArea: false } }
        }
    }
});
</script>
@endpush
