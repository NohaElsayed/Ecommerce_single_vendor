@extends('admin.layouts.master')

@section('title', 'Products')
@section('page_title', 'Products')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Products</h4>
        <small class="text-muted">Manage your product catalog</small>
    </div>
    <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>Add Product
    </a>
</div>

<div class="card card-table">
    <div class="card-body">
        <form action="{{ route('admin.products.index') }}" method="GET" class="row g-2 mb-4">
            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0"><i class="fas fa-search text-muted"></i></span>
                    <input type="text" name="search" class="form-control border-start-0" placeholder="Search products..." value="{{ $filters['search'] ?? '' }}">
                </div>
            </div>
            <div class="col-md-3">
                <select name="category" class="form-select">
                    <option value="">All Categories</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ ($filters['category'] ?? '') == $cat->id ? 'selected' : '' }}>{{ $cat->translated_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select name="status" class="form-select">
                    <option value="">All Status</option>
                    <option value="1" {{ ($filters['status'] ?? '') === '1' ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ ($filters['status'] ?? '') === '0' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
            <div class="col-md-3">
                <button class="btn btn-primary me-2" type="submit">Filter</button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">Reset</a>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <img src="{{ $product->featured_image ? asset('storage/' . $product->featured_image) : 'https://via.placeholder.com/50' }}" class="rounded-3" width="50" height="50" style="object-fit:cover;">
                                    <div>
                                        <h6 class="mb-0 fw-semibold">{{ $product->translated_name }}</h6>
                                        <small class="text-muted">{{ $product->sku }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $product->category->translated_name ?? '-' }}</td>
                            <td>
                                @if($product->sale_price)
                                    <span class="text-decoration-line-through text-muted small">${{ number_format($product->price, 2) }}</span><br>
                                    <span class="fw-bold text-primary">${{ number_format($product->sale_price, 2) }}</span>
                                @else
                                    <span class="fw-bold">${{ number_format($product->price, 2) }}</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge {{ $product->quantity <= 5 ? 'bg-danger' : 'bg-success' }} bg-opacity-10 {{ $product->quantity <= 5 ? 'text-danger' : 'text-success' }}">
                                    {{ $product->quantity }}
                                </span>
                            </td>
                            <td>
                                <span class="badge badge-soft {{ $product->is_active ? 'bg-success-subtle text-success' : 'bg-secondary-subtle text-secondary' }}">
                                    {{ $product->is_active ? 'Active' : 'Inactive' }}
                                </span>
                                @if($product->is_featured)
                                    <span class="badge badge-soft bg-warning-subtle text-warning ms-1"><i class="fas fa-star"></i></span>
                                @endif
                            </td>
                            <td class="text-end">
                                <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm btn-outline-primary btn-icon me-1"> <i class="bi bi-pencil"></i></a>
                                <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this product?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger btn-icon"><i class="bi bi-trash"></i></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center py-5 text-muted">No products found</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer bg-white d-flex justify-content-between align-items-center py-3">
        <small class="text-muted">Showing {{ $products->firstItem() ?? 0 }} to {{ $products->lastItem() ?? 0 }} of {{ $products->total() }}</small>
        {{ $products->withQueryString()->links() }}
    </div>
</div>
@endsection
