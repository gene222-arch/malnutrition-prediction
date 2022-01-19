<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckUpResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'check_up_id',
        'bmi',
        'result',
        'is_malnourished'
    ];

    public $timestamps = false;
}
