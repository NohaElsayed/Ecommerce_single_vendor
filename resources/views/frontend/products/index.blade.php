@extends('frontend.layouts.master')

@section('title', 'جميع المنتجات')

@push('styles')
<style>
    .filter-sidebar {
        background: white;
        border-radius: 16px;
        padding: 1.5rem;
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        position: sticky;
        top: 100px;
    }
    .filter-title {
        font-weight: 700;
        font-size: 1.1rem;
        margin-bottom: 1rem;
        padding-bottom: 0.75rem;
        border-bottom: 2px solid #f1f5f9;
    }
    .filter-group {
        margin-bottom: 1.5rem;
    }
    .filter-group label {
        font-weight: 600;
        color: #475569;
        margin-bottom: 0.5rem;
        display: block;
        font-size: 0.9rem;
    }
    .price-range {
        display: flex;
        gap: 0.5rem;
        align-items: center;
    }
    .price-range input {
        width: 100%;
    }
    .category-filter-item {
        display: flex;
        align-items: center;
        padding: 0.4rem 0;
        color: #64748b;
        text-decoration: none;
        transition: all 0.2s;
        font-size: 0.9rem;
    }
    .category-filter-item:hover,
    .category-filter-item.active {
        color: #6366f1;
        padding-right: 0.5rem;
    }
    .category-filter-item.active {
        font-weight: 700;
    }
    .category-filter-item span {
        margin-right: auto;
        background: #f1f5f9;
        padding: 0.15rem 0.5rem;
        border-radius: 20px;
        font-size: 0.75rem;
    }
    .sort-select {
        border: 2px solid #e2e8f0;
        border-radius: 10px;
        padding: 0.6rem 1rem;
        font-weight: 600;
        color: #475569;
        background: white;
    }
    .results-count {
        color: #64748b;
        font-size: 0.9rem;
    }
    .clear-filters {
        color: #ef4444;
        font-size: 0.85rem;
        font-weight: 600;
        text-decoration: none;
    }
    .clear-filters:hover {
        text-decoration: underline;
    }
    .product-count-badge {
        background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
        color: white;
        padding: 0.35rem 0.75rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 700;
    }
</style>
@endpush

@section('content')
<div class="container py-5">
    <div class="row g-4">
        <!-- Sidebar Filters -->
        <div class="col-lg-3">
            <div class="filter-sidebar">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="filter-title mb-0"><i class="fas fa-filter text-primary me-2"></i>الفلاتر</h5>
                    <a href="{{ route('products.index') }}" class="clear-filters"><i class="fas fa-times-circle me-1"></i>مسح</a>
                </div>

                <form action="{{ route('products.index') }}" method="GET" id="filterForm">
                    <!-- حفظ قيمة البحث لو موجودة -->
                    @if(request('search'))
                        <input type="hidden" name="search" value="{{ request('search') }}">
                    @endif

                    <!-- Search -->
                    <div class="filter-group">
                        <label><i class="fas fa-search me-1"></i> بحث</label>
                        <input type="text" name="search" class="form-control" placeholder="ابحث عن منتج..."
                               value="{{ request('search') }}">
                    </div>

                    <!-- Categories -->
                    <div class="filter-group">
                        <label><i class="fas fa-list me-1"></i> الفئات</label>
                        @foreach($categories as $cat)
                            <a href="{{ route('products.index', array_merge(request()->except('page'), ['category' => $cat->id])) }}"
                               class="category-filter-item {{ request('category') == $cat->id ? 'active' : '' }}">
                                <i class="fas {{ request('category') == $cat->id ? 'fa-check-circle' : 'fa-circle' }} me-2" style="font-size:0.7rem;"></i>
                                {{ $cat->name }}
                                <span>{{ $cat->products_count ?? $cat->products->count() }}</span>
                            </a>
                        @endforeach
                    </div>

                    <!-- Subcategories (if category selected) -->
                    @if(request('category'))
                        @php $selectedCat = $categories->firstWhere('id', request('category')); @endphp
                        @if($selectedCat && $selectedCat->subCategories->count() > 0)
                        <div class="filter-group">
                            <label><i class="fas fa-sitemap me-1"></i> الفئات الفرعية</label>
                            @foreach($selectedCat->subCategories as $sub)
                                <a href="{{ route('products.index', array_merge(request()->except('page'), ['subcategory' => $sub->id])) }}"
                                   class="category-filter-item {{ request('subcategory') == $sub->id ? 'active' : '' }}" style="padding-right:1.5rem;">
                                    <i class="fas {{ request('subcategory') == $sub->id ? 'fa-check' : 'fa-angle-left' }} me-2" style="font-size:0.7rem;"></i>
                                    {{ $sub->name }}
                                </a>
                            @endforeach
                        </div>
                        @endif
                    @endif

                    <!-- Price Range -->
                    <div class="filter-group">
                        <label><i class="fas fa-tag me-1"></i> نطاق السعر</label>
                        <div class="price-range mb-2">
                            <input type="number" name="min_price" class="form-control" placeholder="من"
                                   value="{{ request('min_price') }}">
                            <span class="text-muted">-</span>
                            <input type="number" name="max_price" class="form-control" placeholder="إلى"
                                   value="{{ request('max_price') }}">
                        </div>
                    </div>

                    <!-- On Sale -->
                    <div class="filter-group">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="on_sale" value="1" id="onSale"
                                   {{ request('on_sale') ? 'checked' : '' }} onchange="document.getElementById('filterForm').submit()">
                            <label class="form-check-label fw-bold text-danger" for="onSale">
                                <i class="fas fa-percent me-1"></i> عروض وخصومات فقط
                            </label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-filter me-2"></i> تطبيق الفلاتر
                    </button>
                </form>
            </div>
        </div>

        <!-- Products Grid -->
        <div class="col-lg-9">
            <!-- Header -->
            <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
                <div>
                    <h2 class="fw-bold mb-1">جميع المنتجات</h2>
                    <div class="results-count">
                        @if(request()->hasAny(['search','category','subcategory','min_price','max_price','on_sale']))
                            <span class="product-count-badge">{{ $products->total() }}</span> نتيجة للفلاتر المُطبقة
                        @else
                            <span class="product-count-badge">{{ $products->total() }}</span> منتج متوفر
                        @endif
                    </div>
                </div>

                <div class="d-flex align-items-center gap-2">
                    <label class="text-muted mb-0">الترتيب:</label>
                    <form action="{{ route('products.index') }}" method="GET" id="sortForm">
                        @foreach(request()->except(['sort','page']) as $key => $value)
                            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                        @endforeach
                        <select name="sort" class="sort-select form-select" onchange="document.getElementById('sortForm').submit()">
                            <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>الأحدث</option>
                            <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>السعر: من الأقل للأعلى</option>
                            <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>السعر: من الأعلى للأقل</option>
                            <option value="name_az" {{ request('sort') == 'name_az' ? 'selected' : '' }}>الاسم: أ-ي</option>
                            <option value="name_za" {{ request('sort') == 'name_za' ? 'selected' : '' }}>الاسم: ي-أ</option>
                        </select>
                    </form>
                </div>
            </div>

            <!-- Active Filters Tags -->
            @if(request()->hasAny(['search','category','subcategory','min_price','max_price','on_sale']))
            <div class="mb-4 d-flex flex-wrap gap-2">
                @if(request('search'))
                    <span class="badge bg-light text-dark border px-3 py-2">
                        بحث: {{ request('search') }}
                        <a href="{{ route('products.index', request()->except(['search','page'])) }}" class="text-danger ms-2"><i class="fas fa-times"></i></a>
                    </span>
                @endif
                @if(request('category'))
                    @php $catName = $categories->firstWhere('id', request('category'))?->name; @endphp
                    <span class="badge bg-light text-dark border px-3 py-2">
                        الفئة: {{ $catName }}
                        <a href="{{ route('products.index', request()->except(['category','subcategory','page'])) }}" class="text-danger ms-2"><i class="fas fa-times"></i></a>
                    </span>
                @endif
                @if(request('min_price') || request('max_price'))
                    <span class="badge bg-light text-dark border px-3 py-2">
                        السعر: {{ request('min_price', 0) }} - {{ request('max_price', '∞') }} ر.س
                        <a href="{{ route('products.index', request()->except(['min_price','max_price','page'])) }}" class="text-danger ms-2"><i class="fas fa-times"></i></a>
                    </span>
                @endif
                @if(request('on_sale'))
                    <span class="badge bg-danger text-white px-3 py-2">
                        <i class="fas fa-percent me-1"></i> عروض فقط
                        <a href="{{ route('products.index', request()->except(['on_sale','page'])) }}" class="text-white ms-2"><i class="fas fa-times"></i></a>
                    </span>
                @endif
            </div>
            @endif

            <!-- Products -->
            @if($products->count() > 0)
            <div class="row g-4">
                @foreach($products as $product)
                <div class="col-6 col-md-4">
                    <div class="card product-card h-100">
                        <div class="card-img-wrapper">
                            @if($product->sale_price && $product->sale_price < $product->price)
                                @php
                                    $discount = round((($product->price - $product->sale_price) / $product->price) * 100);
                                @endphp
                                <span class="badge-sale">-{{ $discount }}%</span>
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
                                @if($product->sale_price && $product->sale_price < $product->price)
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

            <!-- Pagination -->
            <div class="mt-5 d-flex justify-content-center">
                {{ $products->links() }}
            </div>
            @else
            <!-- No Results -->
            <div class="text-center py-5">
                <i class="fas fa-search fa-4x text-muted mb-3"></i>
                <h4 class="text-muted">لا توجد منتجات مطابقة</h4>
                <p class="text-muted">جرب تغيير الفلاتر أو البحث بكلمات مختلفة</p>
                <a href="{{ route('products.index') }}" class="btn btn-primary mt-3">
                    <i class="fas fa-redo me-2"></i> عرض كل المنتجات
                </a>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
