@extends('layouts.dashboard')

@section('content')
    <div class="container mt-5">
        <div class="card mb-2 rounded">
            <a href="{{ route('check-ups.create') }}">
                <i class="fas fa-plus fa-3x p-4 text-success"></i>
            </a>
        </div>
        <table class="table table-striped mb-5 rounded">
            <thead>
                <tr class="table-info">
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Age</th>
                    <th scope="col">Date of Reservation</th>
                    <th scope="col">Date of Visit</th>
                    <th scope="col">Ended at</th>
                </tr>
            </thead>
            <tbody>
                @foreach($checkUps as $checkUp)
                <tr>
                    <th scope="row">{{ $checkUp->id }}</th>
                    <td>{{ $checkUp->patient_name }}</td>
                    <td>{{ $checkUp->age }}</td>
                    <td>{{ $checkUp->reserved_at }}</td>
                    <td>{{ $checkUp->visited_at }}</td>
                    <td>{{ $checkUp->ended_at }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-center">
            {!! $checkUps->links() !!}
        </div>
    </div>
@endsection