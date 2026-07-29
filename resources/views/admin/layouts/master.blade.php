{{-- resources/views/admin/layouts/master.blade.php --}}
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>لوحة التحكم - @yield('title', 'الرئيسية')</title>

    <!-- Bootstrap 5 RTL -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-color: #4e73df;
            --secondary-color: #858796;
            --success-color: #1cc88a;
            --info-color: #36b9cc;
            --warning-color: #f6c23e;
            --danger-color: #e74a3b;
            --sidebar-width: 260px;
            --sidebar-bg: #2e323c;
            --sidebar-hover: #3a3f4b;
        }

        * { font-family: 'Cairo', sans-serif; }

        body {
            background-color: #f8f9fc;
            overflow-x: hidden;
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 0;
            right: 0;
            height: 100vh;
            width: var(--sidebar-width);
            background: var(--sidebar-bg);
            color: #fff;
            z-index: 1000;
            transition: all 0.3s;
            overflow-y: auto;
        }

        .sidebar-brand {
            padding: 1.5rem;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .sidebar-brand h4 {
            color: #fff;
            font-weight: 700;
            margin: 0;
        }

        .sidebar-brand i {
            color: var(--primary-color);
            margin-left: 8px;
        }

        .nav-item {
            position: relative;
        }

        .nav-link {
            color: rgba(255,255,255,0.8);
            padding: 0.85rem 1.5rem;
            display: flex;
            align-items: center;
            transition: all 0.2s;
            text-decoration: none;
            border-right: 3px solid transparent;
        }

        .nav-link:hover, .nav-link.active {
            color: #fff;
            background: var(--sidebar-hover);
            border-right-color: var(--primary-color);
        }

        .nav-link i {
            width: 24px;
            margin-left: 12px;
            font-size: 1.1rem;
        }

        .sidebar-heading {
            padding: 0.75rem 1.5rem;
            font-size: 0.75rem;
            text-transform: uppercase;
            color: rgba(255,255,255,0.4);
            font-weight: 700;
        }

        /* Main Content */
        .main-content {
            margin-right: var(--sidebar-width);
            min-height: 100vh;
            transition: all 0.3s;
        }

        .topbar {
            background: #fff;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58,59,69,0.1);
            padding: 1rem 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .content-wrapper {
            padding: 1.5rem;
        }

        /* Cards */
        .stat-card {
            border: none;
            border-radius: 0.5rem;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58,59,69,0.1);
            transition: transform 0.2s;
        }

        .stat-card:hover {
            transform: translateY(-3px);
        }

        .stat-card .card-body {
            padding: 1.5rem;
        }

        .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .bg-gradient-primary { background: linear-gradient(135deg, #4e73df 0%, #224abe 100%); }
        .bg-gradient-success { background: linear-gradient(135deg, #1cc88a 0%, #13855c 100%); }
        .bg-gradient-info { background: linear-gradient(135deg, #36b9cc 0%, #258391 100%); }
        .bg-gradient-warning { background: linear-gradient(135deg, #f6c23e 0%, #dda20a 100%); }

        .table-card {
            background: #fff;
            border-radius: 0.5rem;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58,59,69,0.1);
        }

        .table-card .card-header {
            background: #fff;
            border-bottom: 1px solid #e3e6f0;
            padding: 1rem 1.5rem;
            font-weight: 700;
            color: #4e73df;
        }

        .btn-action {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
        }

        .badge-status {
            padding: 0.5em 0.75em;
            border-radius: 0.375rem;
        }

        /* Charts */
        .chart-container {
            position: relative;
            height: 350px;
        }

        @media (max-width: 768px) {
            .sidebar {
                right: -260px;
            }
            .sidebar.active {
                right: 0;
            }
            .main-content {
                margin-right: 0;
            }
        }
    </style>
    @stack('styles')
</head>
<body>

<!-- Sidebar -->
<nav class="sidebar">
    <div class="sidebar-brand">
        <h4><i class="bi bi-shop"></i> متجري</h4>
    </div>

    <ul class="nav flex-column mt-3">
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                <i class="bi bi-speedometer2"></i>
                <span>لوحة التحكم</span>
            </a>
        </li>

        <div class="sidebar-heading mt-3">المتجر</div>

        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}" href="{{ route('admin.products.index') }}">
                <i class="bi bi-box-seam"></i>
                <span>المنتجات</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}" href="{{ route('admin.categories.index') }}">
                <i class="bi bi-grid"></i>
                <span>الفئات</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.subcategories.*') ? 'active' : '' }}" href="{{ route('admin.subcategories.index') }}">
                <i class="bi bi-grid-3x3-gap"></i>
                <span>الفئات الفرعية</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}" href="{{ route('admin.orders.index') }}">
                <i class="bi bi-cart-check"></i>
                <span>الطلبات</span>
            </a>
        </li>

        <div class="sidebar-heading mt-3">التقارير</div>

        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.reports.sales') ? 'active' : '' }}" href="{{ route('admin.reports.sales') }}">
                <i class="bi bi-graph-up"></i>
                <span>مبيعات</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.reports.products') ? 'active' : '' }}" href="{{ route('admin.reports.products') }}">
                <i class="bi bi-box"></i>
                <span>المنتجات الأكثر مبيعاً</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.reports.customers') ? 'active' : '' }}" href="{{ route('admin.reports.customers') }}">
                <i class="bi bi-people"></i>
                <span>أفضل العملاء</span>
            </a>
        </li>

        <div class="sidebar-heading mt-3">الإدارة</div>

        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
                <i class="bi bi-people-fill"></i>
                <span>المستخدمين والصلاحيات</span>
            </a>
        </li>

        <li class="nav-item mt-4">
            <a class="nav-link text-danger" href="#" onclick="document.getElementById('logout-form').submit()">
                <i class="bi bi-box-arrow-right"></i>
                <span>تسجيل الخروج</span>
            </a>
            <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </li>
    </ul>
</nav>

<!-- Main Content -->
<div class="main-content">
    <div class="topbar">
        <h5 class="m-0 text-gray-800">@yield('page-title', 'لوحة التحكم')</h5>
        <div class="d-flex align-items-center gap-3">
            <span class="text-muted"><i class="bi bi-person-circle"></i> {{ auth()->user()->name }}</span>
        </div>
    </div>

    <div class="content-wrapper">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="bi bi-exclamation-circle-fill"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

@stack('scripts')
</body>
</html>
