<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use App\Models\ClientDocument;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Symfony\Component\HttpFoundation\Response;

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
            return response('La ressource a bien été supprimé !', 200);
        } catch (\Exception $e) {

            return response()->json(['message' => 'Conflict: La requête ne peut être traitée en l’état actuel.'], 409);
        }
    }

    /**
     * Authorize the client to upload document and store them in DB
     * 
     * still need to define the max size of the file
     *
     * @param Request $request
     * @return Response
     */
    public function uploadDocument(Request $request)
    {
        try {

            ($request->hasFile('document')); // ensure the request has a file

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
                $clientDocument->name = $filename;
                $clientDocument->path = $destination_path;
                $clientDocument->save();

                return response()->json(['client_document' => $clientDocument, 'message' => 'Le fichier a bien été uploadé !'], 201);
            } else {
                return response()->json('L\'extension du fichier n\'est pas autorisée!', 403);
            }
        } catch (\Exception $e) {

            return response()->json(['message' => 'Le fichier ne peut pas être uploadé !', 'error' => $e->getMessage()], 409);
        }
    }

    public function readDocument()
    {
        try {
            $clientDocument = new ClientDocument();
            $clientDocument->id_client = Auth::userOrFail()->id;

            $directory = storage_path('client'); // fetch of the storage folder
            $data = $clientDocument->path = $directory;

            $files = File::files($data); // retrieving files 
            foreach ($files as $file) {
                $content = $file->getContents();
            }

            $encode = base64_encode($content); // encoding content of the file into string 

            return response()->json(['document' => $encode], 200);
        } catch (\Exception $e) {

            return response()->json(['message' => 'Le fichier n\'a pas été trouvé !', 'error' => $e->getMessage()], 404);
        }
    }

    public function readSingleDocument()
    {
        try {
            $document = ClientDocument::with((['showDocument']))
                ->where('id_client', Auth::userOrFail()->id)
                ->get();
            return response()->json(['document' => $document], 200);
        } catch (\Exception $e) {

            return response()->json(['message' => 'Le document n\'a pas été trouvé!', 'error' => $e->getMessage()], 404);
        }
    }

    /**
     * Authorize delete of documents
     *
     * @param [type] $id
     * @return void
     */
    public function deleteDocument($id)
    {
        try {
            ClientDocument::findOrFail($id)->delete();
            return response('La ressource a bien été supprimé !', 200);
        } catch (\Exception $e) {

            return response()->json(['message' => 'Conflict: La requête ne peut être traitée en l’état actuel.'], 409);
        }
    }
}
