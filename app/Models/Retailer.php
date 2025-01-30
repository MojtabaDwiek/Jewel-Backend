<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Sanctum\HasApiTokens;

class Retailer extends Authenticatable
{
    use HasApiTokens;

    protected $fillable = [
        'email',
        'username',
        'password',
        'phone',
    ];

    // Remove the $hidden property to include the password in JSON responses
    // protected $hidden = ['password'];

    public function Customers(): HasMany
    {
        return $this->hasMany(Customers::class);
    }

    public function carts()
    {
        return $this->hasMany(Cart::class, 'retailer_id');
    }

    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'user');
    }
}