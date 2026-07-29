@extends('admin.layouts.master')

@section('title', 'إضافة منتج')
@section('page-title', 'إضافة منتج جديد')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card card-table p-4">
            <h5 class="fw-bold mb-4"><i class="bi bi-plus-circle me-2"></i>إضافة منتج جديد</h5>
            <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">اسم المنتج *</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">الفئة الرئيسية *</label>
                        <select name="category_id" class="form-select" required>
                            <option value="">اختر الفئة</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">الفئة الفرعية</label>
                        <select name="sub_category_id" class="form-select">
                            <option value="">بدون</option>
                            @foreach($categories as $cat)
                                @foreach($cat->subCategories as $sub)
                                    <option value="{{ $sub->id }}" {{ old('sub_category_id') == $sub->id ? 'selected' : '' }}>
                                        {{ $cat->name }} / {{ $sub->name }}
                                    </option>
                                @endforeach
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">SKU *</label>
                        <input type="text" name="sku" class="form-control" value="{{ old('sku') }}" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">السعر *</label>
                        <input type="number" step="0.01" name="price" class="form-control" value="{{ old('price') }}" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">سعر العرض</label>
                        <input type="number" step="0.01" name="sale_price" class="form-control" value="{{ old('sale_price') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">الكمية *</label>
                        <input type="number" name="quantity" class="form-control" value="{{ old('quantity', 0) }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">الوزن (كجم)</label>
                        <input type="number" step="0.01" name="weight" class="form-control" value="{{ old('weight') }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">صورة المنتج</label>
                        <input type="file" name="image" class="form-control" accept="image/*">
                    </div>

                    <div class="col-12">
                        <label class="form-label">وصف قصير</label>
                        <textarea name="short_description" class="form-control" rows="2">{{ old('short_description') }}</textarea>
                    </div>

                    <div class="col-12">
                        <label class="form-label">الوصف الكامل</label>
                        <textarea name="description" class="form-control" rows="4">{{ old('description') }}</textarea>
                    </div>

                    <div class="col-md-6">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active" checked>
                            <label class="form-check-label" for="is_active">نشط</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_featured" value="1" id="is_featured">
                            <label class="form-check-label" for="is_featured">مميز</label>
                        </div>
                    </div>

                    <div class="col-12 d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-primary px-4"><i class="bi bi-check-lg me-1"></i> حفظ المنتج</button>
                        <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">إلغاء</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
