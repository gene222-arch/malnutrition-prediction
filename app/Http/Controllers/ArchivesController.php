<?php

namespace App\Http\Controllers;

use App\Models\CheckUp;
use Illuminate\Http\Request;

class ArchivesController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $archivedCheckUps = CheckUp::onlyTrashed()
            ->with('details')
            ->orderByDesc('created_at')
            ->paginate(10);
        
        return view('pages.check-ups.archive', [
            'archivedCheckUps' => $archivedCheckUps
        ]);
    }
}
