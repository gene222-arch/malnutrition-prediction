<?php

namespace App\Http\Requests\CheckUp;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'parent_id' => ['required', 'integer', 'exists:users,id'],
            'patient_name' => ['required', 'string'],
            'age' => ['required', 'integer', 'min:0', 'max:2'],
            'height_in_cm' => ['required', 'numeric'],
            'weight_in_kg' => ['required', 'numeric'],
            'reserved_at' => ['required', 'date'],
            'malnutrition_symptom_ids.*' => ['required', 'integer', 'exists:malnutrition_symptoms,id']
        ];
    }
}
