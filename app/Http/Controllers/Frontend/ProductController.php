<?php

namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Controller;
use App\Interfaces\ProductRepositoryInterface;
use App\Interfaces\CategoryRepositoryInterface;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Interfaces\SubcategoryRepositoryInterface;

class ProductController extends Controller
{
    protected $productRepo;
    protected $categoryRepo;

    public function __construct(
        ProductRepositoryInterface $productRepo,
        CategoryRepositoryInterface $categoryRepo
    ) {
        $this->productRepo = $productRepo;
        $this->categoryRepo = $categoryRepo;
    }

    public function index(Request $request)
    {
        $query = Product::with(['category', 'subCategory'])->where('is_active', true);

        // 🔍 بحث نصي
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // 🏷️ فلترة حسب الفئة
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // 🏷️ فلترة حسب الفئة الفرعية
        if ($request->filled('subcategory')) {
            $query->where('sub_category_id', $request->subcategory);
        }

        // 💰 فلترة السعر
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // 🏷️ فلترة التخفيضات فقط
        if ($request->filled('on_sale')) {
            $query->whereNotNull('sale_price')->whereColumn('sale_price', '<', 'price');
        }

        // 📊 الترتيب
        $sort = $request->get('sort', 'latest');
        switch ($sort) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'name_az':
                $query->orderBy('name', 'asc');
                break;
            case 'name_za':
                $query->orderBy('name', 'desc');
                break;
            default:
                $query->latest();
                break;
        }

        $products = $query->paginate(12)->withQueryString();
        $categories = $this->categoryRepo->getWithSubCategories();

        return view('frontend.products.index', compact('products', 'categories'));
    }

    public function show(string $slug)
    {
        $product = $this->productRepo->findBySlug($slug);
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->take(4)
            ->get();

        return view('frontend.products.show', compact('product', 'relatedProducts'));
    }

    public function category(int $id)
    {
        $category = $this->categoryRepo->find($id);
        $products = $this->productRepo->getByCategory($id);
        return view('frontend.products.category', compact('category', 'products'));
    }

    public function search(Request $request)
    {
        return redirect()->route('products.index', ['search' => $request->q]);
    }
}
