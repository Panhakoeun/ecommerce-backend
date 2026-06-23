<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    protected $fillable = ['category_id', 'name', 'description', 'price', 'stock', 'image'];

    public function category() {return $this->belongsTo(Category::class);}
    public function reviews() {return $this->hasMany(Review::class);}

    public function getImageUrlAttribute(): ?string
    {
        if (! $this->image) {
            return null;
        }

        if (Str::startsWith($this->image, ['http://', 'https://', 'data:'])) {
            return $this->image;
        }

        if (Str::startsWith($this->image, 'storage/')) {
            return asset($this->image);
        }

        return asset('storage/'.ltrim($this->image, '/'));
    }
    
}
