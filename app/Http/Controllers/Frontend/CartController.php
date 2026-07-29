<?php

namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Controller;
use App\Interfaces\ProductRepositoryInterface;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function index()
    {
        $cart = $this->getCart();
        $total = $cart->sum(function ($item) {
            return $item->quantity * $item->product->final_price;
        });
        return view('frontend.cart.index', compact('cart', 'total'));
    }

    public function add(Request $request)
    {
        try {
            $product = Product::findOrFail($request->product_id);

            if ($product->quantity < ($request->quantity ?? 1)) {
                return redirect()->back()->with('error', 'الكمية المطلوبة غير متوفرة');
            }

            $cartData = [
                'product_id' => $request->product_id,
                'quantity' => $request->quantity ?? 1,
            ];

            if (auth('customer')->check()) {
                $cartData['customer_id'] = auth('customer')->id();
                $existing = Cart::where('customer_id', auth('customer')->id())
                    ->where('product_id', $request->product_id)
                    ->first();
            } else {
                $cartData['session_id'] = Session::getId();
                $existing = Cart::where('session_id', Session::getId())
                    ->where('product_id', $request->product_id)
                    ->first();
            }

            if ($existing) {
                $existing->update(['quantity' => $existing->quantity + ($request->quantity ?? 1)]);
            } else {
                Cart::create($cartData);
            }

            return redirect()->back()->with('success', 'تمت إضافة المنتج للسلة');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function update(Request $request, int $id)
    {
        $cart = Cart::findOrFail($id);

        if ($cart->product->quantity < $request->quantity) {
            return redirect()->back()->with('error', 'الكمية المطلوبة غير متوفرة');
        }

        if ($request->quantity <= 0) {
            $cart->delete();
            return redirect()->back()->with('success', 'تم حذف المنتج من السلة');
        }

        $cart->update(['quantity' => $request->quantity]);
        return redirect()->back()->with('success', 'تم تحديث الكمية');
    }

    public function remove(int $id)
    {
        Cart::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'تم حذف المنتج من السلة');
    }

    private function getCart()
    {
        if (auth('customer')->check()) {
            return Cart::where('customer_id', auth('customer')->id())
                ->with('product')
                ->get();
        }
        return Cart::where('session_id', Session::getId())
            ->with('product')
            ->get();
    }
}
