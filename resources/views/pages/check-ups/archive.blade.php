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
        <div class="card p-4">
            <div class="card-content">
                <h5>Archived Patients</h5>
            </div>
        </div>
        <table class="table table-striped mb-5 rounded">
            <thead>
                <tr class="table-info">
                    <th scope="col">Name</th>
                    <th scope="col">Age</th>
                    <th scope="col">Date of Reservation</th>
                    <th scope="col">Date of Visit</th>
                    <th scope="col">Status</th>
                    @hasanyrole('Administrator|Barangay Nutrition Scholar')
                        <th scope="col">Action</th>
                    @endhasanyrole
                </tr>
            </thead>
            <tbody>
                @foreach($archivedCheckUps as $archive)
                    <tr>
                        @hasanyrole('Administrator|Barangay Nutrition Scholar')
                            <td>
                                {{ $archive->patient_name }}
                            </td>
                        @endhasanyrole
                        @hasrole('Parent')
                            <td>
                                <a href="{{ route('check-ups.show', $archive->id) }}">
                                    {{ $archive->patient_name }}
                                </a>
                            </td>
                        @endhasrole
                        <td>{{ $archive->age }}</td>
                        <td>{{ $archive->reserved_at }}</td>
                        <td>{{ $archive->visited_at }}</td>
                        <td>
                            <span 
                                @class([
                                    "badge",
                                    "badge-success" => !$archive->result->is_malnourished,
                                    "badge-danger" => $archive->result->is_malnourished
                                ])
                            >
                                {{ $archive->result->is_malnourished ? "Malnourished" : "Healthy" }}
                            </span>
                        </td>
                        @hasanyrole('Administrator|Barangay Nutrition Scholar')
                            <td>
                                <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#exampleModal{{ $archive->id }}">
                                    <i class="fas fa-trash-restore"></i>
                                </button>
                                <div class="modal fade" id="exampleModal{{ $archive->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Name: <strong class="text-secondary">{{ $archive->patient_name }}</strong></h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Are you sure to restore the patient`s data?</p>
                                            </div>
                                            <div class="modal-footer">
                                                <form action="{{ route('check.ups.restore', $archive->id) }}" method="POST">
                                                    @csrf
                                                    @method("POST")
                                                    <button type="submit" class="btn btn-outline-success">
                                                        Restore
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
            {!! $archivedCheckUps->links() !!}
        </div>
    </div>
@endsection