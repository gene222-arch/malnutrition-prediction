<?php

namespace App\Http\Controllers;

use App\Services\FoodRecommendationService;
use Illuminate\Http\Request;

class FoodRecommendationsController extends Controller
{

    public function index(Request $request, FoodRecommendationService $service)
    {
        return $service->index($request);
    }
}
