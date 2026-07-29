@extends('frontend.layouts.master')

@section('title', $category->name)

@section('content')
<div class="container py-5">
    <h2 class="fw-bold mb-4">{{ $category->name }}</h2>
    <p class="text-muted mb-4">{{ $category->description }}</p>

    <div class="row g-4">
        @foreach($products as $product)
        <div class="col-6 col-md-4 col-lg-3">
            <div class="card product-card h-100">
                <div class="card-img-wrapper">
                    <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/300' }}"
                         class="card-img-top" alt="{{ $product->name }}">
                    <form action="{{ route('cart.add') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <button type="submit" class="btn-add-cart"><i class="fas fa-shopping-cart"></i></button>
                    </form>
                </div>
                <div class="card-body p-3">
                    <h6 class="fw-bold">{{ \Illuminate\Support\Str::limit($product->name, 35) }}</h6>
                    <span class="price">{{ number_format($product->final_price, 2) }} ر.س</span>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="mt-4">
        {{ $products->links() }}
    </div>
</div>
@endsection
