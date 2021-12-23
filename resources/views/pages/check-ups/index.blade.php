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
                    <th scope="col">Name</th>
                    <th scope="col">Age</th>
                    <th scope="col">Date of Reservation</th>
                    <th scope="col">Date of Visit</th>
                </tr>
            </thead>
            <tbody>
                @foreach($checkUps as $checkUp)
                    <tr>
                        <td>
                            <a href="{{ route('check-ups.edit', $checkUp->id) }}">
                                {{ $checkUp->patient_name }}
                            </a>
                        </td>
                        <td>{{ $checkUp->age }}</td>
                        <td>{{ $checkUp->reserved_at }}</td>
                        <td>{{ $checkUp->visited_at }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-center">
            {!! $checkUps->links() !!}
        </div>
    </div>
@endsection