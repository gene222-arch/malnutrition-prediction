@extends('layouts.dashboard')

@section('content')
    <form action="{{ route('patient-records.update', $patientRecordID) }}" method="post">
        @method('PUT')
        @csrf
        <div class="card-header rounded bg-light border mb-2">
            <div class="row">
                <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                    <h4 class="lead"><strong>Update Patient Record</strong></h4>
                </div>
                <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 text-right">
                    <button class="btn btn-success">Save</button>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mb-2">
                <div class="card">
                    <div class="card-header" style="background-color: #3d4ead">
                        <h5><strong class="lead text-white">Patient</strong></h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text text-white" id="basic-addon1" style="background-color: #5c6cc9">Check up list</span>
                                    <select 
                                        class="form-control @error('check_up_id') is-invalid @enderror"
                                        name="check_up_id"
                                    >
                                        <option value="">Select Check up</option>
                                        @foreach($checkUps as $checkUp)
                                            <option value="{{ $checkUp->id }}" {{ $checkUpID === $checkUp->id ? 'selected' : '' }}>
                                                {{ $checkUp->patient_name }} - {{ $checkUp->parent->name }}
                                            </option>
                                        @endforeach 
                                    </select>
                                    @error('check_up_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text text-white" id="basic-addon1" style="background-color: #5c6cc9">Notes</span>
                                    </div>
                                    <textarea 
                                        name="note"
                                        class="form-control @error('notes') is-invalid @enderror border border-primary"  
                                        id="exampleFormControlTextarea1" 
                                        rows="3"
                                    >{{ $note }}</textarea>
                                    @error('notes')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <input type="hidden" name="patient_record_note_id" value="{{ $patientRecordNoteID }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection