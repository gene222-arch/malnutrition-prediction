@extends('layouts.dashboard')

@section('content')
    <div class="container mt-5">
        <table class="table table-bordered mb-5">
            <thead>
                <tr class="table-info">
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Phone Number</th>
                    <th scope="col">Address</th>
                    <th scope="col">Available Person on Absence</th>
                </tr>
            </thead>
            <tbody>
                @foreach($parents as $parent)
                <tr>
                    <td>{{ $parent->name }}</td>
                    <td>{{ $parent->email }}</td>
                    <td>{{ $parent?->details?->phone_number }}</td>
                    <td>{{ $parent?->details?->address }}</td>
                    <td>{{ $parent?->details?->available_person_on_absence }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-center">
            {!! $parents->links() !!}
        </div>
    </div>
@endsection