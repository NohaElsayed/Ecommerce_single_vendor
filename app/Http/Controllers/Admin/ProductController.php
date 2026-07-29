<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Interfaces\ProductRepositoryInterface;
use App\Interfaces\CategoryRepositoryInterface;
use App\Interfaces\SubcategoryRepositoryInterface;
use App\Traits\UploadImageTrait;
use Illuminate\Http\Request;

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

    public function index()
    {
        $products = $this->productRepo->paginate(15);
        $categories = $this->categoryRepo->all();  // ← أضف هذا
        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = $this->categoryRepo->getWithSubCategories();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
            'short_description' => 'nullable|string',
            'price' => 'required|numeric',
            'sale_price' => 'nullable|numeric',
            'quantity' => 'required|integer',
            'sku' => 'required|string|unique:products',
            'category_id' => 'required|exists:categories,id',
            'sub_category_id' => 'nullable|exists:sub_categories,id',
            'image' => 'nullable|image',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
        ]);

        $data['slug'] = Str::slug($data['name']) . '-' . uniqid();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $this->productRepo->create($data);
        return redirect()->route('admin.products.index')->with('success', 'تم إضافة المنتج');
    }

    public function edit(int $id)
    {
        $product = $this->productRepo->find($id);
        $categories = $this->categoryRepo->getWithSubCategories();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, int $id)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'sale_price' => 'nullable|numeric',
            'quantity' => 'required|integer',
            'sku' => 'required|string|unique:products,sku,' . $id,
            'category_id' => 'required|exists:categories,id',
            'sub_category_id' => 'nullable|exists:sub_categories,id',
            'image' => 'nullable|image',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $this->productRepo->update($id, $data);
        return redirect()->route('admin.products.index')->with('success', 'تم تحديث المنتج');
    }

    public function destroy(int $id)
    {
        $this->productRepo->delete($id);
        return redirect()->route('admin.products.index')->with('success', 'تم حذف المنتج');
    }
}
