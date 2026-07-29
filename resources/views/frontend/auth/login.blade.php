@extends('frontend.layouts.master')

@section('title', 'تسجيل الدخول')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card p-5">
                <div class="text-center mb-4">
                    <i class="fas fa-user-circle fa-3x text-primary mb-2"></i>
                    <h3 class="fw-bold">تسجيل الدخول</h3>
                    <p class="text-muted">أهلاً بك مجدداً</p>
                </div>
                <form method="POST" action="{{ route('customer.login') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">البريد الإلكتروني</label>
                        <input type="email" name="email" class="form-control" required autofocus>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">كلمة المرور</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" name="remember" class="form-check-input" id="remember">
                        <label class="form-check-label" for="remember">تذكرني</label>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">تسجيل الدخول</button>
                </form>
                <div class="text-center mt-3">
                    <span class="text-muted">ليس لديك حساب؟</span>
                    <a href="{{ route('customer.register') }}" class="text-decoration-none fw-bold text-primary">سجل الآن</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
