@extends('admin.layouts.master')

@section('title', 'المنتجات الأكثر مبيعاً')
@section('page-title', 'المنتجات الأكثر مبيعاً')

@section('content')
<div class="row g-4 mb-4">
    <div class="col-md-6">
        <div class="card stat-card border-start border-4 border-primary">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-xs text-uppercase text-primary mb-1">إجمالي المنتجات المباعة</div>
                    <div class="h3 mb-0 font-weight-bold">{{ number_format($products->sum('total_sold')) }}</div>
                </div>
                <div class="stat-icon bg-gradient-primary text-white">
                    <i class="bi bi-box-seam"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card stat-card border-start border-4 border-success">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-xs text-uppercase text-success mb-1">إجمالي الإيرادات</div>
                    <div class="h3 mb-0 font-weight-bold">{{ number_format($products->sum('revenue'), 2) }} ر.س</div>
                </div>
                <div class="stat-icon bg-gradient-success text-white">
                    <i class="bi bi-currency-dollar"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="table-card">
    <div class="card-header">
        <i class="bi bi-box"></i> أفضل 10 منتجات مبيعاً
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>اسم المنتج</th>
                        <th>الكمية المباعة</th>
                        <th>الإيرادات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $index => $product)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td class="fw-bold">{{ $product->product_name }}</td>
                        <td>
                            <span class="badge bg-primary">{{ $product->total_sold }}</span>
                        </td>
                        <td class="fw-bold text-success">{{ number_format($product->revenue, 2) }} ر.س</td>
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
