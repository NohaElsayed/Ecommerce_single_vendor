<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Interfaces\SubcategoryRepositoryInterface;
use App\Interfaces\CategoryRepositoryInterface;
use App\Traits\UploadImageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SubCategoryController extends Controller
{
    protected $subcategoryRepo;
    protected $categoryRepo;

    public function __construct(
        SubcategoryRepositoryInterface $subcategoryRepo,
        CategoryRepositoryInterface $categoryRepo
    ) {
        $this->subcategoryRepo = $subcategoryRepo;
        $this->categoryRepo = $categoryRepo;
    }

    public function index()
    {
        $subcategories = $this->subcategoryRepo->paginate(15);  // ← غيّر لـ lowercase
        return view('admin.subcategories.index', compact('subcategories'));
    }

    public function create()
    {
        $categories = $this->categoryRepo->all();
        return view('admin.subcategories.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $data['slug'] = Str::slug($data['name']);
        $this->subcategoryRepo->create($data);

        return redirect()->route('admin.subcategories.index')->with('success', 'تم إضافة الفئة الفرعية');
    }

    public function edit(int $id)
    {
        $subCategory = $this->subcategoryRepo->find($id);
        $categories = $this->categoryRepo->all();
        return view('admin.subcategories.edit', compact('subCategory', 'categories'));
    }

    public function update(Request $request, int $id)
    {
        $data = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $data['slug'] = Str::slug($data['name']);
        $this->subcategoryRepo->update($id, $data);

        return redirect()->route('admin.subcategories.index')->with('success', 'تم تحديث الفئة الفرعية');
    }

    public function destroy(int $id)
    {
        $this->subcategoryRepo->delete($id);
        return redirect()->route('admin.subcategories.index')->with('success', 'تم حذف الفئة الفرعية');
    }
}
