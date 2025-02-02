<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    use HasFactory;

    protected $primaryKey = 'category_id';

    protected $table = 'product_category';

    // Define the relationship with products (One-to-Many)
    public function products()
    {
        return $this->hasMany(Product::class, 'category_id', 'category_id');
    }

    // Other model properties and methods can be added here.
}
