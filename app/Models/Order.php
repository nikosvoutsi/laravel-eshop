<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    protected $primaryKey = 'order_id';

    protected $table = 'order';

    protected $fillable = [
        'user_id',
        'total_quantity',
        'total_price',
        'address_street',
        'address_number',
        'address_city',
        'address_postal_code',
        'comments'

        // Other fields in your orders table
    ];
    // Define relationships or other model-specific methods here
    public function orderProducts()
{
    return $this->hasMany(OrderProduct::class, 'order_id', 'order_id');
}

// Define the relationship with the User model
public function user()
{
    return $this->belongsTo(User::class, 'user_id');
}
}
