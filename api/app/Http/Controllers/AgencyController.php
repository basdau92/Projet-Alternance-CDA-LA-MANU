<?php

namespace App\Http\Controllers;

use App\Models\Agency;

class AgencyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function getAgencies()
    {
        try {
            return response()->json(['agency' =>  Agency::all()], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Aucune agence n\'a été trouvé.'], 404);
        }
    }
}
