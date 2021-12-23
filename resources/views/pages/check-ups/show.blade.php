@extends('layouts.dashboard')

@section('content')
    <div class="card">
        <div class="card-header">
            <strong>{{ Auth::user()->name }}</strong>
        </div>
        <div class="card-body">
            {{-- Patient Information --}}
            <p>
                <button class="btn btn-outline-primary btn-block" type="button" data-toggle="collapse" data-target="#patientInfo" aria-expanded="false" aria-controls="collapseExample">
                    <i class="fas fa-hospital-user"></i> Patient Information
                </button>
            </p>
            <div class="collapse mb-3 show" id="patientInfo">
                <div class="card card-body bg-light">
                    <p>
                        <span><strong>Name</strong></span> <span>{{ $checkUp->patient_name }}</span>
                    </p>
                    <p>
                        <span><strong>Age</strong></span> <span>{{ $checkUp->age }}</span>
                    </p>
                    <p>
                        <span><strong>Weight (kg)</strong></span> <span>{{ $checkUp->weight_in_kg }}</span>
                    </p>
                    <p>
                        <span><strong>Height (cm)</strong></span> <span>{{ $checkUp->height_in_cm }}</span>
                    </p>
                </div>
            </div>
            {{-- Symptoms --}}
            <p>
                <button class="btn btn-outline-info btn-block" type="button" data-toggle="collapse" data-target="#symptoms" aria-expanded="false" aria-controls="collapseExample">
                    <i class="fas fa-virus"></i> Symptoms
                </button>
            </p>
            <div class="collapse mb-3" id="symptoms">
                <div class="card card-body bg-light">
                    @foreach ($checkUp->details as $detail)
                        <p class=""><strong><i class="fas fa-circle-notch mr-1"></i></strong> {{ $detail->symptom->name }}</p>
                    @endforeach
                </div>
            </div>
            {{-- BMI Result --}}
            <p>
                <button class="btn btn-danger btn-block" type="button" data-toggle="collapse" data-target="#bmiResult" aria-expanded="false" aria-controls="collapseExample">
                    <i class="fas fa-poll"></i> BMI Result
                </button>
            </p>
            <div class="collapse" id="bmiResult">
                <div 
                    @class([
                        'card' => true,
                        'card-body' => true,
                        'bg-light' => true,
                        'border' => true,
                        'border-dark' => boolval($checkUp->result->result === 'Underweight'),
                        'border-success' => boolval($checkUp->result->result === 'Healthy Weight'),
                        'border-warning' => boolval($checkUp->result->result === 'Overweight'),
                        'border-danger' => boolval($checkUp->result->result === 'Obesity')
                    ])
                >
                    <p>
                        <strong>BMI</strong> {{ $checkUp->result->bmi }}
                    </p>
                    <p>
                        <strong>Result</strong> {{ $checkUp->result->result }}
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection