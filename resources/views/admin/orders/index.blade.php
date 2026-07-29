@extends('admin.layouts.master')

@section('title', 'الطلبات')
@section('page-title', 'إدارة الطلبات')

@section('content')
<div class="table-card">
    <div class="card-header">
        <i class="bi bi-cart-check"></i> قائمة الطلبات
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>رقم الطلب</th>
                        <th>العميل</th>
                        <th>الإجمالي</th>
                        <th>الحالة</th>
                        <th>الدفع</th>
                        <th>التاريخ</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td><code>{{ $order->order_number }}</code></td>
                        <td>{{ $order->customer->full_name ?? 'غير معروف' }}</td>
                        <td class="fw-bold">{{ number_format($order->total, 2) }} ر.س</td>
                        <td>
                            <span class="badge bg-{{ $order->status_badge }}">{{ $order->status }}</span>
                        </td>
                        <td>
                            <span class="badge bg-{{ $order->payment_status == 'paid' ? 'success' : 'warning' }}">{{ $order->payment_status }}</span>
                        </td>
                        <td>{{ $order->created_at->format('Y-m-d') }}</td>
                        <td>
                            <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-info btn-action">
                                <i class="bi bi-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="mt-3">
    {{ $orders->links() }}
</div>
@endsection
