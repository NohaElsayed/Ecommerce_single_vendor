{{-- resources/views/admin/users/create.blade.php --}}

@extends('admin.layouts.master')

@section('title', 'إضافة مستخدم')
@section('page-title', 'إضافة مستخدم جديد')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card p-4">
            <h5 class="fw-bold mb-4"><i class="bi bi-person-plus me-2"></i>إضافة مستخدم جديد</h5>

            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">الاسم الكامل *</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">البريد الإلكتروني *</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                        @error('email')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">كلمة المرور *</label>
                        <input type="password" name="password" class="form-control" required>
                        @error('password')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">تأكيد كلمة المرور *</label>
                        <input type="password" name="password_confirmation" class="form-control" required>
                    </div>

                    <div class="col-12">
                        <label class="form-label">الأدوار والصلاحيات *</label>
                        <div class="row g-2">
                            @foreach($roles as $role)
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="roles[]" value="{{ $role->name }}" id="role_{{ $role->id }}" {{ in_array($role->name, old('roles', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="role_{{ $role->id }}">
                                        {{ $role->name }}
                                    </label>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @error('roles')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-12">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active" checked>
                            <label class="form-check-label" for="is_active">حساب نشط</label>
                        </div>
                    </div>

                    <div class="col-12 d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-primary px-4"><i class="bi bi-check-lg me-1"></i> حفظ المستخدم</button>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">إلغاء</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
