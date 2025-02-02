<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\ProductCategory;
use App\Models\Business;

class Product extends Model
{
    use HasFactory;

    protected $table = 'product';

    protected $primaryKey = 'product_id';

    protected $fillable = [
        'business_id',
        'category_id',
        'title',
        'code',
        'short_description',
        'long_description',
        'price',
        'stock',
        'image_url',
        'avg_review',
    ];

    // Define relationships or other model-specific methods here
    public function cartProducts()
{
    return $this->hasMany(CartProduct::class, 'product_id', 'product_id');
}

public function productReviews()
{
    return $this->hasMany(ProductReview::class, 'product_id', 'product_id');
}

public function category()
{
    return $this->belongsTo(ProductCategory::class, 'category_id', 'category_id');
}

public function orderProducts()
{
    return $this->hasMany(OrderProduct::class, 'product_id', 'product_id');
}


public function business()
{
    return $this->belongsTo(Business::class, 'business_id', 'id');
}

public function orders()
{
    return $this->belongsToMany(Order::class, 'order_product', 'product_id', 'order_id')
        ->withPivot(['quantity', 'initial_price', 'total_price'])
        ->withTimestamps();
}

}