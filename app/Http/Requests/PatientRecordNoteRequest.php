<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PatientRecordNoteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check() && auth()->user()->hasAnyRole(['Administrator', 'Barangay Nutrition Scholar']);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'check_up_id' => ['required', 'integer', 'exists:check_ups,id'],
            'note' => ['required', 'string'],
            'patient_record_note_id' => ['nullable', 'integer', 'exists:patient_record_notes,id']
        ];
    }
}
