<?php

namespace Database\Factories;

use App\Models\PatientRecord;
use Illuminate\Database\Eloquent\Factories\Factory;

class PatientRecordNoteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'patient_record_id' => PatientRecord::factory()->create()->id,
            'body' => $this->faker->sentence()
        ];
    }
}
