<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Product;


class ProductReview extends Model
{
    use HasFactory;

    // Define the table associated with the model
    protected $table = 'product_review';

    protected $primaryKey = 'review_id';

    protected $fillable = [
        'review_id',
        'product_id',
        'score',
        'review',
        'user_id'
    ];

    // Define the relationships

    // Relationship with Product (Many-to-One)
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }

    // Relationship with User (Many-to-One)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
