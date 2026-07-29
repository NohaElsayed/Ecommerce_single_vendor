@extends('frontend.layouts.master')

@section('title', 'طلباتي')

@section('content')
<div class="container py-5">
    <h2 class="fw-bold mb-4"><i class="fas fa-box text-primary me-2"></i>طلباتي</h2>

    @if($orders->isEmpty())
    <div class="text-center py-5">
        <i class="fas fa-box-open fa-4x text-muted mb-3"></i>
        <h4 class="text-muted">لا توجد طلبات</h4>
        <a href="{{ route('home') }}" class="btn btn-primary mt-3">تسوق الآن</a>
    </div>
    @else
    <div class="row g-3">
        @foreach($orders as $order)
        <div class="col-12">
            <div class="card p-4">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div>
                        <h5 class="fw-bold mb-1">{{ $order->order_number }}</h5>
                        <small class="text-muted">{{ $order->created_at->format('Y-m-d') }}</small>
                    </div>
                    <div>
                        <span class="badge bg-{{ $order->status_badge }}">{{ $order->status }}</span>
                        <span class="badge bg-{{ $order->payment_status == 'paid' ? 'success' : 'warning' }}">{{ $order->payment_status }}</span>
                    </div>
                    <div class="h5 text-primary mb-0">{{ number_format($order->total, 2) }} ر.س</div>
                    <a href="{{ route('orders.show', $order->id) }}" class="btn btn-sm btn-outline-primary">التفاصيل</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>
@endsection
