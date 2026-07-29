@extends('admin.layouts.master')

@section('title', 'تقرير المبيعات')
@section('page-title', 'تقرير المبيعات')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div class="btn-group">
        <a href="{{ route('admin.reports.sales', ['period' => 'daily']) }}" class="btn btn-outline-primary {{ $period == 'daily' ? 'active' : '' }}">يومي</a>
        <a href="{{ route('admin.reports.sales', ['period' => 'weekly']) }}" class="btn btn-outline-primary {{ $period == 'weekly' ? 'active' : '' }}">أسبوعي</a>
        <a href="{{ route('admin.reports.sales', ['period' => 'monthly']) }}" class="btn btn-outline-primary {{ $period == 'monthly' ? 'active' : '' }}">شهري</a>
        <a href="{{ route('admin.reports.sales', ['period' => 'yearly']) }}" class="btn btn-outline-primary {{ $period == 'yearly' ? 'active' : '' }}">سنوي</a>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-6">
        <div class="card stat-card border-start border-4 border-primary">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-xs text-uppercase text-primary mb-1">إجمالي الإيرادات</div>
                    <div class="h3 mb-0 font-weight-bold">{{ number_format($report['revenue']->sum(), 2) }} ر.س</div>
                </div>
                <div class="stat-icon bg-gradient-primary text-white">
                    <i class="bi bi-currency-dollar"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card stat-card border-start border-4 border-success">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-xs text-uppercase text-success mb-1">إجمالي الطلبات</div>
                    <div class="h3 mb-0 font-weight-bold">{{ number_format($report['orders']->sum()) }}</div>
                </div>
                <div class="stat-icon bg-gradient-success text-white">
                    <i class="bi bi-cart-check"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="table-card">
    <div class="card-header">
        <i class="bi bi-graph-up"></i> بيانات المبيعات
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead class="table-light">
                    <tr>
                        <th>الفترة</th>
                        <th>عدد الطلبات</th>
                        <th>الإيرادات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($report['labels'] as $index => $label)
                    <tr>
                        <td>{{ $label }}</td>
                        <td>{{ $report['orders'][$index] ?? 0 }}</td>
                        <td class="fw-bold text-primary">{{ number_format($report['revenue'][$index] ?? 0, 2) }} ر.س</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-center text-muted py-4">لا توجد بيانات</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
