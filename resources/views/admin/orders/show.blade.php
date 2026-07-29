@extends('admin.layouts.master')

@section('title', 'تفاصيل الطلب')
@section('page-title', 'تفاصيل الطلب')

@section('content')
<div class="row g-4">
    <div class="col-lg-8">
        <div class="table-card p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-bold mb-0">الطلب: {{ $order->order_number }}</h5>
                <span class="badge bg-{{ $order->status_badge }} fs-6">{{ $order->status }}</span>
            </div>

            <table class="table table-borderless">
                <tr>
                    <td class="text-muted">العميل:</td>
                    <td class="fw-bold">{{ $order->customer->full_name ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="text-muted">البريد:</td>
                    <td>{{ $order->customer->email ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="text-muted">الهاتف:</td>
                    <td>{{ $order->customer->phone ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="text-muted">عنوان الشحن:</td>
                    <td>{{ $order->shipping_address }}</td>
                </tr>
                <tr>
                    <td class="text-muted">طريقة الدفع:</td>
                    <td>{{ $order->payment_method }}</td>
                </tr>
                <tr>
                    <td class="text-muted">حالة الدفع:</td>
                    <td>
                        <span class="badge bg-{{ $order->payment_status == 'paid' ? 'success' : 'warning' }}">{{ $order->payment_status }}</span>
                    </td>
                </tr>
            </table>

            <hr>

            <h6 class="fw-bold mb-3">المنتجات</h6>
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>المنتج</th>
                        <th>السعر</th>
                        <th>الكمية</th>
                        <th>الإجمالي</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                    <tr>
                        <td>{{ $item->product_name }}</td>
                        <td>{{ number_format($item->price, 2) }} ر.س</td>
                        <td>{{ $item->quantity }}</td>
                        <td class="fw-bold">{{ number_format($item->total, 2) }} ر.س</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="text-start mt-3">
                <h5>الإجمالي: <span class="text-primary">{{ number_format($order->total, 2) }} ر.س</span></h5>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card p-4">
            <h6 class="fw-bold mb-3">تحديث الحالة</h6>
            <form action="{{ route('admin.orders.status', $order->id) }}" method="POST" class="mb-3">
                @csrf
                @method('PUT')
                <select name="status" class="form-select mb-2" onchange="this.form.submit()">
                    <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>معلق</option>
                    <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>قيد المعالجة</option>
                    <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>تم الشحن</option>
                    <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>تم التوصيل</option>
                    <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>ملغي</option>
                </select>
            </form>

            <h6 class="fw-bold mb-3">حالة الدفع</h6>
            <form action="{{ route('admin.orders.payment', $order->id) }}" method="POST">
                @csrf
                @method('PUT')
                <select name="payment_status" class="form-select mb-2" onchange="this.form.submit()">
                    <option value="pending" {{ $order->payment_status == 'pending' ? 'selected' : '' }}>معلق</option>
                    <option value="paid" {{ $order->payment_status == 'paid' ? 'selected' : '' }}>مدفوع</option>
                    <option value="failed" {{ $order->payment_status == 'failed' ? 'selected' : '' }}>فاشل</option>
                    <option value="refunded" {{ $order->payment_status == 'refunded' ? 'selected' : '' }}>مسترجع</option>
                </select>
            </form>
        </div>
    </div>
</div>
@endsection
