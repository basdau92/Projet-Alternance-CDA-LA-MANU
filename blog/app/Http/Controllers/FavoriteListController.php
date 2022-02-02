<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Support\Facades\Auth;

class FavoriteListController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Get the FavoriteList 
     */
    public function showFavoriteList()
    {   
        $favoriteList = new Property();
        
        try {
            $favoriteList->belongsToFavoriteList()
                     ->where(Auth::userOrFail()->id)
                     ->get();
            return response()->json(['favorite_list' => $favoriteList], 200);

        } catch (\Exception $e) {

            return response()->json(['message' => 'list not found!','error'=>$e->getMessage()], 404);
        }
    }
}
