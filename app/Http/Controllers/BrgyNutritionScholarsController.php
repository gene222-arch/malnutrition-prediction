<?php

namespace App\Http\Controllers;

use App\Http\Requests\BNS\StoreRequest;
use App\Http\Requests\BNS\UpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class BrgyNutritionScholarsController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:Administrator')->except('index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $brgyNutritionSchs = User::role('Barangay Nutrition Scholar')->paginate(10);

        return view('pages.bns.index', [
            'brgyNutritionSchs' => $brgyNutritionSchs
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.bns.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\BNS\StoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        $data = Arr::collapse([$request->validated(), [
            'password' => Hash::make($request->password)
        ]]);

        $bns = User::create($data);

        $bns->assignRole('Barangay Nutrition Scholar');

        return Redirect::route('brgy-nutrition-scholars.index')
            ->with([
                'successMessage' => 'Barangay Nutrition Scholar created successfully'
            ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $bns = User::find($id);

        return view('pages.bns.edit', [
            'bns' => $bns
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\BNS\UpdateRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, $id)
    {
        $bns = User::find($id);

        $data = Arr::collapse([$request->validated(), [
            'password' => Hash::make($request->password)
        ]]);

        $bns->update($data);

        return Redirect::route('brgy-nutrition-scholars.index')
            ->with([
                'successMessage' => 'Barangay Nutrition Scholar updated successfully'
            ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();

        return Redirect::route('brgy-nutrition-scholars.index')
            ->with([
                'successMessage' => 'Barangay Nutrition Scholar deleted successfully'
            ]);
    }
}
