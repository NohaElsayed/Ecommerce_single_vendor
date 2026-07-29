@extends('frontend.layouts.master')

@section('title', $product->name)

@section('content')
<div class="container py-5">
    <div class="row g-5">
        <!-- Product Image -->
        <div class="col-lg-6">
            <div class="card p-3">
                <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=600&h=600&fit=crop' }}"
                     class="img-fluid rounded-3" alt="{{ $product->name }}" style="width:100%; max-height:500px; object-fit:cover;">
            </div>
        </div>

        <!-- Product Info -->
        <div class="col-lg-6">
            <small class="text-muted">{{ $product->category->name }} / {{ $product->subCategory->name ?? '' }}</small>
            <h1 class="fw-bold mb-3">{{ $product->name }}</h1>
            <p class="text-muted">{{ $product->description }}</p>

            <div class="d-flex align-items-center gap-3 mb-4">
                @if($product->sale_price)
                    <span class="price-old" style="font-size:1.5rem;">{{ number_format($product->price, 2) }} ر.س</span>
                    <span class="price" style="font-size:2rem;">{{ number_format($product->sale_price, 2) }} ر.س</span>
                @else
                    <span class="price" style="font-size:2rem;">{{ number_format($product->price, 2) }} ر.س</span>
                @endif
            </div>

            <div class="mb-4">
                <span class="badge bg-{{ $product->quantity > 0 ? 'success' : 'danger' }}">
                    {{ $product->quantity > 0 ? 'متوفر - ' . $product->quantity . ' قطعة' : 'غير متوفر' }}
                </span>
            </div>

            <form action="{{ route('cart.add') }}" method="POST" class="d-flex gap-3 align-items-center mb-4">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <div class="input-group" style="width:130px;">
                    <input type="number" name="quantity" value="1" min="1" max="{{ $product->quantity }}" class="form-control text-center">
                </div>
                <button type="submit" class="btn btn-primary btn-lg" {{ $product->quantity <= 0 ? 'disabled' : '' }}>
                    <i class="fas fa-shopping-cart me-2"></i>أضف للسلة
                </button>
            </form>

            <div class="card p-3 bg-light border-0">
                <h6>SKU: <span class="text-muted">{{ $product->sku }}</span></h6>
                <h6>الوزن: <span class="text-muted">{{ $product->weight ?? '-' }} كجم</span></h6>
            </div>
        </div>
    </div>

    <!-- Related Products -->
    @if($relatedProducts->count() > 0)
    <div class="mt-5">
        <h3 class="fw-bold mb-4">منتجات مشابهة</h3>
        <div class="row g-4">
            @foreach($relatedProducts as $p)
            <div class="col-6 col-md-3">
                <div class="card product-card h-100">
                    <div class="card-img-wrapper" style="padding-top:80%;">
                        <img src="{{ $p->image ? asset('storage/' . $p->image) : 'https://via.placeholder.com/300' }}" class="card-img-top" alt="{{ $p->name }}">
                    </div>
                    <div class="card-body p-3">
                        <h6 class="fw-bold">{{ \Illuminate\Support\Str::limit($p->name, 30) }}</h6>
                        <span class="price">{{ number_format($p->final_price, 2) }} ر.س</span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection
