<?php 

namespace App\Services;

class CheckUpService 
{
    public function isMalnourished($symptomIds): bool
    {
        $ids = [2, 4, 8, 11];
        $found = array_filter($symptomIds, fn ($v) => in_array($v, $ids));

        return count($found) === 4;
    }
}