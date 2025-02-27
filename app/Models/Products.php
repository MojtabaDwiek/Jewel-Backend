<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Products extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'name',
        'sizes',
        'lengths',
        'weight',
        'images', // Updated to reflect 'images' instead of 'image'
        'carat', // Added carat to fillable
        'category', // Added category to fillable
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'sizes' => 'array', // Cast the 'sizes' JSON column to an array
        'lengths' => 'array', // Cast the 'lengths' JSON column to an array
        'images' => 'array', // Cast the 'images' JSON column to an array
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<string>
     */
    protected $hidden = [
        'deleted_at', // Hide soft delete timestamp
    ];

    /**
     * Get the full URL for the product images.
     *
     * @return array
     */
    public function getImagesUrlsAttribute()
    {
        // Return the full URL for each image in the 'images' array
        return collect($this->images)->map(function ($image) {
            return asset('storage/' . $image); // Assumes images are stored in the public disk
        })->toArray();
    }

    /**
     * Define a relationship with the Category model (if applicable).
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'category', 'name'); // Adjust as needed
    }
}
