<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class CheckUp extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'parent_id',
        'patient_name',
        'height_in_cm',
        'height_in_inches',
        'weight_in_kg',
        'weight_in_pounds',
        'reason_for_visit',
        'birthed_at',
        'visited_at',
        'ended_at'
    ];

    protected static function boot()
    {
        parent::boot();

        self::creating(function ($checkUp) {
            $checkUp->visited_at = Carbon::now();
        });

        self::updating(function ($checkUp) {
            $checkUp->visited_at = Carbon::now();
        });
    }

    public function age()
    {
        return Carbon::parse($this->birthed_at)->age;
    }

    public function details(): HasMany
    {
        return $this->hasMany(CheckUpDetail::class);
    }

    public function progress(): HasMany
    {
        return $this->hasMany(CheckUpProgress::class);
    }

    public function result(): HasOne
    {
        return $this->hasOne(CheckUpResult::class);
    }
}
