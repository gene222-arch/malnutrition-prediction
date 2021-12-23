@extends('layouts.dashboard')

@section('content')
    <div class="container mt-5">
        @if (Session::has('successMessage'))
            <div class="alert alert-success" role="alert">
                <strong>Success:</strong>{{ Session::get('successMessage') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
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
                    <th scope="col">Action</th>
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
                        <td>
                            <form action="{{ route('check-ups.destroy', $checkUp->id) }}" method="POST">
                                @csrf
                                @method("DELETE")
                                <button type="submit" class="btn btn-outline-danger">
                                    <i class="fas fa-user-minus"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-center">
            {!! $checkUps->links() !!}
        </div>
    </div>
@endsection