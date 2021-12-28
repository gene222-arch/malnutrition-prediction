<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckUpProgress extends Model
{
    use HasFactory;

    protected $fillable = [
        'check_up_id',
        'symptom_count'
    ];

    public $timestamps = false;
}
