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
        @hasrole('Administrator')
            <div class="card mb-2 rounded">
                <a href="{{ route('brgy-nutrition-scholars.create') }}" title="Add new BNS">
                    <i class="fas fa-plus fa-3x p-4 text-success"></i>
                </a>
            </div>
        @endhasrole
        <table class="table table-bordered mb-5">
            <thead>
                <tr class="table-info">
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($brgyNutritionSchs as $brgyNutritionSch)
                <tr>
                    <td>
                        <a title="View more details" href="{{ route('brgy-nutrition-scholars.edit', $brgyNutritionSch->id) }}">{{ $brgyNutritionSch->name }}</a>
                    </td>
                    <td>{{ $brgyNutritionSch->email }}</td>
                    @hasanyrole('Administrator')
                    <td>
                        <button type="button" class="btn btn-outline-danger" data-toggle="modal" data-target="#exampleModal{{ $brgyNutritionSch->id }}">
                            <i class="fas fa-user-minus"></i>
                        </button>
                        <div class="modal fade" id="exampleModal{{ $brgyNutritionSch->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Name: <strong class="text-secondary">{{ $brgyNutritionSch->name }}</strong></h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Are you sure to delete?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <form action="{{ route('brgy-nutrition-scholars.destroy', $brgyNutritionSch->id) }}" method="POST">
                                            @csrf
                                            @method("DELETE")
                                            <button type="submit" class="btn btn-outline-danger">
                                                Delete
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
            {!! $brgyNutritionSchs->links() !!}
        </div>
    </div>
@endsection