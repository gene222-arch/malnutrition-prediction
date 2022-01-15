<?php 

namespace App\Services;

use Illuminate\Http\Request;

class FoodRecommendationService
{
    public function index(Request $request)
    {
        if ($request->has('category') && $request->filled('category')) 
        {
            $nutrients = match($request->input('category')) {
                'fruits' => [
                    'Potassium',
                    'Vitamin C',
                    'Zinc',
                    'Iron',
                    'Sodium'
                ],
                'vegetables' => [
                    'Potassium',
                    'Fiber',
                    'Vitamin A',
                    'Vitamin C',
                    'Foliate'
                ],
                'meat' => [
                    'Protein',
                    'Vitamin B6',
                    'Fat',
                    'Riboflovamin',
                    'Vitamin B12',
                ],
                'fish' => [
                    'Calcium',
                    'Protein',
                    'Vitamin D',
                    'Iron'
                ]
            };

            return view('pages.food-recommendation', [
                'selectedCategory' => $request->input('category'),
                'nutrients' => $nutrients
            ]);
        }

        return view('pages.food-recommendation');
    }
}