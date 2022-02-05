@extends('layouts.dashboard')

@section('content')
    <div class="container mt-5">
        <table class="table table-bordered mb-5">
            <thead>
                <tr class="table-info">
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Address</th>
                </tr>
            </thead>
            <tbody>
                @foreach($parents as $parent)
                <tr>
                    <td>{{ $parent->name }}</td>
                    <td>{{ $parent->email }}</td>
                    <td>{{ $parent?->details?->address }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-center">
            {!! $parents->links() !!}
        </div>
    </div>
@endsection