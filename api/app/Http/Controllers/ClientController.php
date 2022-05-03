<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use App\Models\ClientDocument;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpFoundation\Response;
use App\Mail\ExceptionOccured;

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
     * Get one client by id 
     *
     * @param  int  $id
     * @return Response
     */
    public function singleClient()
    {
        try {
            return response()->json(['client' => Auth::user()], 200);
        } catch (\Exception $e) {
            $mail = Auth::user()->mail;
            Mail::to('inesbkht@gmail.com')->send(new ExceptionOccured($e->getMessage(), $mail));

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
    public function updateClient(Request $request)
    {
        //validate incoming request 
        $this->validate($request, [
            'lastname' => 'string|required',
            'firstname' => 'string|required',
            'mail' => 'email|unique:client|required',
            'phone' => 'numeric|required',
        ]);

        try {
            $client = Auth::user();
            $client->lastname = $request->input('lastname');
            $client->firstname = $request->input('firstname');
            $client->mail = $request->input('mail');
            $client->phone = $request->input('phone');

            // Update client to database
            $client->save();

            return response()->json(['message' => 'Le profil a bien été modifié.', 'client' => Auth::user()], 200);
        } catch (\Exception $e) {
            $mail = Auth::user()->mail;
            Mail::to('inesbkht@gmail.com')->send(new ExceptionOccured($e->getMessage(), $mail));

            return response()->json(['message' => 'Conflict: La requête ne peut être traitée en l’état actuel.', 'error' => $e->getMessage()], 409);
        }
    }

    public function updatePassword(Request $request)
    {
        $this->validate(
            $request,
            [
                'password' => [
                    'required',
                    'min:6',
                    'regex:/^(?=.{6,}$)(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).*$/'
                ]
            ]
        );

        try {
            $client = Auth::user();
            $plainPassword = $request->input('password');
            $client->password = app('hash')->make($plainPassword);

            $client->save();

            return response()->json(['message' => 'Le mot de passe a bien été modifié.', 'client' => Auth::user()], 200);
        } catch (\Exception $e) {

            $mail = Auth::user()->mail;
            Mail::to('inesbkht@gmail.com')->send(new ExceptionOccured($e->getMessage(), $mail));

            return response()->json(['message' => 'Conflict: La requête ne peut être traitée en l’état actuel.', 'error' => $e->getMessage()], 409);
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
            $mail = Auth::user()->mail;
            Mail::to('inesbkht@gmail.com')->send(new ExceptionOccured($e->getMessage(), $mail));

            return response()->json(['message' => 'Conflict: La requête ne peut être traitée en l’état actuel.'], 409);
        }
    }

    /**
     * Authorize the client to upload documents and store them in DB
     * 
     * still need to define the max size of the file
     *
     * @param Request $request
     * @return Response
     */
    public function upload(Request $request)
    {
        if (!$request->hasFile('document')) { // ensure the request has a file
            return response()->json('Aucun fichier n\'a été trouvé !', 400); // client side error, Bad Request
        }

        try {
            $files = $request->file('document'); // retrieve file from the request
            $id_client = $request->input('id_client');

            foreach ($files as $file) {
                $extensionArray = ['jpg', 'png', 'jpeg', 'pdf', 'doc', 'docx', 'odt']; // Authorized extension
                $filename = $file->hashName(); // Generate a unique, random name 
                $file_ext = $file->extension(); // Determine the file's extension based on the file's MIME type
                $document =  time() . '-' . $filename; //add timestamp to the filename

                $destination_path = storage_path('client');
                $check = in_array(strtolower($file_ext), $extensionArray);

                if ($check) {
                    $file->move($destination_path, $document); // move the file to storage/client

                    $clientDocument = new ClientDocument();
                    $clientDocument->id_client = Auth::userOrFail()->id;
                    $clientDocument->name = $document;
                    $clientDocument->path = $destination_path;
                    $clientDocument->id_client = $id_client;
                    $clientDocument->save();
                } else {
                    return response()->json('L\'extension du fichier n\'est pas autorisée!', 403);
                }
            }
            $result = clientDocument::where('id_client', $id_client)->get();

            return response()->json(['document' => $result, 'message' => 'File uploaded !'], 201);
        } catch (\Exception $e) {
            $mail = Auth::user()->mail;
            Mail::to('inesbkht@gmail.com')->send(new ExceptionOccured($e->getMessage(), $mail));

            return response()->json(['message' => 'Le fichier ne peut pas être uploadé!', 'error' => $e->getMessage()], 409);
        }
    }

    /**
     * Retrieve all the documents of logged in client
     * 
     * @param Request $request
     * @return Response
     */
    public function readFiles(Request $request)
    {
        if (!$request->hasFile('document')) { // ensure the request has a file
            return response()->json('Aucun fichier n\'a été trouvé !', 400); // client side error, Bad Request
        }

        try {
            $document = ClientDocument::with((['showDocument']))
                ->where('id_client', Auth::userOrFail()->id)
                ->get();
            $directory = storage_path('client'); // fetch of the storage folder
            $data = $document->path = $directory;
            $files = File::files($data); // retrieving files 

            foreach ($files as $file) {
                $content = $file->getContents();
            }

            $encode = base64_encode($content); // encoding content of the file into string 
            return response()->json(['document' => $encode], 200);
        } catch (\Exception $e) {
            $mail = Auth::user()->mail;
            Mail::to('inesbkht@gmail.com')->send(new ExceptionOccured($e->getMessage(), $mail));

            return response()->json(['message' => 'Aucun fichier n\'a été trouvé !', 'error' => $e->getMessage()], 404);
        }
    }

    /**
     * Update uploaded document
     * 
     * WASN'T ABLE TO TEST ON POSTMAN 
     * 
     * @param Request $request
     * @return Response
     */
    public function updateFile(Request $request, $id)
    {
        $clientDocument = ClientDocument::find($id);
        $updatedFile = $request->file('document');

        if ($request->hasFile('document')) {
            $destination_path = storage_path('client');
            $filename = md5(uniqid(rand(), true)) . str_replace(' ', '-', $updatedFile->getClientOriginalName());
            $updatedFile->move($destination_path, $filename);
            $existFile = $clientDocument['document'];
            $update['document'] = $destination_path . '/' . $filename;
        }

        $clientDocument->update($updatedFile);

        if (isset($existFile) && file_exists($existFile)) {
            unlink($existFile);
        }
    }

    /**
     * Authorize delete of documents
     *
     * @param [type] $id
     * @return void
     */
    public function deleteFile($id)
    {
        try {

            ClientDocument::findOrFail($id)->delete();
            return response('La ressource a bien été supprimé !', 200);
        } catch (\Exception $e) {
            // $e = FlattenException::createFromThrowable($exception);
            // $handler = new HtmlErrorRenderer(true);
            // $content = $handler->getBody($e);
            // Mail::to('inesbkht@gmail.com')->send(new ExceptionOccured($content));
            $mail = Auth::user()->mail;
            Mail::to('inesbkht@gmail.com')->send(new ExceptionOccured($e->getMessage(), $mail));

            return response()->json(['message' => 'Conflict: La requête ne peut être traitée en l’état actuel.'], 409);
        }
    }
}
