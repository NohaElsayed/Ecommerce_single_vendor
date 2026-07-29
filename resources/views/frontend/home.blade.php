@extends('frontend.layouts.app')
@section('title', 'الرئيسية')

@section('content')
<div class="hero-section text-center">
    <div class="container">
        <h1 class="display-4 fw-bold mb-4">أفضل المنتجات بأفضل الأسعار</h1>
        <p class="lead mb-4">اكتشف تشكيلتنا الواسعة من المنتجات المميزة</p>
        <a href="{{ route('products.index') }}" class="btn btn-light btn-lg rounded-pill px-5">تسوق الآن</a>
    </div>
</div>

<div class="container my-5">
    <h2 class="text-center mb-5">الأقسام</h2>
    <div class="row g-4">
        @foreach($categories as $category)
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100 text-center p-4">
                @if($category->image)
                    <img src="{{ asset('storage/' . $category->image) }}" class="mx-auto mb-3" style="width:80px;height:80px;object-fit:cover;border-radius:50%;">
                @endif
                <h5>{{ $category->name }}</h5>
                <small class="text-muted">{{ $category->subcategories->count() }} قسم فرعي</small>
            </div>
        </div>
        @endforeach
    </div>
</div>

<div class="container my-5">
    <h2 class="text-center mb-5">منتجات مميزة</h2>
    <div class="row g-4">
        @foreach($featuredProducts as $product)
        <div class="col-md-3">
            <div class="card product-card h-100">
                <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/300' }}" class="product-img">
                <div class="card-body">
                    <h5 class="card-title">{{ $product->name }}</h5>
                    <p class="text-primary fw-bold fs-5">${{ number_format($product->final_price, 2) }}</p>
                    <a href="{{ route('products.show', $product->slug) }}" class="btn btn-primary w-100">عرض التفاصيل</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
