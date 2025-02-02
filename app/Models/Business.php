<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderProduct;


class Business extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $table = 'business';

    protected $fillable = [
        'id',
        'name',
        'description',
        'sector'
    ];

    // Define the User relationship (One-to-One)
    public function user()
{
    return $this->belongsTo(User::class, 'id', 'id');
}

    // Define the Product relationship (One-to-Many)
    public function products()
    {
        return $this->hasMany(Product::class, 'business_id', 'id');
    }
    
}