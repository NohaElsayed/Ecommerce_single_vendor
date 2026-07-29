<?php

namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Controller;
use App\Interfaces\CategoryRepositoryInterface;
use App\Interfaces\ProductRepositoryInterface;

class HomeController extends Controller
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
        $featured_products = $this->productRepo->getFeatured();
        $categories = $this->categoryRepo->getActive();
        return view('frontend.home.index', compact('featured_products', 'categories'));
    }
}
