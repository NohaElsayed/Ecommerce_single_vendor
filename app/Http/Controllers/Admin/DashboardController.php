<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Interfaces\OrderRepositoryInterface;
use App\Interfaces\CustomerRepositoryInterface;
use App\Interfaces\ProductRepositoryInterface;
use App\Interfaces\CategoryRepositoryInterface;
use App\Models\Product;
use App\Models\Order;
class DashboardController extends Controller
{
    protected $orderRepo;
    protected $productRepo;
    protected $customerRepo;

    public function __construct(
        OrderRepositoryInterface $orderRepo,
        ProductRepositoryInterface $productRepo,
        CustomerRepositoryInterface $customerRepo
    ) {
        $this->orderRepo = $orderRepo;
        $this->productRepo = $productRepo;
        $this->customerRepo = $customerRepo;
    }

    public function index()
    {
        $stats = [
            'total_orders' => Order::count(),
            'total_revenue' => Order::where('payment_status', 'paid')->sum('total'),
            'total_customers' => $this->customerRepo->all()->count(),
            'total_products' => $this->productRepo->all()->count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'recent_orders' => $this->orderRepo->getRecent(10),
            'low_stock_products' => Product::where('quantity', '<', 10)->take(5)->get(),
        ];

        $days = collect(range(6, 0))->map(function ($day) {
            $date = now()->subDays($day);
            return [
                'date' => $date->format('Y-m-d'),
                'label' => $date->format('d M'),
            ];
        });

        $orders = Order::where('created_at', '>=', now()->subDays(7))
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->pluck('count', 'date');

        $revenue = Order::where('created_at', '>=', now()->subDays(7))
            ->selectRaw('DATE(created_at) as date, SUM(total) as revenue')
            ->groupBy('date')
            ->pluck('revenue', 'date');

        $chartData = [
            'labels' => $days->pluck('label'),
            'orders' => $days->map(fn($d) => $orders[$d['date']] ?? 0),
            'revenue' => $days->map(fn($d) => $revenue[$d['date']] ?? 0),
        ];

        return view('admin.dashboard.index', compact('stats', 'chartData'));
    }
}
