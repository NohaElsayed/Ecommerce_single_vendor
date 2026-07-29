<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Interfaces\CategoryRepositoryInterface;
use App\Traits\UploadImageTrait;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected $categoryRepo;

    public function __construct(CategoryRepositoryInterface $categoryRepo)
    {
        $this->categoryRepo = $categoryRepo;
    }

    public function index()
    {
        $categories = $this->categoryRepo->getWithSubCategories();
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|unique:categories',
            'description' => 'nullable|string',
            'image' => 'nullable|image',
            'is_active' => 'boolean',
        ]);

        $data['slug'] = Str::slug($data['name']);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('categories', 'public');
        }

        $this->categoryRepo->create($data);
        return redirect()->route('admin.categories.index')->with('success', 'تم إضافة الفئة');
    }

    public function edit(int $id)
    {
        $category = $this->categoryRepo->find($id);
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, int $id)
    {
        $data = $request->validate([
            'name' => 'required|string|unique:categories,name,' . $id,
            'description' => 'nullable|string',
            'image' => 'nullable|image',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('categories', 'public');
        }

        $this->categoryRepo->update($id, $data);
        return redirect()->route('admin.categories.index')->with('success', 'تم تحديث الفئة');
    }

    public function destroy(int $id)
    {
        $this->categoryRepo->delete($id);
        return redirect()->route('admin.categories.index')->with('success', 'تم حذف الفئة');
    }
}
