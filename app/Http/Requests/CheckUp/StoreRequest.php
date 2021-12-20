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
            'patient_name' => ['required', 'string'],
            'age' => ['required', 'integer', 'min:0', 'max:2'],
            'height_in_cm' => ['required', 'numeric'],
            'height_in_inches' => ['required', 'numeric'],
            'weight_in_kg' => ['required', 'numeric'],
            'weight_in_pounds' => ['required', 'numeric'],
            'reserved_at' => ['required', 'date'],
            'visited_at' => ['required', 'date'],
            'ended_at' => ['required', 'date'],

        ];
    }
}