@extends('layouts.dashboard')

@section('content')
    <div class="card">
        <div class="card-header">
            <strong>{{ Auth::user()->name }}</strong>
            <span 
                @class([
                    "badge",
                    "badge-success" => !$checkUp->result->is_malnourished,
                    "badge-danger" => $checkUp->result->is_malnourished
                ])
            >
                {{ $checkUp->result->is_malnourished ? "Malnourished" : "Healthy" }}
            </span>
        </div>
        <div class="card-body">
            {{-- Patient Information --}}
            <p>
                <span><strong>Date of Visit</strong></span> : {{ \Carbon\Carbon::parse($checkUp->visited_at)->format('M d, Y') }}
            </p>
            <p>
                <span><strong>Reason for visit</strong></span> : {{ $checkUp->reason_for_visit }}
            </p>
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
                <div class="row">
                    <div class="col">
                        <div class="card card-body bg-light">
                            @foreach ($checkUp->details as $detail)
                                <p class="btn btn-light text-dark" data-toggle="modal" data-target="#symptom{{ $detail->symptom->id }}"><strong><i class="fas fa-circle-notch mr-1"></i></strong> {{ $detail->symptom->name }}</p>

                                <div class="modal fade" id="symptom{{ $detail->symptom->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">{{ $detail->symptom->name }}</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                {{ $detail->symptom->recommendation }}
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="col">
                        <div id="container"></div>
                    </div>
                </div>
            </div>
            {{-- BMI Result --}}
            <p>
                <button class="btn btn-danger btn-block" type="button" data-toggle="collapse" data-target="#bmiResult" aria-expanded="false" aria-controls="collapseExample">
                    <i class="fas fa-poll"></i> BMI Result
                </button>
            </p>
            <div class="collapse mb-3" id="bmiResult">
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
            <p>
                <button class="btn btn-success btn-block" type="button" data-toggle="collapse" data-target="#progress" aria-expanded="false" aria-controls="collapseExample">
                    <i class="fas fa-poll"></i> Progress
                </button>
            </p>
            <div class="collapse" id="progress">
                <div id="progress-chart"></div>
            </div>
            <p>
                <button class="btn btn-warning btn-block" type="button" data-toggle="collapse" data-target="#foodrecommendation" aria-expanded="false" aria-controls="collapseExample">
                    <i class="fas fa-hamburger"></i> Food Recommended
                </button>
            </p>
            <div class="collapse" id="foodrecommendation">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                          <tr>
                            <th scope="col">Image</th>
                            <th scope="col">Type</th>
                            <th scope="col">Name</th>
                            <th scope="col">Description</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach ($foodRecommendations as $food)
                            <tr>
                                <td>
                                    <img src="{{ $food->image_url }}" class="img-responsive rounded" width="150" height="100" alt="">
                                </td>
                                <td>{{ $food->type }}</td>
                                <td>{{ $food->name }}</td>
                                <td>{{ $food->description }}</td>
                            </tr>
                          @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection



@section('js')
<script src="https://code.highcharts.com/highcharts.js"></script>
<script>
    const symptoms = '<?= $checkUp->details->count() ?>';
    let progress = '<?= $progress ?>'.replace('[', '').replace(']', '').split(',').map(prog => parseInt(prog));

    Highcharts.chart('container', {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: 'Symptom Chart'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        accessibility: {
            point: {
                valueSuffix: '%'
            }
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                }
            }
        },
        series: [{
            name: 'Brands',
            colorByPoint: true,
            data: [{
                name: 'Symptoms',
                y: parseFloat((100).toFixed(2)),
                sliced: true,
                selected: true
            }, {
                name: 'Patient Symptoms',
                y: parseFloat(((symptoms / 12) * 100).toFixed(2))
            }]
        }]
    });

    Highcharts.chart('progress-chart', {
        title: {
            text: 'Patient`s Symptoms Progress'
        },

        yAxis: {
            title: {
                text: 'Symptoms'
            }
        },

        xAxis: {
            accessibility: {
                rangeDescription: 'Range: 2010 to 2017'
            }
        },

        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle'
        },

        plotOptions: {
            series: {
                label: {
                    connectorAllowed: true
                },
                pointStart: 1
            }
        },

        series: [{
            name: 'Check up count',
            data: progress
        }],

        responsive: {
            rules: [{
                condition: {
                    // maxWidth: 500
                },
                chartOptions: {
                    legend: {
                        layout: 'horizontal',
                        align: 'center',
                        verticalAlign: 'bottom'
                    }
                }
            }]
        }

        });
</script>
<script>
    let symptomList = '<?= $symptoms ?>';
    symptomList = symptomList
        .replace('[', '')
        .replace(']', '')
        .replaceAll(`"`, '')
        .split(',');

    const mals = 
    [
        {
            feeling_tired_all_the_time: 1,
            poor_concentration: 1,
            short_for_their_age: 1,
            unintentional_weight_loss: 1,
            label: 'Malnourished'
        },
        {
            feeling_tired_all_the_time: 0,
            poor_concentration: 1,
            short_for_their_age: 1,
            unintentional_weight_loss: 1,
            label: 'Malnourished'
        },
        {
            feeling_tired_all_the_time: 1,
            poor_concentration: 0,
            short_for_their_age: 1,
            unintentional_weight_loss: 1,
            label: 'Malnourished'
        },
        {
            feeling_tired_all_the_time: 1,
            poor_concentration: 1,
            short_for_their_age: 0,
            unintentional_weight_loss: 1,
            label: 'Malnourished'
        },
        {
            feeling_tired_all_the_time: 1,
            poor_concentration: 1,
            short_for_their_age: 1,
            unintentional_weight_loss: 0,
            label: 'Malnourished'
        },
        {
            feeling_tired_all_the_time: 1,
            poor_concentration: 1,
            short_for_their_age: 0,
            unintentional_weight_loss: 0,
            label: 'Moderately Malnourished'
        },
        {
            feeling_tired_all_the_time: 1,
            poor_concentration: 0,
            short_for_their_age: 1,
            unintentional_weight_loss: 0,
            label: 'Moderately Malnourished'
        },
        {
            feeling_tired_all_the_time: 1,
            poor_concentration: 0,
            short_for_their_age: 0,
            unintentional_weight_loss: 1,
            label: 'Moderately Malnourished'
        },
        {
            feeling_tired_all_the_time: 0,
            poor_concentration: 1,
            short_for_their_age: 1,
            unintentional_weight_loss: 0,
            label: 'Moderately Malnourished'
        },
        {
            feeling_tired_all_the_time: 0,
            poor_concentration: 1,
            short_for_their_age: 0,
            unintentional_weight_loss: 1,
            label: 'Moderately Malnourished'
        },
        {
            feeling_tired_all_the_time: 0,
            poor_concentration: 0,
            short_for_their_age: 1,
            unintentional_weight_loss: 1,
            label: 'Moderately Malnourished'
        },
        {
            feeling_tired_all_the_time: 0,
            poor_concentration: 0,
            short_for_their_age: 0,
            unintentional_weight_loss: 0,
            label: 'Healthy'
        }
    ];


    let symptoms_ = {
        feeling_tired_all_the_time: 0,
        poor_concentration: 0,
        short_for_their_age: 0,
        unintentional_weight_loss: 0
    };
    symptomList.map(s => {
        symptoms_[s] = 1;
    });

    const user = [
        symptoms_
    ];

    console.log(user)

    const RandomForestClassifier = window.RandomForestClassifier;

    RandomForestClassifier.fit(mals, null, "label", (err, trees) => 
    {
        const pred = RandomForestClassifier.predict(user, trees);
        console.log(pred);
    });
</script>
@endsection