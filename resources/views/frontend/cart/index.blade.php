@extends('frontend.layouts.master')

@section('title', 'سلة التسوق')

@section('content')
<div class="container py-5">
    <h2 class="fw-bold mb-4"><i class="fas fa-shopping-cart text-primary me-2"></i>سلة التسوق</h2>

    @if($cart->isEmpty())
    <div class="text-center py-5">
        <i class="fas fa-shopping-basket fa-4x text-muted mb-3"></i>
        <h4 class="text-muted">السلة فارغة</h4>
        <a href="{{ route('home') }}" class="btn btn-primary mt-3">تصفح المنتجات</a>
    </div>
    @else
    <div class="row g-4">
        <div class="col-lg-8">
            @foreach($cart as $item)
            <div class="card mb-3 p-3">
                <div class="row align-items-center">
                    <div class="col-md-2">
                        <img src="{{ $item->product->image ? asset('storage/' . $item->product->image) : 'https://via.placeholder.com/100' }}"
                             class="img-fluid rounded" style="width:80px; height:80px; object-fit:cover;">
                    </div>
                    <div class="col-md-4">
                        <h6 class="fw-bold mb-1">{{ $item->product->name }}</h6>
                        <span class="price">{{ number_format($item->product->final_price, 2) }} ر.س</span>
                    </div>
                    <div class="col-md-3">
                        <form action="{{ route('cart.update', $item->id) }}" method="POST" class="d-flex align-items-center gap-2">
                            @csrf
                            @method('PUT')
                            <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" class="form-control text-center" style="width:70px;">
                            <button type="submit" class="btn btn-sm btn-outline-primary"><i class="fas fa-sync"></i></button>
                        </form>
                    </div>
                    <div class="col-md-2 text-start">
                        <span class="fw-bold">{{ number_format($item->quantity * $item->product->final_price, 2) }} ر.س</span>
                    </div>
                    <div class="col-md-1 text-start">
                        <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="col-lg-4">
            <div class="card p-4">
                <h5 class="fw-bold mb-4">ملخص الطلب</h5>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">المجموع</span>
                    <span class="fw-bold">{{ number_format($total, 2) }} ر.س</span>
                </div>
                <hr>
                <div class="d-flex justify-content-between mb-4">
                    <span class="h5">الإجمالي</span>
                    <span class="h5 text-primary">{{ number_format($total, 2) }} ر.س</span>
                </div>
                <a href="{{ route('checkout') }}" class="btn btn-primary w-100 py-2 fw-bold">
                    إتمام الشراء <i class="fas fa-arrow-left me-2"></i>
                </a>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
