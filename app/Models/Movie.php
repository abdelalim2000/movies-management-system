<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Movie extends Model
{
    use HasFactory;

    protected $table = 'movies';
    protected $fillable = ['title', 'slug', 'description', 'video', 'category_id', 'paid'];
    protected $with = ['image', 'reviews'];

    public function image(): MorphOne
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, 'movie_id', 'id');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
