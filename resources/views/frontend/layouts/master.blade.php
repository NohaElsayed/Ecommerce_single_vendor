<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'متجري')</title>

    <!-- Bootstrap 5 RTL -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #6366f1;
            --primary-dark: #4f46e5;
            --secondary: #ec4899;
            --dark: #1e293b;
            --light: #f8fafc;
            --success: #22c55e;
            --warning: #f59e0b;
            --danger: #ef4444;
            --gradient-1: linear-gradient(135deg, #6366f1 0%, #8b5cf6 50%, #ec4899 100%);
            --gradient-2: linear-gradient(135deg, #1e293b 0%, #334155 100%);
            --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
            --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1);
            --shadow-xl: 0 20px 25px -5px rgb(0 0 0 / 0.1);
            --radius: 16px;
            --radius-sm: 8px;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Cairo', sans-serif;
            background: #f1f5f9;
            color: var(--dark);
            line-height: 1.6;
        }

        .navbar {
            background: rgba(255,255,255,0.85);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(0,0,0,0.05);
            padding: 1rem 0;
            transition: all 0.3s ease;
        }

        .navbar.scrolled {
            box-shadow: var(--shadow-lg);
            padding: 0.5rem 0;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            background: var(--gradient-1);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .nav-link {
            font-weight: 500;
            color: #64748b !important;
            padding: 0.5rem 1rem !important;
            border-radius: var(--radius-sm);
            transition: all 0.3s ease;
            position: relative;
        }

        .nav-link:hover, .nav-link.active {
            color: var(--primary) !important;
            background: rgba(99, 102, 241, 0.08);
        }

        .btn-primary {
            background: var(--gradient-1);
            border: none;
            padding: 0.75rem 2rem;
            border-radius: var(--radius-sm);
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(99, 102, 241, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(99, 102, 241, 0.4);
        }

        .btn-outline-primary {
            border: 2px solid var(--primary);
            color: var(--primary);
            font-weight: 600;
            border-radius: var(--radius-sm);
            transition: all 0.3s ease;
        }

        .btn-outline-primary:hover {
            background: var(--gradient-1);
            border-color: transparent;
            transform: translateY(-2px);
            color: white;
        }

        .card {
            border: none;
            border-radius: var(--radius);
            background: white;
            box-shadow: var(--shadow);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            overflow: hidden;
        }

        .card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-xl);
        }

        .product-card {
            position: relative;
        }

        .product-card .card-img-wrapper {
            position: relative;
            overflow: hidden;
            padding-top: 100%;
            background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
        }

        .product-card .card-img-top {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.6s ease;
        }

        .product-card:hover .card-img-top {
            transform: scale(1.08);
        }

        .product-card .badge-sale {
            position: absolute;
            top: 1rem;
            left: 1rem;
            background: var(--danger);
            color: white;
            padding: 0.35rem 0.75rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 700;
            z-index: 2;
        }

        .product-card .btn-add-cart {
            position: absolute;
            bottom: -50px;
            left: 50%;
            transform: translateX(-50%);
            background: white;
            color: var(--primary);
            border: none;
            width: 45px;
            height: 45px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: var(--shadow-lg);
            transition: all 0.3s ease;
            z-index: 3;
            cursor: pointer;
        }

        .product-card:hover .btn-add-cart {
            bottom: 1rem;
        }

        .product-card .btn-add-cart:hover {
            background: var(--primary);
            color: white;
            transform: translateX(-50%) scale(1.1);
        }

        .price {
            font-weight: 700;
            font-size: 1.1rem;
            color: var(--primary);
        }

        .price-old {
            text-decoration: line-through;
            color: #94a3b8;
            font-size: 0.9rem;
            margin-left: 0.5rem;
        }

        .hero {
            background: var(--gradient-2);
            position: relative;
            overflow: hidden;
            padding: 6rem 0;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -10%;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(99,102,241,0.15) 0%, transparent 70%);
            border-radius: 50%;
        }

        .hero h1 {
            font-size: 3.5rem;
            font-weight: 700;
            color: white;
            line-height: 1.2;
            margin-bottom: 1.5rem;
        }

        .hero p {
            color: #94a3b8;
            font-size: 1.1rem;
            margin-bottom: 2rem;
        }

        .category-card {
            position: relative;
            border-radius: var(--radius);
            overflow: hidden;
            height: 220px;
            display: block;
        }

        .category-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.6s ease;
        }

        .category-card:hover img {
            transform: scale(1.1);
        }

        .category-card .overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(0,0,0,0.7) 0%, transparent 60%);
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            padding: 1.5rem;
        }

        .category-card h5 {
            color: white;
            font-weight: 700;
            margin: 0;
        }

        .category-card span {
            color: rgba(255,255,255,0.7);
            font-size: 0.85rem;
        }

        .cart-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background: var(--secondary);
            color: white;
            font-size: 0.65rem;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
        }

        .footer {
            background: var(--dark);
            color: #94a3b8;
            padding: 4rem 0 2rem;
        }

        .footer h5 {
            color: white;
            font-weight: 600;
            margin-bottom: 1.5rem;
        }

        .footer a {
            color: #94a3b8;
            text-decoration: none;
            transition: color 0.3s;
            display: block;
            margin-bottom: 0.5rem;
        }

        .footer a:hover {
            color: var(--primary);
        }

        .alert {
            border: none;
            border-radius: 0;
            padding: 1rem 0;
        }

        .alert-success {
            background: #dcfce7;
            color: #166534;
        }

        .alert-danger {
            background: #fee2e2;
            color: #991b1b;
        }

        .form-control, .form-select {
            border: 2px solid #e2e8f0;
            border-radius: var(--radius-sm);
            padding: 0.75rem 1rem;
            transition: all 0.3s;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
        }

        .section-title {
            font-weight: 700;
            font-size: 2rem;
            margin-bottom: 0.5rem;
            position: relative;
            display: inline-block;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: -8px;
            right: 0;
            width: 50px;
            height: 4px;
            background: var(--gradient-1);
            border-radius: 2px;
        }

        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

        @media (max-width: 768px) {
            .hero h1 { font-size: 2rem; }
        }
    </style>
    @stack('styles')
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="fas fa-shopping-bag me-2"></i>متجري
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                            الرئيسية
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">التصنيفات</a>
                        <ul class="dropdown-menu">
                            @foreach(\App\Models\Category::where('is_active', true)->take(8)->get() as $cat)
                            <li><a class="dropdown-item" href="{{ route('category.show', $cat->id) }}">{{ $cat->name }}</a></li>
                            @endforeach
                        </ul>
                    </li>
                </ul>

                <div class="d-flex align-items-center gap-3">
                    <!-- Search -->
                    <form action="{{ route('products.search') }}" method="GET" class="d-none d-lg-flex">
                        <div class="input-group">
                            <input type="search" name="q" class="form-control" placeholder="ابحث..." value="{{ request('q') }}">
                            <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
                        </div>
                    </form>

                    <!-- Cart -->
                    <a href="{{ route('cart.index') }}" class="btn btn-light position-relative">
                        <i class="fas fa-shopping-cart text-primary"></i>
                        @php
                            $cartCount = 0;
                            if(auth('customer')->check()) {
                                $cartCount = \App\Models\Cart::where('customer_id', auth('customer')->id())->sum('quantity');
                            } else {
                                $cartCount = \App\Models\Cart::where('session_id', Session::getId())->sum('quantity');
                            }
                        @endphp
                        @if($cartCount > 0)
                            <span class="cart-badge">{{ $cartCount }}</span>
                        @endif
                    </a>

                    <!-- Auth -->
                    @auth('customer')
                        <div class="dropdown">
                            <button class="btn btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user-circle text-primary me-1"></i>
                                {{ auth('customer')->user()->first_name }}
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ route('orders.index') }}"><i class="fas fa-box me-2"></i>طلباتي</a></li>
                                <li><a class="dropdown-item" href="{{ route('customer.profile') }}"><i class="fas fa-user me-2"></i>الملف الشخصي</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('customer.logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="fas fa-sign-out-alt me-2"></i>تسجيل الخروج
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @else
                        <a href="{{ route('customer.login') }}" class="btn btn-outline-primary">تسجيل الدخول</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Alerts -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <div class="container">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <div class="container">
                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    @endif

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer mt-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4">
                    <h5 class="mb-3" style="color: white; font-weight: 700;">متجري</h5>
                    <p>وجهتك الأولى للتسوق الإلكتروني بأفضل الأسعار وأعلى جودة.</p>
                    <div class="d-flex gap-3 mt-3">
                        <a href="#"><i class="fab fa-facebook-f fa-lg"></i></a>
                        <a href="#"><i class="fab fa-twitter fa-lg"></i></a>
                        <a href="#"><i class="fab fa-instagram fa-lg"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-6">
                    <h5>روابط سريعة</h5>
                    <a href="{{ route('home') }}">الرئيسية</a>
                    <a href="{{ route('home') }}#categories">التصنيفات</a>
                    <a href="{{ route('cart.index') }}">السلة</a>
                </div>
                <div class="col-lg-2 col-6">
                    <h5>خدمة العملاء</h5>
                    <a href="#">الشحن</a>
                    <a href="#">الإرجاع</a>
                    <a href="#">الأسئلة الشائعة</a>
                </div>
                <div class="col-lg-4">
                    <h5>النشرة البريدية</h5>
                    <p>اشترك للحصول على أحدث العروض</p>
                    <form class="d-flex gap-2">
                        <input type="email" class="form-control" placeholder="بريدك الإلكتروني">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane"></i></button>
                    </form>
                </div>
            </div>
            <hr class="my-4 border-secondary">
            <div class="text-center">
                <p class="mb-0">© 2026 متجري - جميع الحقوق محفوظة</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        window.addEventListener('scroll', () => {
            document.querySelector('.navbar').classList.toggle('scrolled', window.scrollY > 50);
        });
    </script>
    @stack('scripts')
</body>
</html>
