@extends('layouts.dashboard')

@section('content')
    <div class="row justify-content-between">
        <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
            <div class="card border-success mb-3">
                <div class="row align-items-center">
                    <div class="col-8 col-sm-8 col-md-8 col-lg-8">
                        <div class="card-body text-success">
                            <h5 class="card-title"><h3><strong>{{ $checkUpsCount }}</strong></h3></h5>
                            <p class="card-text text-secondary">Check Ups</p>
                        </div>
                    </div>
                    <div class="col-4 col-sm-4 col-md-4 col-lg-4">
                        <i class="fas fa-hospital-user fa-3x text-success"></i>
                    </div>
                </div>
              </div>
        </div>
        <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
            <div class="card border-primary mb-3">
                <div class="row align-items-center">
                    <div class="col-8 col-sm-8 col-md-8 col-lg-8">
                        <div class="card-body text-info">
                            <h5 class="card-title"><h3><strong>{{ $parentsCount }}</strong></h3></h5>
                            <p class="card-text text-secondary">Parents</p>
                        </div>
                    </div>
                    <div class="col-4 col-sm-4 col-md-4 col-lg-4">
                        <i class="fas fa-user fa-3x text-info"></i>
                    </div>
                </div>
              </div>
        </div>
        <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
            <div class="card border-danger mb-3">
                <div class="row align-items-center">
                    <div class="col-8 col-sm-8 col-md-8 col-lg-8">
                        <div class="card-body text-danger">
                            <h5 class="card-title"><h3><strong>{{ $bnsCount }}</strong></h3></h5>
                            <p class="card-text text-secondary">Barangay Nutrition Scholar</p>
                        </div>
                    </div>
                    <div class="col-4 col-sm-4 col-md-4 col-lg-4">
                        <i class="fas fa-user-tie fa-3x text-danger"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 container-fluid">
            <div id="container" class="mt-5"></div>
        </div>
    </div>
@endsection
@section('js')
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script>
        let monthlyCheckups = JSON.parse('<?= $monthlyCheckups ?>');
        let data = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];

        const months = Object.keys(monthlyCheckups).map(month => {
            data[month - 1] = monthlyCheckups[month];
        });
        
        Highcharts.chart('container', {
            title: {
                text: 'Monthly Checkups'
            },
            subtitle: {
                text: 'Source: positronx.io'
            },
            xAxis: {
                categories: [ 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December' ]
            },
            yAxis: {
                title: {
                    text: 'Total',
                }
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'middle'
            },
            plotOptions: {
                series: {
                    allowPointSelect: true
                }
            },
            series: [{
                name: 'Checkups count',
                data,
            }],
            responsive: {
                rules: [{
                    condition: {
                        maxWidth: 500
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
@endsection