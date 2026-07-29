<?php

namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Controller;
use App\Interfaces\CustomerRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    protected $customerRepo;

    public function __construct(CustomerRepositoryInterface $customerRepo)
    {
        $this->customerRepo = $customerRepo;
    }

    public function showLogin()
    {
        return view('frontend.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('customer')->attempt($credentials, $request->remember)) {
            $this->transferCart();
            return redirect()->intended(route('home'));
        }

        return back()->with('error', 'بيانات الدخول غير صحيحة');
    }

    public function showRegister()
    {
        return view('frontend.auth.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers',
            'phone' => 'nullable|string',
            'password' => 'required|min:6|confirmed',
            'address' => 'nullable|string',
        ]);

        $data['password'] = Hash::make($data['password']);
        $customer = $this->customerRepo->create($data);
        Auth::guard('customer')->login($customer);

        return redirect()->route('home')->with('success', 'تم إنشاء الحساب بنجاح');
    }

    public function logout()
    {
        Auth::guard('customer')->logout();
        return redirect()->route('home');
    }

    public function profile()
    {
        return view('frontend.auth.profile');
    }

    public function updateProfile(Request $request)
    {
        $data = $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
            'city' => 'nullable|string',
            'country' => 'nullable|string',
        ]);

        $this->customerRepo->update(auth('customer')->id(), $data);
        return back()->with('success', 'تم تحديث البيانات بنجاح');
    }

    private function transferCart()
    {
        \App\Models\Cart::where('session_id', \Illuminate\Support\Facades\Session::getId())
            ->update(['customer_id' => auth('customer')->id(), 'session_id' => null]);
    }
}
