<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckUp extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_name',
        'age',
        'height_in_cm',
        'height_in_inches',
        'weight_in_kg',
        'weight_in_pounds',
        'reserved_at',
        'visited_at',
        'ended_at'
    ];

    public function details()
    {
        return $this->belongsToMany(CheckUpDetail::class, 'check_up_details');
    }

    public function result()
    {
        return $this->hasOne(CheckUpResult::class);
    }
}
