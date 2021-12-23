<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\CheckUp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\MalnutritionSymptom;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\CheckUp\StoreRequest;
use App\Http\Requests\CheckUp\UpdateRequest;

class CheckUpsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $checkUps = CheckUp::with('details')->paginate(10);

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
            'malnutritionSymptoms' => $malnutritionSymptoms
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\CheckUp\StoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        $malnutritionSymptomIds = $request
            ->collect('malnutrition_symptom_ids')
            ->map(fn ($id) => [ 'malnutrition_symptom_id' => $id ]);

        $checkUp = CheckUp::create($request->validated() + [
            'reserved_at' => Carbon::parse($request->reserved_at)
        ]);
        $checkUp->details()->createMany($malnutritionSymptomIds);

        return Redirect::route('check-ups.index')->with([
            'messageOnSuccess' => 'Check up created successfully'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CheckUp  $checkUp
     * @return \Illuminate\Http\Response
     */
    public function show(CheckUp $checkUp)
    {
        return $checkUp;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CheckUp  $checkUp
     * @return \Illuminate\Http\Response
     */
    public function edit(CheckUp $checkUp)
    {
        return view('pages.check-ups.edit', [
            'checkUp' => $checkUp
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\CheckUp\UpdateRequest  $request
     * @param  \App\Models\CheckUp  $checkUp
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, CheckUp  $checkUp)
    {
        $checkUp->update($request->validated());

        return redirect()->back()->with([
            'messageOnSuccess' => 'Check up updated successfully'
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
        $checkUp->details()->delete();
        $checkUp->result()?->delete();
        $checkUp->delete();

        return redirect()->back()->with([
            'message' => 'Patient data deleted successfully'
        ]);
    }
}
