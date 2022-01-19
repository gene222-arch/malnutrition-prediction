<?php

namespace App\Http\Controllers;

use App\Models\CheckUp;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {   
        $user = Auth::user();

        if ($user->hasRole(['Administrator', 'Barangay Nutrition Scholar'])) 
        {
            $monthlyCheckups = CheckUp::query()
                ->get()
                ->groupBy(fn ($val) => Carbon::parse($val->reserved_at)->format('m'))
                ->map(fn ($result) => $result->count());

            $checkUpsCount = CheckUp::count();
            $parentsCount = User::role('Parent')->count();
            $bnsCount = User::role('Barangay Nutrition Scholar')->count();

            if ($user->hasRole('Barangay Nutrition Scholar')) 
            {
                return view('pages.bns.dashboard', [
                    'monthlyCheckups' => $monthlyCheckups,
                    'checkUpsCount' => $checkUpsCount,
                    'parentsCount' => $parentsCount
                ]);
            }

            return view('pages.admin-dashboard', [
                'monthlyCheckups' => $monthlyCheckups,
                'checkUpsCount' => $checkUpsCount,
                'parentsCount' => $parentsCount,
                'bnsCount' => $bnsCount
            ]);
        }

        if ($user->hasRole('Parent')) 
        {
            return Redirect::back();
        }
    }
}
