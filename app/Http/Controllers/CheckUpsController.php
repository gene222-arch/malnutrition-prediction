<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckUp\StoreRequest;
use App\Http\Requests\CheckUp\UpdateRequest;
use App\Models\CheckUp;
use Illuminate\Http\Request;

class CheckUpsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $checkUps = CheckUp::with('details', 'result')->get();

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
        return view('pages.check-ups.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\CheckUp\StoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        CheckUp::create($request->validated());

        return redirect()->back()->with([
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
    public function destroy(CheckUp  $checkUp)
    {
        $checkUp->delete();

        return view('pages.check-ups.index');
    }
}