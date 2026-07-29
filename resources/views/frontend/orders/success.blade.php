@extends('frontend.layouts.master')

@section('title', 'تم تأكيد الطلب')

@section('content')
<div class="container py-5 text-center">
    <i class="fas fa-check-circle fa-5x text-success mb-4"></i>
    <h2 class="fw-bold">تم تأكيد طلبك بنجاح!</h2>
    <p class="text-muted">رقم الطلب: <strong>{{ $order->order_number }}</strong></p>
    <p class="text-muted">سنتواصل معك قريباً لتأكيد التوصيل</p>
    <div class="mt-4">
        <a href="{{ route('orders.index') }}" class="btn btn-primary">عرض طلباتي</a>
        <a href="{{ route('home') }}" class="btn btn-outline-primary">العودة للرئيسية</a>
    </div>
</div>
@endsection
