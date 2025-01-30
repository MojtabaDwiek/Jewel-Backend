<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    protected $fillable = ['user_id', 'user_type', 'product_id'];

    // Define the polymorphic relationship
    public function user()
    {
        return $this->morphTo();
    }

    // Define the relationship with the Product model
    public function product()
    {
        return $this->belongsTo(Products::class);
    }
}