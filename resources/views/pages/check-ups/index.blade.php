@extends('layouts.dashboard')

@section('content')
    <div class="container mt-5">
        @if (Session::has('successMessage'))
            <div class="alert alert-success" role="alert">
                <strong>Success:</strong> {{ Session::get('successMessage') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        @hasanyrole('Administrator|Barangay Nutrition Scholar')
            <div class="card mb-2 rounded">
                <a href="{{ route('check-ups.create') }}" data-toggle="tooltip" data-placement="top" title="Add new patient">
                    <i class="fas fa-plus fa-3x p-4 text-success"></i>
                </a>
            </div>
        @endhasanyrole
        <table class="table table-striped mb-5 rounded">
            <thead>
                <tr class="table-info">
                    <th scope="col">Name</th>
                    <th scope="col">Age</th>
                    <th scope="col">Birthday</th>
                    <th scope="col">Date of Visit</th>
                    <th scope="col">Status</th>
                    @hasanyrole('Administrator|Barangay Nutrition Scholar')
                        <th scope="col">Action</th>
                    @endhasanyrole
                </tr>
            </thead>
            <tbody>
                @foreach($checkUps as $checkUp)
                    <tr>
                        @hasanyrole('Administrator|Barangay Nutrition Scholar')
                            <td>
                                <a href="{{ route('check-ups.edit', $checkUp->id) }}" data-toggle="tooltip" data-placement="top" title="View patient details">
                                    {{ $checkUp->patient_name }}
                                </a>
                            </td>
                        @endhasanyrole
                        @hasrole('Parent')
                            <td>
                                <a href="{{ route('check-ups.show', $checkUp->id) }}">
                                    {{ $checkUp->patient_name }}
                                </a>
                            </td>
                        @endhasrole
                        <td>{{ $checkUp->age() }}</td>
                        <td>{{ $checkUp->birthed_at }}</td>
                        <td>{{ $checkUp->visited_at }}</td>
                        <td>
                            <span 
                                @class([
                                    "badge",
                                    "badge-success" => !$checkUp->result->is_malnourished,
                                    "badge-danger" => $checkUp->result->is_malnourished
                                ])
                            >
                                {{ $checkUp->result->is_malnourished ? "Malnourished" : "Healthy" }}
                            </span>
                        </td>
                        @hasanyrole('Administrator|Barangay Nutrition Scholar')
                            <td>
                                <button type="button" class="btn btn-outline-danger" data-toggle="modal" data-target="#exampleModal{{ $checkUp->id }}">
                                    <i class="fas fa-archive"></i>
                                </button>
                                <div class="modal fade" id="exampleModal{{ $checkUp->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Name: <strong class="text-secondary">{{ $checkUp->patient_name }}</strong></h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Are you sure to archive the patient`s data?</p>
                                            </div>
                                            <div class="modal-footer">
                                                <form action="{{ route('check-ups.destroy', $checkUp->id) }}" method="POST">
                                                    @csrf
                                                    @method("DELETE")
                                                    <button type="submit" class="btn btn-outline-danger">
                                                        Archive
                                                    </button>
                                                </form>
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        @endhasanyrole
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-center">
            {!! $checkUps->links() !!}
        </div>
    </div>
@endsection