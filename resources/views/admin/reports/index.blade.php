@extends('admin.layouts.app')
@section('title', __('messages.reports'))
@section('page-title', __('messages.reports'))

@section('content')
<div class="row g-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">إحصائيات الطلبات</h5>
            </div>
            <div class="card-body">
                <div class="mb-3 d-flex justify-content-between">
                    <span>إجمالي الطلبات</span>
                    <strong>{{ $orderStats['total_orders'] }}</strong>
                </div>
                <div class="mb-3 d-flex justify-content-between">
                    <span>قيد الانتظار</span>
                    <strong class="text-warning">{{ $orderStats['pending_orders'] }}</strong>
                </div>
                <div class="mb-3 d-flex justify-content-between">
                    <span>قيد التجهيز</span>
                    <strong class="text-info">{{ $orderStats['processing_orders'] }}</strong>
                </div>
                <div class="mb-3 d-flex justify-content-between">
                    <span>تم الشحن</span>
                    <strong class="text-primary">{{ $orderStats['shipped_orders'] }}</strong>
                </div>
                <div class="mb-3 d-flex justify-content-between">
                    <span>تم التسليم</span>
                    <strong class="text-success">{{ $orderStats['delivered_orders'] }}</strong>
                </div>
                <div class="mb-3 d-flex justify-content-between">
                    <span>ملغية</span>
                    <strong class="text-danger">{{ $orderStats['cancelled_orders'] }}</strong>
                </div>
                <hr>
                <div class="d-flex justify-content-between">
                    <span><strong>إجمالي الإيرادات</strong></span>
                    <strong class="fs-5 text-success">{{ number_format($orderStats['total_revenue'], 2) }} ر.س</strong>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">إحصائيات العملاء</h5>
            </div>
            <div class="card-body">
                <div class="mb-3 d-flex justify-content-between">
                    <span>إجمالي العملاء</span>
                    <strong>{{ $customerStats['total_customers'] }}</strong>
                </div>
                <div class="mb-3 d-flex justify-content-between">
                    <span>عملاء نشطين</span>
                    <strong class="text-success">{{ $customerStats['active_customers'] }}</strong>
                </div>
                <div class="mb-3 d-flex justify-content-between">
                    <span>عملاء جدد اليوم</span>
                    <strong class="text-info">{{ $customerStats['new_customers_today'] }}</strong>
                </div>
                <div class="d-flex justify-content-between">
                    <span>عملاء جدد هذا الشهر</span>
                    <strong class="text-primary">{{ $customerStats['new_customers_month'] }}</strong>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">تقرير المبيعات</h5>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('admin.reports.sales') }}" class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label class="form-label">{{ __('messages.start_date') }}</label>
                        <input type="date" name="start_date" class="form-control" value="{{ request('start_date', now()->startOfMonth()->format('Y-m-d')) }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">{{ __('messages.end_date') }}</label>
                        <input type="date" name="end_date" class="form-control" value="{{ request('end_date', now()->endOfMonth()->format('Y-m-d')) }}">
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-chart-bar me-1"></i> {{ __('messages.generate_report') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
