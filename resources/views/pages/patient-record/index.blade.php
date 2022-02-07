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
        @hasrole('Administrator|Barangay Nutrition Scholar')
            <div class="card mb-2 rounded">
                <a href="{{ route('patient-records.create') }}" title="Add new BNS">
                    <i class="fas fa-plus fa-3x p-4 text-success"></i>
                </a>
            </div>
        @endhasrole
        <table class="table table-bordered mb-5">
            <thead>
                <tr class="table-info">
                    <th scope="col">Patient</th>
                    <th scope="col">Latest Note</th>
                </tr>
            </thead>
            <tbody>
                @foreach($patientRecords as $record)
                    <tr>
                        <td>
                            <a class="" data-toggle="collapse" href="#collapseExample{{ $record->id }}" role="button" aria-expanded="false" aria-controls="collapseExample">
                                {{ $record->parent->name }}
                            </a>
                        </td>
                        <td>
                            {{ $record->notes->last()->body }}
                            <div class="collapse" id="collapseExample{{ $record->id }}">
                                @foreach ($record->notes as $note)
                                    <div class="card-body">
                                        @if (Auth::user()->hasRole('Parent'))
                                            <p class="text-secondary">{{ $note->body }}</p>
                                        @else
                                            <a href="/patient-records/{{ $record->id }}/edit?noteId={{ $note->id }}">
                                                <p>{{ $note->body }}</p>
                                            </a>
                                        @endif
                                    </div>
                                @endforeach
                            </div>  
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-center">
            {!! $patientRecords->links() !!}
        </div>
    </div>
@endsection