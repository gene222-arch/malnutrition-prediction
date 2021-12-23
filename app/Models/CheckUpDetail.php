<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckUpDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'check_up_id',
        'malnutrition_symptom_id',
    ];

    public $timestamps = false;
}
