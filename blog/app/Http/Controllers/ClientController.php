<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\ClientDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

            return response()->json(['message' => 'Le client n\'a pas été trouvé!'], 404);
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
     * Authorize the client to upload document and store them in DB
     *
     * @param Request $request
     * @return Response
     */
    public function uploadDocument(Request $request)
    {
        try {
            // ensure the request has a file
            if ($request->hasFile('document')) {

                $extensionArray = array('jpg', 'png', 'jpeg', 'pdf', 'doc', 'docx', 'odt'); // Authorized extension
                $file = $request->file('document'); // Retrieve file from the request
                $filename = $file->hashName(); // Generate a unique, random name 
                $file_ext = $file->extension(); // Determine the file's extension based on the file's MIME type
                $document = time() . '.' . $filename;
                $destination_path = storage_path('client'); // Save the file locally in the storage/client folder

                if (in_array(strtolower($file_ext), $extensionArray)) {

                    $clientDocument = new ClientDocument();
                    $clientDocument->id_client = Auth::userOrFail()->id;

                    $request->file('document')->move($destination_path, $document); // move the file to storage/client
                    $clientDocument->path = $destination_path;
                    $clientDocument->save();

                    return response()->json(['client_document' => $clientDocument, 'message' => 'File uploaded !'], 201);
                } else {
                    return $this->result['message'] = 'L\'extension du fichier n\'est pas autorisée!';
                }
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Le fichier ne peut pas être uploadé!', 'error' => $e->getMessage()], 409);
        }
    }
}
