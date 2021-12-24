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
                <a href="{{ route('brgy-nutrition-scholars.create') }}">
                    <i class="fas fa-plus fa-3x p-4 text-success"></i>
                </a>
            </div>
        @endhasrole
        <table class="table table-bordered mb-5">
            <thead>
                <tr class="table-info">
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($brgyNutritionSchs as $brgyNutritionSch)
                <tr>
                    <th scope="row">{{ $brgyNutritionSch->id }}</th>
                    <td>
                        <a href="{{ route('brgy-nutrition-scholars.edit', $brgyNutritionSch->id) }}">{{ $brgyNutritionSch->name }}</a>
                    </td>
                    <td>{{ $brgyNutritionSch->email }}</td>
                    @hasanyrole('Administrator')
                        <td>
                            <form action="{{ route('brgy-nutrition-scholars.destroy', $brgyNutritionSch->id) }}" method="POST">
                                @csrf
                                @method("DELETE")
                                <button type="submit" class="btn btn-outline-danger">
                                    <i class="fas fa-user-minus"></i>
                                </button>
                            </form>
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