<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FoodRecommendation extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'name',
        'image_url',
        'description',
        'min_age_recommended',
        'max_age_recommended'
    ];
}
