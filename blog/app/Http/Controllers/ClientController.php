<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get one client.
     *
     * @param  int  $id
     * @return Response
     */
    public function singleClient($id)
    {
        try {
            $client = Client::findOrFail($id);

            return response()->json(['client' => $client], 200);

        } catch (\Exception $e) {

            return response()->json(['message' => 'client not found!'], 404);
        }
    }

    /**
     * Get all Client.
     *
     * @return Response
     */
    public function allClients()
    {
         return response()->json(['client' =>  Client::all()], 200);
    }

    /**
     * Update information Client
     *
     * @return Response
     */
    public function updateClient($id, Request $request)
    {
        try {
            $client = Client::findOrFail($id);
            $client->update($request->all());

            return response()->json($client, 200);

        } catch (\Exception $e) {

            return response()->json(['message' => 'client not found!'], 404);
        }
    }

    /**
     * Delete client account
     * 
     */
    public function deleteClient($id)
    {
        Client::findOrFail($id)->delete();
        return response('Deleted Successfully', 200);
    }

    public function showFavorites($id)
    {
        Client::findOrFail($id);
    }
}
