<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'active'
    ];

    protected $casts = [
        'active' => 'boolean'
    ];

    public function scopeActive($query) {
        return $query->where('active', true);
    }

    public function categories() {
        return $this->belongsToMany(Category::class, 'product_category');
    }
}
