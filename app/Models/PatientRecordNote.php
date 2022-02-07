<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientRecordNote extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_record_id',
        'body'
    ];

    public $timestamps = false;
}
