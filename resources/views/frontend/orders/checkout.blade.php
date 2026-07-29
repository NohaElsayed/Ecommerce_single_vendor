@extends('frontend.layouts.master')

@section('title', 'إتمام الشراء')

@section('content')
<div class="container py-5">
    <div class="row g-4">
        <div class="col-lg-7">
            <div class="card p-4">
                <h4 class="fw-bold mb-4"><i class="fas fa-map-marker-alt text-primary me-2"></i>عنوان الشحن</h4>
                <form action="{{ route('orders.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">عنوان الشحن بالتفصيل</label>
                        <textarea name="shipping_address" class="form-control" rows="3" required>{{ auth('customer')->user()->address ?? '' }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">عنوان الفاتورة (اختياري)</label>
                        <textarea name="billing_address" class="form-control" rows="2"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">طريقة الدفع</label>
                        <select name="payment_method" class="form-select" required>
                            <option value="cash">الدفع عند الاستلام</option>
                            <option value="card">بطاقة ائتمانية</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">ملاحظات (اختياري)</label>
                        <textarea name="notes" class="form-control" rows="2"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg w-100">تأكيد الطلب</button>
                </form>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card p-4">
                <h5 class="fw-bold mb-3">المنتجات</h5>
                @foreach($cart as $item)
                <div class="d-flex justify-content-between mb-2">
                    <span>{{ $item->product->name }} x{{ $item->quantity }}</span>
                    <span>{{ number_format($item->quantity * $item->product->final_price, 2) }} ر.س</span>
                </div>
                @endforeach
                <hr>
                <div class="d-flex justify-content-between fw-bold h5">
                    <span>الإجمالي</span>
                    <span class="text-primary">{{ number_format($total, 2) }} ر.س</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
