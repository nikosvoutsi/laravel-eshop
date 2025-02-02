<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    use HasFactory;

    // Define the table associated with the model
    protected $table = 'order_product';

    protected $primaryKey = ['order_id', 'product_id'];

    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'initial_price',
        'total_price'
    ];

    public $incrementing = false;

    // Get the primary key for the model
    public function getKeyName()
    {
        return ['order_id', 'product_id'];
    }

    // Define the relationships

    // Relationship with Order (Many-to-One)
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'order_id');
    }

    // Relationship with Product (Many-to-One)
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }
}
