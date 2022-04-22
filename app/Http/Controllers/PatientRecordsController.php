<?php

namespace App\Http\Controllers;

use App\Http\Requests\PatientRecordNoteRequest;
use App\Models\CheckUp;
use App\Models\PatientRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class PatientRecordsController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:Administrator|Barangay Nutrition Scholar')
            ->except('index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (auth()->user()->hasRole('Parent')) 
        {
            $patientRecords = PatientRecord::query()
                ->with([
                    'parent',
                    'notes'
                ])
                ->where('parent_id', auth()->user()->id)
                ->orderByDesc('created_at')
                ->simplePaginate(10);
        }

        if (auth()->user()->hasAnyRole(['Administrator', 'Barangay Nutrition Scholar']))
        {
            $patientRecords = PatientRecord::query()
                ->with([
                    'parent',
                    'notes' => fn ($q) => $q->distinct('patient_record_id')
                ])
                ->get()
                ->unique('parent_id')
                ->toQuery()
                ->simplePaginate(10);
        }

        return view('pages.patient-record.index', [
            'patientRecords' => $patientRecords
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.patient-record.create', [
            'checkUps' => CheckUp::with('parent')->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\PatientRecordNoteRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PatientRecordNoteRequest $request)
    {
        $parentId = CheckUp::find($request->check_up_id)
            ->parent_id;

        $patientRecord = PatientRecord::create(
            $request->safe()->only('check_up_id') + [
                'parent_id' => $parentId
            ]
        );

        $patientRecord->notes()
            ->create([
                'body' => $request->note
            ]);

        return Redirect::route('patient-records.index')->with([
            'successMessage' => 'Recorded successfully'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PatientRecord  $patientRecord
     * @return \Illuminate\Http\Response
     */
    public function show(PatientRecord $patientRecord)
    {
        return;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PatientRecord  $patientRecord
     * @return \Illuminate\Http\Response
     */
    public function edit(PatientRecord $patientRecord)
    {
        return view('pages.patient-record.edit', [
            'patientRecordID' => $patientRecord->id,  
            'patientRecordNoteID' => request()->input('noteId'),
            'note' => $patientRecord->notes()->find(request()->input('noteId'))->body,
            'checkUpID' => $patientRecord->check_up_id,
            'checkUps' => CheckUp::with('parent')->get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
    * @param  \App\Http\Requests\PatientRecordNoteRequest  $request
     * @param  \App\Models\PatientRecord  $patientRecord
     * @return \Illuminate\Http\Response
     */
    public function update(PatientRecordNoteRequest $request, PatientRecord $patientRecord)
    {
        $patientRecord->update($request->validated());
        $patientRecord->notes()->find($request->patient_record_note_id)
            ->update([
                'body' => $request->note
            ]);

        return Redirect::route('patient-records.index')->with([
            'successMessage' => 'Recorded updated successfully'
        ]);
    }
}
