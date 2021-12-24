@extends('layouts.dashboard')

@section('content')
    <div class="container mt-5">
        <table class="table table-bordered mb-5">
            <thead>
                <tr class="table-info">
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                </tr>
            </thead>
            <tbody>
                @foreach($brgyNutritionSchs as $brgyNutritionSch)
                <tr>
                    <th scope="row">{{ $brgyNutritionSch->id }}</th>
                    <td>{{ $brgyNutritionSch->name }}</td>
                    <td>{{ $brgyNutritionSch->email }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-center">
            {!! $brgyNutritionSchs->links() !!}
        </div>
    </div>
@endsection