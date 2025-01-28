<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Sanctum\HasApiTokens;

class Customers extends Authenticatable
{
    use HasApiTokens;

    protected $fillable = [
        'email',
        'username',
        'password',
        'phone',
        'retailer_username',
    ];

    // Define the relationship to the Retailer model
    public function retailer(): BelongsTo
    {
        return $this->belongsTo(Retailer::class, 'retailer_username', 'username');
    }

    public function carts()
    {
        return $this->hasMany(Cart::class, 'customer_id');
    }
}