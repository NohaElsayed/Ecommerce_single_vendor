<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Interfaces\OrderRepositoryInterface;
use App\Interfaces\CustomerRepositoryInterface;
use App\Interfaces\ProductRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Customer;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function sales(Request $request)
    {
        $period = $request->get('period', 'monthly');
        $now = Carbon::now();

        switch ($period) {
            case 'daily':
                $start = $now->copy()->subDays(30);
                $groupFormat = '%Y-%m-%d';
                break;
            case 'weekly':
                $start = $now->copy()->subWeeks(12);
                $groupFormat = '%x-W%v';
                break;
            case 'yearly':
                $start = $now->copy()->subYears(5);
                $groupFormat = '%Y';
                break;
            default:
                $start = $now->copy()->subMonths(12);
                $groupFormat = '%Y-%m';
                break;
        }

        $sales = Order::where('created_at', '>=', $start)
            ->where('payment_status', 'paid')
            ->selectRaw("DATE_FORMAT(created_at, '{$groupFormat}') as period, SUM(total) as revenue, COUNT(*) as orders")
            ->groupBy('period')
            ->orderBy('period')
            ->get();

        $report = [
            'labels' => $sales->pluck('period'),
            'revenue' => $sales->pluck('revenue'),
            'orders' => $sales->pluck('orders'),
        ];

        return view('admin.reports.sales', compact('report', 'period'));
    }

    public function products()
    {
        $products = OrderItem::selectRaw('product_name, SUM(quantity) as total_sold, SUM(total) as revenue')
            ->groupBy('product_name')
            ->orderByDesc('total_sold')
            ->take(10)
            ->get();

        return view('admin.reports.products', compact('products'));
    }

    public function customers()
    {
        $customers = Customer::withCount('orders')
            ->withSum('orders', 'total')
            ->orderByDesc('orders_count')
            ->take(10)
            ->get();

        return view('admin.reports.customers', compact('customers'));
    }
}
