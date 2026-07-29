@extends('frontend.layouts.master')

@section('title', 'حساب جديد')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card p-5">
                <div class="text-center mb-4">
                    <i class="fas fa-user-plus fa-3x text-primary mb-2"></i>
                    <h3 class="fw-bold">إنشاء حساب</h3>
                    <p class="text-muted">انضم إلينا الآن</p>
                </div>
                <form method="POST" action="{{ route('customer.register.post') }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">الاسم الأول</label>
                            <input type="text" name="first_name" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">الاسم الأخير</label>
                            <input type="text" name="last_name" class="form-control" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">البريد الإلكتروني</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">رقم الجوال</label>
                        <input type="text" name="phone" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">كلمة المرور</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">تأكيد كلمة المرور</label>
                        <input type="password" name="password_confirmation" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">إنشاء الحساب</button>
                </form>
                <div class="text-center mt-3">
                    <span class="text-muted">لديك حساب؟</span>
                    <a href="{{ route('customer.login') }}" class="text-decoration-none fw-bold text-primary">تسجيل الدخول</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
