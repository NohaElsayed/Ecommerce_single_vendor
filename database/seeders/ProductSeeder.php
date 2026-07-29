<?php
// database/seeders/ProductSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use App\Models\SubCategory;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $categories = Category::all();
        $subCategories = SubCategory::all();

        // ❌ خاطئ: لو SubCategories < 3 يرمي خطأ
        // $randomSubs = $subCategories->random(3);

        // ✅ صحيح: استخدم random(1) أو min()
        for ($i = 0; $i < 20; $i++) {
            $category = $categories->random(); // ← واحدة فقط

            // اختيار فرعية تابعة للفئة أو null
            $subCategory = $subCategories
                ->where('category_id', $category->id)
                ->random(1)  // ← اطلب 1 فقط
                ->first();

            Product::create([
                'category_id' => $category->id,
                'sub_category_id' => $subCategory?->id,
                'name' => 'منتج تجريبي ' . ($i + 1),
                'slug' => 'product-' . ($i + 1) . '-' . uniqid(),
                'description' => 'وصف المنتج',
                'short_description' => 'وصف قصير',
                'price' => rand(100, 5000),
                'sale_price' => rand(0, 1) ? rand(80, 4500) : null,
                'quantity' => rand(10, 100),
                'sku' => 'SKU-' . strtoupper(uniqid()),
                'image' => null,
                'gallery' => json_encode([]),
                'is_active' => true,
                'is_featured' => rand(0, 1),
                'weight' => rand(1, 50) / 10,
            ]);
        }
    }
}
