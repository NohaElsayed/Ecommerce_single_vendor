@extends('admin.layouts.app')
@section('title', __('messages.dashboard'))
@section('page-title', __('messages.dashboard'))

@section('content')
<!-- Stats Cards -->
<div class="row g-4 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="card stat-card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-xs text-primary fw-bold text-uppercase">{{ __('messages.total_orders') }}</div>
                        <div class="h3 mb-0">{{ $orderStats['total_orders'] }}</div>
                    </div>
                    <i class="fas fa-shopping-bag stat-icon text-primary"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card stat-card success">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-xs text-success fw-bold text-uppercase">{{ __('messages.total_revenue') }}</div>
                        <div class="h3 mb-0">{{ number_format($orderStats['total_revenue'], 2) }}</div>
                    </div>
                    <i class="fas fa-dollar-sign stat-icon text-success"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card stat-card info">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-xs text-info fw-bold text-uppercase">{{ __('messages.total_customers') }}</div>
                        <div class="h3 mb-0">{{ $customerStats['total_customers'] }}</div>
                    </div>
                    <i class="fas fa-users stat-icon text-info"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card stat-card warning">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-xs text-warning fw-bold text-uppercase">{{ __('messages.today_orders') }}</div>
                        <div class="h3 mb-0">{{ $orderStats['today_orders'] }}</div>
                    </div>
                    <i class="fas fa-calendar stat-icon text-warning"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Recent Orders -->
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h6 class="mb-0">آخر الطلبات</h6>
                <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-primary">عرض الكل</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>رقم الطلب</th>
                                <th>العميل</th>
                                <th>المبلغ</th>
                                <th>الحالة</th>
                                <th>التاريخ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentOrders as $order)
                            <tr>
                                <td>{{ $order->order_number }}</td>
                                <td>{{ $order->customer->name ?? 'N/A' }}</td>
                                <td>{{ number_format($order->total_price, 2) }} ر.س</td>
                                <td>
                                    <span class="badge bg-{{ $order->status === 'delivered' ? 'success' : ($order->status === 'pending' ? 'warning' : 'info') }}">
                                        {{ $order->status_label }}
                                    </span>
                                </td>
                                <td>{{ $order->created_at->format('Y-m-d') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header bg-white">
                <h6 class="mb-0">إحصائيات سريعة</h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <div class="d-flex justify-content-between">
                        <span>إجمالي المنتجات</span>
                        <strong>{{ $totalProducts }}</strong>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="d-flex justify-content-between">
                        <span>إجمالي الأقسام</span>
                        <strong>{{ $totalCategories }}</strong>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="d-flex justify-content-between">
                        <span>طلبات قيد الانتظار</span>
                        <strong class="text-warning">{{ $orderStats['pending_orders'] }}</strong>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="d-flex justify-content-between">
                        <span>طلبات قيد التجهيز</span>
                        <strong class="text-info">{{ $orderStats['processing_orders'] }}</strong>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="d-flex justify-content-between">
                        <span>تم التسليم</span>
                        <strong class="text-success">{{ $orderStats['delivered_orders'] }}</strong>
                    </div>
                </div>
                <div>
                    <div class="d-flex justify-content-between">
                        <span>ملغية</span>
                        <strong class="text-danger">{{ $orderStats['cancelled_orders'] }}</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
