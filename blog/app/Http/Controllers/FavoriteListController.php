<?php

namespace App\Http\Controllers;

use App\Models\FavoriteList;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

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
        try {

            $favoriteList = FavoriteList::with(['favoriteList'])
                                        ->where('id_client', Auth::userOrFail()->id)
                                        ->get();
            return response()->json(['favorite_list' => $favoriteList], 200);

        } catch (\Exception $e) {

            return response()->json(['message' => 'La liste de favoris n\'a pas été trouvé!','error'=>$e->getMessage()], 404);
        }
    }

    /**
     * Insert FavoriteList 
     */
    public function createFavoriteList(Request $request)
    {   
        $this->validate($request, [
            'id_property' => 'required|numeric',
        ]);

        try {
            $favoriteList = new FavoriteList();
            

            $favoriteList->id_client = Auth::userOrFail()->id;
            $favoriteList->id_property = $request->input('id_property');
            $favoriteList->save();

            return response()->json(['favorite_list' => true], 200);

        } catch (\Exception $e) {

            return response()->json(['message' => 'Echec d\'ajout de favoris','error'=>$e->getMessage()], 404);
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
            return response('La ressource a bien été supprimé !', 200);
        } catch (\Exception $e) {

            return response()->json(['message' => 'Conflict: La requête ne peut être traitée en l’état actuel.'], 409);
        }
    }

    
}
