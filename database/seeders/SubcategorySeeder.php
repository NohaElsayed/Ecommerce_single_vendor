<?php
// database/seeders/SubcategorySeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SubCategory;
use App\Models\Category;

class SubcategorySeeder extends Seeder
{
    public function run(): void
    {
        $electronics = Category::firstOrCreate(
            ['slug' => 'electronics'],
            [
                'name' => 'إلكترونيات',
                'description' => 'أحدث الأجهزة الإلكترونية',
                'image' => null,
                'is_active' => true,
                'sort_order' => 1,
            ]
        );

        // ⬇️ updateOrCreate: لو موجود يحدث، لو مش موجود يضيف
        SubCategory::updateOrCreate(
            ['slug' => 'smartphones'],
            [
                'category_id' => $electronics->id,
                'name' => 'هواتف ذكية',
                'description' => 'أحدث الهواتف',
                'image' => null,
                'is_active' => true,
                'sort_order' => 1,
            ]
        );

        SubCategory::updateOrCreate(
            ['slug' => 'laptops'],
            [
                'category_id' => $electronics->id,
                'name' => 'لابتوبات',
                'description' => 'أجهزة كمبيوتر محمولة',
                'image' => null,
                'is_active' => true,
                'sort_order' => 2,
            ]
        );
    }
}
