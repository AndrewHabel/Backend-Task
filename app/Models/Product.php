<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'title',
        'description',
        'price',
        'stock_count',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'stock_count' => 'integer',
    ];

    // Relationships
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
