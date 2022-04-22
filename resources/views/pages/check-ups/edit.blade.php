@extends('layouts.dashboard')

@section('content')
    <form action="{{ route('check-ups.update', $checkUp->id) }}" method="post">
        @method('PUT')
        @csrf
        <div class="card-header rounded bg-light border mb-2">
            <div class="row">
                <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                    <h4 class="lead"><strong>Update Patient</strong></h4>
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
                                    <span class="input-group-text text-white" id="basic-addon1" style="background-color: #5c6cc9">Parent</span>
                                    <select 
                                        class="form-control @error('parent_id') is-invalid @enderror"
                                        name="parent_id"
                                    >
                                        <option value="">Select Guardian</option>
                                        @foreach($parents as $parent)
                                            <option value="{{ $parent->id }}" {{ $checkUp->parent_id === $parent->id ? 'selected' : '' }}>{{ $parent->name }}</option>
                                        @endforeach 
                                    </select>
                                    @error('parent_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text text-white" id="basic-addon1" style="background-color: #5c6cc9">Patient</span>
                                    </div>
                                    <input
                                        name="patient_name"
                                        type="text" 
                                        class="form-control border border-primary @error('patient_name') is-invalid @enderror" 
                                        aria-describedby="basic-addon1"
                                        value="{{ $checkUp->patient_name }}"
                                    >
                                    @error('patient_name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text text-white" id="basic-addon1" style="background-color: #5c6cc9">Height (cm)</span>
                                    </div>
                                    <input 
                                        name="height_in_cm"
                                        type="text" 
                                        class="form-control @error('height_in_cm') is-invalid @enderror border border-primary" 
                                        aria-describedby="basic-addon1"
                                        value="{{ $checkUp->height_in_cm }}"
                                    >
                                    @error('height_in_cm')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                                <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                          <span class="input-group-text  text-white" id="basic-addon1"  style="background-color: #5c6cc9">Weight (kg)</span>
                                        </div>
                                        <input 
                                            name="weight_in_kg"
                                            type="text" 
                                            class="form-control @error('weight_in_kg') is-invalid @enderror border border-primary" 
                                            aria-describedby="basic-addon1"
                                            value="{{ $checkUp->weight_in_kg }}"
                                        >
                                                @error('weight_in_kg')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text text-white" id="basic-addon1" style="background-color: #5c6cc9">Birthday</span>
                                    </div>
                                    <input 
                                        name="birthed_at"
                                        type="date" 
                                        class="form-control @error('birthed_at') is-invalid @enderror border border-primary" 
                                        name="birthed_at"  
                                        class="date-input"
                                        value="{{ \Carbon\Carbon::parse($checkUp->birthed_at)->format('Y-m-d') }}"
                                    >
                                    @error('birthed_at')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text text-white" id="basic-addon1" style="background-color: #5c6cc9">Reason for visit</span>
                                    </div>
                                    <textarea 
                                        name="reason_for_visit"
                                        class="form-control @error('reason_for_visit') is-invalid @enderror border border-primary"  
                                        id="exampleFormControlTextarea1" 
                                        rows="3"
                                    >{{ $checkUp->reason_for_visit }}</textarea>
                                    @error('reason_for_visit')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mt-4">
            <div class="row justify-content-between">
                @foreach ($malnutritionSymptoms as $type => $names)
                    <div class="col-12 col-sm-12 col-md-5 col-lg-5 col-xl-5">
                        <div class="card">
                            <div class="card-header" style="background-color: #3d4ead">
                                <h5><strong class="lead text-white">{{ $type }}</strong></h5>
                            </div>
                            <div class="card-body">
                                @foreach ($names as $name)
                                    @foreach ($name as $id => $value )
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text rounded" style="background-color: #a8b5ff">
                                                    <input
                                                        value={{ $id }}
                                                        name="malnutrition_symptom_ids[]"
                                                        type="checkbox"
                                                        {{ $checkUp->details->pluck('malnutrition_symptom_id')->contains($id) ? 'checked' : '' }}
                                                    >
                                                </div>
                                            </div>
                                            <input 
                                                type="text" 
                                                class="form-control border-bottom border-dark" 
                                                aria-label="Text input with checkbox" 
                                                value="{{ $value }}"
                                            >
                                        </div>
                                    @endforeach
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="col-12 mt-3">
            <p>
                <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                    View Notes
                </button>
            </p>
            <div class="collapse" id="collapseExample">
                @foreach ($notes as $note)
                    <div class="card">
                        <div class="card-header">Notes</div>
                        <div class="card-body">
                        {{ $note->body }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </form>
@endsection