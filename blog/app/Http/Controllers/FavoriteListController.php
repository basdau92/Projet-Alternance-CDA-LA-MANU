<?php

namespace App\Http\Controllers;

use App\Models\FavoriteList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteListController extends Controller
{
    /**
     * Get the FavoriteList 
     */
    public function showFavoriteList()
    {   
        $favorite = new FavoriteList();
        
        try {
            $favorite->hasManyProperties()
                     ->where(Auth::userOrFail()->id)
                     ->get();
            return response()->json(['favorite_list' => $favorite], 200);

        } catch (\Exception $e) {

            return response()->json(['message' => 'list not found!'], 404);
        }
    }
}
