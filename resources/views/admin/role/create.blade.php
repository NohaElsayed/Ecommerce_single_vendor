@extends('admin.layouts.app')
@section('title', 'إضافة دور')
@section('page-title', 'إضافة دور جديد')

@section('content')
<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.roles.store') }}">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">اسم الدور *</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-12">
                    <label class="form-label">الصلاحيات *</label>
                    <div class="row g-2">
                        @foreach($permissions as $permission)
                        <div class="col-md-3">
                            <div class="form-check">
                                <input type="checkbox" name="permissions[]" class="form-check-input" value="{{ $permission->name }}" id="perm{{ $permission->id }}" {{ in_array($permission->name, old('permissions', [])) ? 'checked' : '' }}>
                                <label class="form-check-label" for="perm{{ $permission->id }}">{{ $permission->name }}</label>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @error('permissions')<div class="text-danger">{{ $message }}</div>@enderror
                </div>
            </div>
            <div class="mt-4">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> {{ __('messages.save') }}</button>
                <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary">{{ __('messages.cancel') }}</a>
            </div>
        </form>
    </div>
</div>
@endsection
