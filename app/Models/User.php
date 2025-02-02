<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname',
        'lastname',
        'email',
        'password',
        'birthdate',
        'phone',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Mutator for hashing the password before saving it to the database.
     *
     * @param string $value
     * @return void
     */
    
    public function productReviews()
{
    return $this->hasMany(ProductReview::class, 'user_id', 'user_id');
}

public function cartProducts()
{
    return $this->hasMany(CartProduct::class, 'user_id', 'user_id');
}

public function address()
{
    return $this->hasOne(Address::class);
}

public function business()
{
    return $this->hasOne(Business::class, 'id', 'id');
}
}
