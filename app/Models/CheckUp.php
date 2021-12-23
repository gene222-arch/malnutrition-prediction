<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class CheckUp extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
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

    protected static function boot()
    {
        parent::boot();

        self::creating(function ($checkUp) {
            $checkUp->user_id = Auth::user()->id;
            $checkUp->visited_at = Carbon::now();
        });

        self::updating(function ($checkUp) {
            $checkUp->visited_at = Carbon::now();
        });
    }

    public function details()
    {
        return $this->hasMany(CheckUpDetail::class);
    }

    public function result()
    {
        return $this->hasOne(CheckUpResult::class);
    }
}
