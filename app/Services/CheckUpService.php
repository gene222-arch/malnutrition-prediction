<?php 

namespace App\Services;

use App\Models\MalnutritionSymptom;

class CheckUpService 
{
    public function isMalnourished($symptomIds): bool
    {
        $hasPhysicalSymptoms = MalnutritionSymptom::whereIn('id', $symptomIds)
            ->where('type', 'Physical Appearance')
            ->exists();

        return $hasPhysicalSymptoms;
    }
}