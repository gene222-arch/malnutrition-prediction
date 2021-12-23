<?php

namespace App\Services;

class BMIComputerServices
{
    public static function interpret(float $bmi): string
    {
        if ($bmi < 18.5) return 'Underweight';
        if ($bmi >= 18.5 && $bmi <= 24.9) return 'Healthy Weight';
        if ($bmi >= 25 && $bmi <= 29.9) return 'Overweight';
        if ($bmi >= 30) return 'Obesity';
    }

    public static function compute(float $weightInPounds, float $heightInInches): float
    {
        return ($weightInPounds /$heightInInches / $heightInInches) * 703;
    }
}