<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    protected $table = 'plans';
    protected $fillable = ['name', 'slug', 'price', 'duration_months'];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
