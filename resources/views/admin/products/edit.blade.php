@extends('admin.layouts.master')

@section('title', 'Edit Product')
@section('page_title', 'Edit Product')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card card-table p-4">
            <h5 class="fw-bold mb-4">Edit Product</h5>
            <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Name (English) *</label>
                        <input type="text" name="name[en]" class="form-control" value="{{ old('name.en', $product->name['en'] ?? '') }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Name (Arabic) *</label>
                        <input type="text" name="name[ar]" class="form-control" value="{{ old('name.ar', $product->name['ar'] ?? '') }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Category *</label>
                        <select name="category_id" class="form-select" required>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->translated_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Subcategory</label>
                        <select name="subcategory_id" class="form-select">
                            <option value="">None</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Price *</label>
                        <input type="number" step="0.01" name="price" class="form-control" value="{{ old('price', $product->price) }}" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Sale Price</label>
                        <input type="number" step="0.01" name="sale_price" class="form-control" value="{{ old('sale_price', $product->sale_price) }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Quantity *</label>
                        <input type="number" name="quantity" class="form-control" value="{{ old('quantity', $product->quantity) }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">SKU *</label>
                        <input type="text" name="sku" class="form-control" value="{{ old('sku', $product->sku) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">New Images</label>
                        <input type="file" name="images[]" class="form-control" multiple accept="image/*">
                    </div>

                    @if($product->images && count($product->images) > 0)
                        <div class="col-12">
                            <label class="form-label">Current Images</label>
                            <div class="d-flex gap-2 flex-wrap">
                                @foreach($product->images as $img)
                                    <div class="position-relative">
                                        <img src="{{ asset('storage/' . $img) }}" class="rounded-3" width="100" height="100" style="object-fit:cover;">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <div class="col-12">
                        <label class="form-label">Description (English)</label>
                        <textarea name="description[en]" class="form-control" rows="3">{{ old('description.en', $product->description['en'] ?? '') }}</textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Description (Arabic)</label>
                        <textarea name="description[ar]" class="form-control" rows="3">{{ old('description.ar', $product->description['ar'] ?? '') }}</textarea>
                    </div>

                    <div class="col-md-6">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active" {{ old('is_active', $product->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">Active</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_featured" value="1" id="is_featured" {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_featured">Featured</label>
                        </div>
                    </div>

                    <div class="col-12 d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-primary px-4">Update Product</button>
                        <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
