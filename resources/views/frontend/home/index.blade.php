@extends('frontend.layouts.master')

@section('title', 'الرئيسية')

@section('content')
<!-- Hero Section -->
<section class="hero">
    <div class="container position-relative" style="z-index: 2;">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <span class="badge bg-white text-primary px-3 py-2 mb-3 rounded-pill">
                    <i class="fas fa-fire me-1"></i> تشكيلة جديدة
                </span>
                <h1>تسوق بذكاء<br>وفر أكثر</h1>
                <p class="lead">أفضل المنتجات بأفضل الأسعار مع توصيل سريع لباب بيتك</p>
                <div class="d-flex gap-3">
                    <a href="#products" class="btn btn-primary btn-lg">
                        تسوق الآن <i class="fas fa-arrow-left ms-2"></i>
                    </a>
                    <a href="#categories" class="btn btn-outline-light btn-lg">
                        استكشف
                    </a>
                </div>
            </div>
            <div class="col-lg-6 text-center d-none d-lg-block">
                <img src="https://images.unsplash.com/photo-1483985988355-763728e1935b?w=600&h=500&fit=crop"
                     alt="Shopping" class="img-fluid rounded-4 shadow-lg" style="max-height: 450px; object-fit: cover;">
            </div>
        </div>
    </div>
</section>

<!-- Categories -->
<section id="categories" class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">تصفح حسب الفئة</h2>
            <p class="text-muted">اختر من مجموعة متنوعة من التصنيفات</p>
        </div>
        <div class="row g-4">
            @foreach($categories as $category)
                <div class="col-6 col-md-4 col-lg-3">
                    <a href="{{ route('category.show', $category->id) }}" class="text-decoration-none category-card">
                        <img src="{{ $category->image ? asset('storage/' . $category->image) : 'https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?w=400&h=300&fit=crop' }}"
                             alt="{{ $category->name }}">
                        <div class="overlay">
                            <h5>{{ $category->name }}</h5>
                            <span>{{ $category->products->count() }} منتج</span>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Featured Products -->
<section id="products" class="py-5 bg-white">
    <div class="container">
        <div class="d-flex justify-content-between align-items-end mb-5">
            <div>
                <h2 class="section-title">منتجات مميزة</h2>
                <p class="text-muted">اخترنا لك أفضل المنتجات</p>
            </div>
            <a href="{{ route('home') }}" class="btn btn-outline-primary">
                عرض الكل <i class="fas fa-arrow-left ms-1"></i>
            </a>
        </div>

        <div class="row g-4">
            @foreach($featured_products as $product)
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="card product-card h-100">
                        <div class="card-img-wrapper">
                            @if($product->sale_price)
                                <span class="badge-sale">خصم</span>
                            @endif
                            <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=400&h=400&fit=crop' }}"
                                 class="card-img-top" alt="{{ $product->name }}">

                            <form action="{{ route('cart.add') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="btn-add-cart">
                                    <i class="fas fa-shopping-cart"></i>
                                </button>
                            </form>
                        </div>
                        <div class="card-body p-3">
                            <small class="text-muted">{{ $product->category->name ?? '' }}</small>
                            <h6 class="card-title mt-1 mb-2 fw-semibold" style="min-height: 40px;">
                                <a href="{{ route('products.show', $product->slug) }}" class="text-dark text-decoration-none">
                                    {{ \Illuminate\Support\Str::limit($product->name, 40) }}
                                </a>
                            </h6>
                            <div class="d-flex align-items-center">
                                @if($product->sale_price)
                                    <span class="price-old">{{ number_format($product->price, 2) }} ر.س</span>
                                    <span class="price">{{ number_format($product->sale_price, 2) }} ر.س</span>
                                @else
                                    <span class="price">{{ number_format($product->price, 2) }} ر.س</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Features -->
<section class="py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-3 col-6 text-center">
                <div class="card p-4 h-100">
                    <i class="fas fa-shipping-fast fa-3x text-primary mb-3"></i>
                    <h6 class="fw-bold">شحن مجاني</h6>
                    <small class="text-muted">للطلبات فوق 500 ر.س</small>
                </div>
            </div>
            <div class="col-md-3 col-6 text-center">
                <div class="card p-4 h-100">
                    <i class="fas fa-undo fa-3x text-success mb-3"></i>
                    <h6 class="fw-bold">إرجاع سهل</h6>
                    <small class="text-muted">خلال 14 يوم</small>
                </div>
            </div>
            <div class="col-md-3 col-6 text-center">
                <div class="card p-4 h-100">
                    <i class="fas fa-lock fa-3x text-warning mb-3"></i>
                    <h6 class="fw-bold">دفع آمن</h6>
                    <small class="text-muted">حماية كاملة</small>
                </div>
            </div>
            <div class="col-md-3 col-6 text-center">
                <div class="card p-4 h-100">
                    <i class="fas fa-headset fa-3x text-danger mb-3"></i>
                    <h6 class="fw-bold">دعم 24/7</h6>
                    <small class="text-muted">فريق متخصص</small>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
