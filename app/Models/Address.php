<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{

    protected $primaryKey='user_id';
    protected $table = 'address'; // Ensure it matches your actual table name
    
    protected $fillable = ['street', 'number', 'city', 'postal_code'];

    public function user()
{
    return $this->belongsTo(User::class, 'user_id');
}


}
