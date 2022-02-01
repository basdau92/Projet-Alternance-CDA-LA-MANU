<?php

namespace App\Http\Controllers;

use App\Models\Client;

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
}
