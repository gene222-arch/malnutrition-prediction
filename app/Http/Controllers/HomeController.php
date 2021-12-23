<?php

namespace App\Http\Controllers;

use App\Models\CheckUp;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        if ($user->hasRole('Administrator')) 
        {
            $monthlyCheckups = CheckUp::query()
                ->get()
                ->groupBy(fn ($val) => Carbon::parse($val->reserved_at)->format('m'))
                ->map(fn ($result) => $result->count());

            $checkUpsCount = CheckUp::count();
            $parentsCount = User::role('Parent')->count();
            $bnsCount = User::role('Barangay Nutrition Scholar')->count();

            return view('pages.admin-dashboard', [
                'monthlyCheckups' => $monthlyCheckups,
                'checkUpsCount' => $checkUpsCount,
                'parentsCount' => $parentsCount,
                'bnsCount' => $bnsCount
            ]);
        }

        return view('pages.dashboard');
    }
}
