<?php

namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Controller;
use App\Interfaces\OrderRepositoryInterface;
use App\Interfaces\ProductRepositoryInterface;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\OrderItem;

class OrderController extends Controller
{
    public function checkout()
    {
        $cart = $this->getCart();
        $total = $cart->sum(function ($item) {
            return $item->quantity * $item->product->final_price;
        });

        if ($cart->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'السلة فارغة');
        }

        return view('frontend.orders.checkout', compact('cart', 'total'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'shipping_address' => 'required|string',
            'billing_address' => 'nullable|string',
            'payment_method' => 'required|in:cash,card',
            'notes' => 'nullable|string',
        ]);

        $cart = $this->getCart();

        if ($cart->isEmpty()) {
            return redirect()->back()->with('error', 'السلة فارغة');
        }

        try {
            $order = DB::transaction(function () use ($request, $cart) {
                $subtotal = $cart->sum(function ($item) {
                    return $item->quantity * $item->product->final_price;
                });

                $tax = $subtotal * 0.15;
                $shipping = $subtotal > 500 ? 0 : 50;
                $total = $subtotal + $tax + $shipping;

                $order = Order::create([
                    'customer_id' => auth('customer')->id(),
                    'order_number' => 'ORD-' . strtoupper(uniqid()),
                    'status' => 'pending',
                    'payment_status' => 'pending',
                    'subtotal' => $subtotal,
                    'tax' => $tax,
                    'shipping' => $shipping,
                    'total' => $total,
                    'shipping_address' => $request->shipping_address,
                    'billing_address' => $request->billing_address ?? $request->shipping_address,
                    'payment_method' => $request->payment_method,
                    'notes' => $request->notes,
                ]);

                foreach ($cart as $item) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $item->product_id,
                        'product_name' => $item->product->name,
                        'price' => $item->product->final_price,
                        'quantity' => $item->quantity,
                        'total' => $item->quantity * $item->product->final_price,
                    ]);

                    $item->product->decrement('quantity', $item->quantity);
                }

                $this->clearCart();

                return $order;
            });

            return redirect()->route('orders.success', $order->id)
                ->with('success', 'تم إنشاء الطلب بنجاح');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function success(int $id)
    {
        $order = Order::with('items')->findOrFail($id);

        if ($order->customer_id !== auth('customer')->id()) {
            abort(403);
        }

        return view('frontend.orders.success', compact('order'));
    }

    public function index()
    {
        $orders = Order::where('customer_id', auth('customer')->id())
            ->with('items')
            ->latest()
            ->get();

        return view('frontend.orders.index', compact('orders'));
    }

    public function show(int $id)
    {
        $order = Order::with('items.product')->findOrFail($id);

        if ($order->customer_id !== auth('customer')->id()) {
            abort(403);
        }

        return view('frontend.orders.show', compact('order'));
    }

    private function getCart()
    {
        if (auth('customer')->check()) {
            return Cart::where('customer_id', auth('customer')->id())->with('product')->get();
        }
        return Cart::where('session_id', Session::getId())->with('product')->get();
    }

    private function clearCart()
    {
        if (auth('customer')->check()) {
            Cart::where('customer_id', auth('customer')->id())->delete();
        } else {
            Cart::where('session_id', Session::getId())->delete();
        }
    }
}
