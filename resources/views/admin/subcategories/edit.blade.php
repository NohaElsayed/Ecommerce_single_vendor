@extends('admin.layouts.master')

@section('title', 'Edit Subcategory')
@section('page_title', 'Edit Subcategory')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card card-table p-4">
            <h5 class="fw-bold mb-4">Edit Subcategory</h5>
            <form action="{{ route('admin.subcategories.update', $subcategory) }}" method="POST">
                @csrf @method('PUT')
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label">Category *</label>
                        <select name="category_id" class="form-select" required>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id', $subcategory->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->translated_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Name (English) *</label>
                        <input type="text" name="name[en]" class="form-control" value="{{ old('name.en', $subcategory->name['en'] ?? '') }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Name (Arabic) *</label>
                        <input type="text" name="name[ar]" class="form-control" value="{{ old('name.ar', $subcategory->name['ar'] ?? '') }}" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Description (English)</label>
                        <textarea name="description[en]" class="form-control" rows="2">{{ old('description.en', $subcategory->description['en'] ?? '') }}</textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Description (Arabic)</label>
                        <textarea name="description[ar]" class="form-control" rows="2">{{ old('description.ar', $subcategory->description['ar'] ?? '') }}</textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Sort Order</label>
                        <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $subcategory->sort_order) }}">
                    </div>
                    <div class="col-12">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active" {{ old('is_active', $subcategory->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">Active</label>
                        </div>
                    </div>
                    <div class="col-12 d-flex gap-2 mt-3">
                        <button type="submit" class="btn btn-primary px-4">Update</button>
                        <a href="{{ route('admin.subcategories.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
