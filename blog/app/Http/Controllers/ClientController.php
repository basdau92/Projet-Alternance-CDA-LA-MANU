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
        $this->middleware('auth:api');
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

            return response()->json(['message' => 'Conflict: La requête ne peut être traitée en l’état actuel.'], 409);
        }
    }

    /**
     * Delete client account
     * 
     */
    public function deleteClient($id)
    {   
        try {
            Client::findOrFail($id)->delete();
            return response('Deleted Successfully', 200);

        } catch (\Exception $e) {

            return response()->json(['message' => 'Conflict: La requête ne peut être traitée en l’état actuel.'], 409);
        }
    }

    /**
     * Authorize the client to upload document
     *
     * @param Request $request
     * @return Response
     */
    public function uploadDocument(Request $request) 
    {
        $extensionArray = array('jpg', 'png', 'jpeg', 'pdf', 'doc', 'docx', 'odt'); // Authorized extension

        if ($request->hasFile('document')) {

            $file = $request->file('document');
            $filename = $file->hashName(); // Generate a unique, random name 
            $file_ext = $file->extension(); // Determine the file's extension based on the file's MIME type
            $document = time() . '.' . $filename ;
            $destination_path = storage_path('client');
                if (in_array(strtolower($file_ext), $extensionArray)) {
                $result = $request->file('document')->move($destination_path, $document);
                
                return $result;
                
                } else {
                    return $this->result['message'] = 'The extension\'s file isn\'t correct!';
                }

        } else {
            return $this->result['message'] = 'Cannot upload file';
        }
    }
}

