{{-- resources/views/frontend/auth/profile.blade.php --}}

@extends('frontend.layouts.master')

@section('title', 'الملف الشخصي')

@section('content')
<div class="container py-5">
    <div class="row g-4">
        <!-- Sidebar -->
        <div class="col-lg-3">
            <div class="card p-4 text-center">
                <div class="bg-gradient-primary text-white rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3"
                     style="width:80px;height:80px;font-size:2rem;">
                    {{ substr(auth('customer')->user()->first_name, 0, 1) }}
                </div>
                <h5 class="fw-bold mb-1">{{ auth('customer')->user()->full_name }}</h5>
                <p class="text-muted small">{{ auth('customer')->user()->email }}</p>
                <hr>
                <ul class="list-unstyled text-start mb-0">
                    <li class="mb-2">
                        <a href="{{ route('customer.profile') }}" class="text-decoration-none text-primary fw-bold">
                            <i class="fas fa-user me-2"></i> الملف الشخصي
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('orders.index') }}" class="text-decoration-none text-muted">
                            <i class="fas fa-box me-2"></i> طلباتي
                        </a>
                    </li>
                    <li>
                        <form action="{{ route('customer.logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-link text-decoration-none text-danger p-0">
                                <i class="fas fa-sign-out-alt me-2"></i> تسجيل الخروج
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Profile Form -->
        <div class="col-lg-9">
            <div class="card p-4">
                <h4 class="fw-bold mb-4"><i class="fas fa-user-edit text-primary me-2"></i> تعديل الملف الشخصي</h4>

                <form action="{{ route('customer.profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">الاسم الأول</label>
                            <input type="text" name="first_name" class="form-control"
                                   value="{{ auth('customer')->user()->first_name }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">الاسم الأخير</label>
                            <input type="text" name="last_name" class="form-control"
                                   value="{{ auth('customer')->user()->last_name }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">البريد الإلكتروني</label>
                            <input type="email" class="form-control"
                                   value="{{ auth('customer')->user()->email }}" disabled>
                            <small class="text-muted">لا يمكن تغيير البريد الإلكتروني</small>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">رقم الجوال</label>
                            <input type="text" name="phone" class="form-control"
                                   value="{{ auth('customer')->user()->phone }}">
                        </div>
                        <div class="col-12">
                            <label class="form-label">العنوان</label>
                            <textarea name="address" class="form-control" rows="2">{{ auth('customer')->user()->address }}</textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">المدينة</label>
                            <input type="text" name="city" class="form-control"
                                   value="{{ auth('customer')->user()->city }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">الدولة</label>
                            <input type="text" name="country" class="form-control"
                                   value="{{ auth('customer')->user()->country }}">
                        </div>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary px-5">
                            <i class="fas fa-save me-2"></i> حفظ التغييرات
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
