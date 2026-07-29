<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Product;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        // إنشاء الفئة الرئيسية
        $electronics = Category::create([
            'name' => 'إلكترونيات',
            'slug' => 'electronics',
            'description' => 'أحدث الأجهزة الإلكترونية',
            'image' => null,
            'is_active' => true,
            'sort_order' => 1,
        ]);

        // إنشاء الفئة الفرعية
        SubCategory::create([
            'category_id' => $electronics->id,
            'name' => 'هواتف ذكية',        // ← String وليس Array
            'slug' => 'smartphones',        // ← String وليس Array
            'description' => 'أحدث الهواتف',
            'image' => null,
            'is_active' => true,
            'sort_order' => 1,
        ]);

        // منتج تجريبي
        Product::create([
            'category_id' => $electronics->id,
            'sub_category_id' => 1,
            'name' => 'آيفون 15 برو',
            'slug' => 'iphone-15-pro',
            'description' => 'أحدث هاتف من آبل',
            'short_description' => 'هاتف رائد',
            'price' => 4500.00,
            'sale_price' => null,
            'quantity' => 50,
            'sku' => 'IPH-15-PRO',
            'image' => null,
            'gallery' => json_encode([]),   // ← مهم: JSON وليس Array فارغ
            'is_active' => true,
            'is_featured' => true,
            'weight' => 0.5,
        ]);
    }
}
