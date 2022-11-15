<?php

namespace App\Http\Controllers;

use App\Models\FavoriteList;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class FavoriteListController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api-client');
    }

    /**
     * Get the FavoriteList 
     */
    public function showFavoriteList()
    {
        try {

            $favoriteList = FavoriteList::with(['favoriteList'])
                ->where('id_client', Auth::guard('api-client')->user()->id)
                ->get();
            return response()->json(['favorite_list' => $favoriteList], 200);
        } catch (\Exception $e) {

            return response()->json(['message' => 'Conflict: La requête ne peut être traitée en l’état actuel.', 'error' => $e->getMessage()], 409);
        }
    }

    /**
     * Insert FavoriteList 
     */
    public function createFavoriteList(Request $request)
    {
        $this->validate($request, [
            'id_property' => 'unique:favorite_list'
        ]);
        try {
            $favoriteList = new FavoriteList();
            $favoriteList->id_client = Auth::guard('api-client')->user()->id;
            $favoriteList->id_property = $request->input('id_property');
            $favoriteList->save();

            return response()->json(['message' => 'Votre liste de favoris a bien été créée.'], 201);
        } catch (\Exception $e) {

            return response()->json(['message' => 'Conflict: La requête ne peut être traitée en l’état actuel.', 'error' => $e->getMessage()], 409);
        }
    }

    /**
     * Delete favorites
     * 
     */
    public function deleteFavoriteList($id)
    {
        try {
            FavoriteList::findOrFail($id)->delete();
            return response('Le bien immobilier a bien été supprimé de votre liste de favoris.', 200);
        } catch (\Exception $e) {

            return response()->json(['message' => 'Conflict: La requête ne peut être traitée en l’état actuel.', 'error' => $e->getMessage()], 409);
        }
    }
}
