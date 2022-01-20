@extends('layouts.dashboard')

@section('content')
    <form action="{{ route('food-recommendation.index') }}" method="get">
        @csrf
        <header class="lead">
            Category
        </header>
        <div class="row justify-content-center">
            @foreach ([
                'Fruits',
                'Vegetables',
                'Meat',
                'Fish'
            ] as $category)
                <div class="col-12 col-sm-4 mb-3">
                    <div class="card border-info">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <p class="lead">{{ $category }}</p>
                                </div>
                                <div class="col text-right">
                                    <button 
                                        type="submit" 
                                        @class([
                                            'btn',
                                            'btn-category',
                                            'btn-outline-info' => isset($selectedCategory) && $selectedCategory !== Str::lower($category),
                                            'btn-info' => isset($selectedCategory) && $selectedCategory === Str::lower($category)
                                        ])
                                        name="category" 
                                        value="{{ Str::lower($category) }}"
                                    >
                                        Select
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </form>

    @isset ($selectedCategory)
        @isset($nutrients)
            <div class="row">
                <div class="col-12 mb-3">
                    <select class="form-select" aria-label="Default select example" id="select-nutrient" required>
                        <option selected>Select Nutrient</option>
                        @foreach ($nutrients as $nutrient)
                            <option value="{{ Str::of($nutrient)->lower()->snake() }}">{{ $nutrient }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 mb-3">
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1">%</span>
                        <input type="text" class="form-control bg-secondary text-white input-percentage" aria-describedby="basic-addon1" required>
                    </div>
                </div>
            </div>
            <div class="col text-right">
                <button class="btn btn-success btn-submit">Submit</button>
            </div>
            <div class="col-12 col-sm-6 col-md-4 col-lg-4 recommendation">
            </div>
        @endisset
    @endisset
@endsection

@section('js')
    <script src="{{ asset('js/randomForest.js') }}" type="module"></script>
@endsection