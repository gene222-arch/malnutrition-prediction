<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\CheckUp;
use Illuminate\Support\Facades\DB;
use App\Models\MalnutritionSymptom;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\CheckUp\StoreRequest;
use App\Http\Requests\CheckUp\UpdateRequest;
use App\Models\User;
use App\Services\BMIComputerServices;
use App\Services\CheckUpService;
use App\Services\FoodRecommendationService;
use Illuminate\Support\Facades\Auth;

class CheckUpsController extends Controller
{

    public function __construct()
    {
        $this->middleware('role:Administrator|Barangay Nutrition Scholar')
            ->except([
                'index',
                'show'
            ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $checkUps = CheckUp::with('details')->orderByDesc('created_at')->paginate(10);

        if (Auth::user()->hasRole('Parent')) 
        {
            $checkUps = CheckUp::query()
                ->where('parent_id', Auth::user()->id)
                ->with('details')
                ->orderByDesc('created_at')
                ->paginate(10);
        }

        return view('pages.check-ups.index', [
            'checkUps' => $checkUps
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $malnutritionSymptoms = MalnutritionSymptom::all();
        
        $malnutritionSymptoms = $malnutritionSymptoms
            ->mapToGroups(function ($item, $key) {
                return [$item['type'] => [$item['id'] => $item['name']]];
            })
            ->all();

        return view('pages.check-ups.create', [
            'malnutritionSymptoms' => $malnutritionSymptoms,
            'parents' => User::role('Parent')->get(['id', 'name'])
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\CheckUp\StoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request, CheckUpService $service)
    {
        try {
                DB::transaction(function () use ($request, $service) {
                    $malnutritionSymptomIds = $request
                    ->collect('malnutrition_symptom_ids')
                    ->map(fn ($id) => [ 'malnutrition_symptom_id' => $id ]);
                    
                $heightInInches = ($request->height_in_cm * 0.393701);
                $weightInPounds = ($request->weight_in_kg * 2.20462);
                $bmi = BMIComputerServices::compute($weightInPounds, $heightInInches);
        
                $checkUp = CheckUp::create($request->validated() + [
                    'reserved_at' => Carbon::parse($request->reserved_at),
                    'height_in_inches' => $heightInInches,
                    'weight_in_pounds' => $weightInPounds
                ]);
        
                $checkUp->progress()->create([ 'symptom_count' => $malnutritionSymptomIds->count() ]);
                $checkUp->details()->createMany($malnutritionSymptomIds);
                    
                $checkUp
                    ->result()
                    ->create([
                        'bmi' => $bmi,
                        'result' => BMIComputerServices::interpret($bmi),
                        'is_malnourished' => $service->isMalnourished($request->malnutrition_symptom_ids)
                    ]);
            });
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }

        return Redirect::route('check-ups.index')->with([
            'successMessage' => 'Check up created successfully'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CheckUp  $checkUp
     * @param  \App\Services\FoodRecommendationService  $service
     * @return \Illuminate\Http\Response
     */
    public function show(CheckUp $checkUp, FoodRecommendationService $service)
    {
        $checkUp = CheckUp::with(['details.symptom', 'result'])->find($checkUp->id);
        $progress = $checkUp->progress->map->symptom_count;
        $foodRecommendations = $service->viaAge($checkUp->age);
        
        return view('pages.check-ups.show', [
            'checkUp' => $checkUp,
            'progress' => $progress,
            'foodRecommendations' => $foodRecommendations
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CheckUp  $checkUp
     * @return \Illuminate\Http\Response
     */
    public function edit(CheckUp $checkUp)
    {
        $malnutritionSymptoms = MalnutritionSymptom::all();
        
        $malnutritionSymptoms = $malnutritionSymptoms
            ->mapToGroups(function ($item, $key) {
                return [$item['type'] => [$item['id'] => $item['name']]];
            })
            ->all();

        return view('pages.check-ups.edit', [
            'checkUp' => $checkUp,
            'malnutritionSymptoms' => $malnutritionSymptoms,
            'parents' => User::role('Parent')->get(['id', 'name'])
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\CheckUp\UpdateRequest  $request
     * @param  \App\Models\CheckUp  $checkUp
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, CheckUp  $checkUp, CheckUpService $service)
    {
        $malnutritionSymptomIds = $request
            ->collect('malnutrition_symptom_ids')
            ->map(fn ($id) => [ 'malnutrition_symptom_id' => $id ]);
            
        $heightInInches = ($request->height_in_cm * 0.393701);
        $weightInPounds = ($request->weight_in_kg * 2.20462);
        $bmi = BMIComputerServices::compute($weightInPounds, $heightInInches);

        $checkUp->update($request->validated() + [
            'height_in_inches' => $heightInInches,
            'weight_in_pounds' => $weightInPounds
        ]);
        $checkUp->progress()->create([ 'symptom_count' => $malnutritionSymptomIds->count() ]);
        $checkUp->details()->delete();
        $checkUp->details()->createMany($malnutritionSymptomIds);
        $checkUp->result()->update([
            'bmi' => $bmi,
            'result' => BMIComputerServices::interpret($bmi),
            'is_malnourished' => $service->isMalnourished($request->malnutrition_symptom_ids)
        ]);

        return Redirect::route('check-ups.index')->with([
            'successMessage' => 'Check up updated successfully'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CheckUp  $checkUp
     * @return \Illuminate\Http\Response
     */
    public function destroy(CheckUp $checkUp)
    {
        $checkUp->delete();

        return redirect()->back()->with([
            'successMessage' => 'Patient data deleted successfully'
        ]);
    }

    public function restore(int $id)
    {
        CheckUp::withTrashed()
            ->find($id)
            ->restore();

        return redirect()->back()->with([
            'successMessage' => 'Patient data restored successfully'
        ]);
    }
}
