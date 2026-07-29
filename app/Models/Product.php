<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
   use HasFactory;

    protected $fillable = [
        'category_id', 'sub_category_id', 'name', 'slug', 'description',
        'short_description', 'price', 'sale_price', 'quantity', 'sku',
        'image', 'gallery', 'is_active', 'is_featured', 'weight'
    ];

    protected $casts = [
        'gallery' => 'array',
        'price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function getFinalPriceAttribute()
    {
        return $this->sale_price ?? $this->price;
    }

    public function getIsInStockAttribute(): bool
    {
        return $this->quantity > 0;
    }
}
