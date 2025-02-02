<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartProduct extends Model
{
    use HasFactory;

    // Define the table associated with the model
    protected $table = 'cart_product';

    // Define the fillable fields for mass assignment
    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
    ];

    // Disable auto-incrementing for the primary keys
    public $incrementing = false;

    // Define the primary key (since it's a composite primary key)
    protected $primaryKey = ['user_id', 'product_id'];

    // Get the primary key for the model
    public function getKeyName()
    {
        return ['user_id', 'product_id'];
    }

    // Define the relationships

    // Relationship with User (Many-to-One)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    // Relationship with Product (Many-to-One)
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }
}
