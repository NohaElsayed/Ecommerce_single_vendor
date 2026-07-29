<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Interfaces\OrderRepositoryInterface;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected $orderRepo;

    public function __construct(OrderRepositoryInterface $orderRepo)
    {
        $this->orderRepo = $orderRepo;
    }

    public function index()
    {
        $orders = $this->orderRepo->paginate(15);
        return view('admin.orders.index', compact('orders'));
    }

    public function show(int $id)
    {
        $order = $this->orderRepo->find($id);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, int $id)
    {
        $request->validate(['status' => 'required|in:pending,processing,shipped,delivered,cancelled']);
        $this->orderRepo->update($id, ['status' => $request->status]);
        return back()->with('success', 'تم تحديث حالة الطلب');
    }

    public function updatePayment(Request $request, int $id)
    {
        $request->validate(['payment_status' => 'required|in:pending,paid,failed,refunded']);
        $this->orderRepo->update($id, ['payment_status' => $request->payment_status]);
        return back()->with('success', 'تم تحديث حالة الدفع');
    }
}
