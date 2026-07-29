@extends('admin.layouts.app')
@section('title', 'تعديل قسم')
@section('page-title', 'تعديل قسم')

@section('content')
<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.categories.update', $category->id) }}" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">الاسم (عربي) *</label>
                    <input type="text" name="name_ar" class="form-control @error('name_ar') is-invalid @enderror" value="{{ old('name_ar', $category->name_ar) }}" required>
                    @error('name_ar')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">الاسم (English) *</label>
                    <input type="text" name="name_en" class="form-control @error('name_en') is-invalid @enderror" value="{{ old('name_en', $category->name_en) }}" required>
                    @error('name_en')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">الوصف (عربي)</label>
                    <textarea name="description_ar" class="form-control" rows="3">{{ old('description_ar', $category->description_ar) }}</textarea>
                </div>
                <div class="col-md-6">
                    <label class="form-label">الوصف (English)</label>
                    <textarea name="description_en" class="form-control" rows="3">{{ old('description_en', $category->description_en) }}</textarea>
                </div>
                <div class="col-md-6">
                    <label class="form-label">{{ __('messages.image') }}</label>
                    @if($category->image)
                    <img src="{{ asset('storage/' . $category->image) }}" width="100" class="rounded mb-2">
                    @endif
                    <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                    @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 d-flex align-items-end">
                    <div class="form-check">
                        <input type="checkbox" name="is_active" class="form-check-input" id="isActive" {{ $category->is_active ? 'checked' : '' }}>
                        <label class="form-check-label" for="isActive">{{ __('messages.active') }}</label>
                    </div>
                </div>
            </div>
            <div class="mt-4">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> {{ __('messages.save') }}</button>
                <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">{{ __('messages.cancel') }}</a>
            </div>
        </form>
    </div>
</div>
@endsection
