<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'parent_id'];
    protected $table = 'categories';
    protected $with = ['movies', 'children'];

    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }

    public function movies(): HasMany
    {
        return $this->hasMany(Movie::class, 'category_id', 'id');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
