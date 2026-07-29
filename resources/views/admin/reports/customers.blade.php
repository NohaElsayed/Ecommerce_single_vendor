@extends('admin.layouts.master')

@section('title', 'أفضل العملاء')
@section('page-title', 'أفضل العملاء')

@section('content')
<div class="row g-4 mb-4">
    <div class="col-md-6">
        <div class="card stat-card border-start border-4 border-info">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-xs text-uppercase text-info mb-1">إجمالي العملاء النشطين</div>
                    <div class="h3 mb-0 font-weight-bold">{{ number_format($customers->count()) }}</div>
                </div>
                <div class="stat-icon bg-gradient-info text-white">
                    <i class="bi bi-people"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card stat-card border-start border-4 border-warning">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-xs text-uppercase text-warning mb-1">إجمالي مشترياتهم</div>
                    <div class="h3 mb-0 font-weight-bold">{{ number_format($customers->sum('orders_sum_total'), 2) }} ر.س</div>
                </div>
                <div class="stat-icon bg-gradient-warning text-white">
                    <i class="bi bi-currency-dollar"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="table-card">
    <div class="card-header">
        <i class="bi bi-people-fill"></i> أفضل 10 عملاء
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>العميل</th>
                        <th>عدد الطلبات</th>
                        <th>إجمالي المشتريات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($customers as $index => $customer)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width:35px;height:35px;">
                                    {{ substr($customer->first_name, 0, 1) }}
                                </div>
                                <div>
                                    <div class="fw-bold">{{ $customer->full_name }}</div>
                                    <small class="text-muted">{{ $customer->email }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge bg-info">{{ $customer->orders_count }}</span>
                        </td>
                        <td class="fw-bold text-success">{{ number_format($customer->orders_sum_total ?? 0, 2) }} ر.س</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted py-4">لا توجد بيانات</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
