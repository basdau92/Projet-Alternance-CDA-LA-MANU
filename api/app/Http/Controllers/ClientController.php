<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use App\Mail\ExceptionOccured;
use App\Models\ClientDocument;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
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
        $this->middleware('auth:api-client');
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
            return response()->json(['client' => Auth::guard('api-client')->user()], 200);
        } catch (\Exception $e) {
            $mail = Auth::guard('api-client')->user()->mail;
            Mail::to('inesbkht@gmail.com')->send(new ExceptionOccured($e->getMessage(), $mail));

            return response()->json(['message' => 'Conflict: La requête ne peut être traitée en l’état actuel.'], 409);
        }
    }

    /**
     * Update information Client
     *
     * @return Response
     */
    public function updateClient(Request $request)
    {
        $client = Auth::guard('api-client')->user();
        //validate incoming request 
        $this->validate($request, [
            'lastname' => 'string',
            'firstname' => 'string',
            'mail' => [
                'email',
                Rule::unique('client')->ignore($client->id)
            ],
            'phone' => 'numeric',
        ]);

        try {
            $client->lastname = $request->input('lastname');
            $client->firstname = $request->input('firstname');
            $client->mail = $request->input('mail');
            $client->phone = $request->input('phone');

            // Update client to database
            $client->save();

            return response()->json(['message' => 'Le profil a bien été modifié.', 'client' => Auth::guard('api-client')->user()], 200);
        } catch (\Exception $e) {
            $mail = Auth::guard('api-client')->user()->mail;
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
                    'min:6',
                    'regex:/(?=.*[a-z])(?=.*[A-Z])(?=.*[\W_])(?=^.*[^\s].*$).*$/'
                ]
            ]
        );

        try {
            $client = Auth::guard('api-client')->user();
            $plainPassword = $request->input('password');
            $client->password = app('hash')->make($plainPassword);

            $client->save();

            return response()->json(['message' => 'Le mot de passe a bien été modifié.', 'client' => Auth::guard('api-client')->user()], 200);
        } catch (\Exception $e) {

            $mail = Auth::guard('api-client')->user()->mail;
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
        $clientId = Client::where('id', $id)->first();

        if ($clientId != null) {
            try {
                $clientId->delete();
                return response('Le client a bien été supprimé !', 200);
            } catch (\Exception $e) {
                $mail = Auth::guard('api-client')->user()->mail;
                Mail::to('inesbkht@gmail.com')->send(new ExceptionOccured($e->getMessage(), $mail));

                return response()->json(['message' => 'Conflict: La requête ne peut être traitée en l’état actuel.'], 409);
            }
        } else {
            return response()->json('Ce client n\'existe pas.');
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
    public function uploadFile(Request $request)
    {
        if (!$request->hasFile('document')) { // ensure the request has a file
            return response()->json('Aucun fichier n\'a été trouvé !', 404); // client side error, Bad Request
        }

        $files = $request->file('document'); // retrieve file from the request
        $id_client = $request->input('id_client');

        try {
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
                    $clientDocument->id_client = Auth::guard('api-client')->user()->id;
                    $clientDocument->name = $document;
                    $clientDocument->path = $destination_path;
                    $clientDocument->id_client = $id_client;
                    $clientDocument->save();

                    dd($clientDocument);
                } else {
                    return response()->json('L\'extension du fichier n\'est pas autorisée. Seules sont autorisées les jpg, png, jpeg, pdf, doc, docx, odt.', 403);
                }
            }
            $result = clientDocument::where('id_client', $id_client)->get();

            return response()->json(['document' => $result, 'message' => 'Le fichier a bien été téléchargé.'], 201);
        } catch (\Exception $e) {
            $mail = Auth::guard('api-client')->user()->mail;
            Mail::to('inesbkht@gmail.com')->send(new ExceptionOccured($e->getMessage(), $mail));

            return response()->json(['message' => 'Conflict: La requête ne peut être traitée en l’état actuel.', 'error' => $e->getMessage()], 409);
        }
    }

    /**
     * Retrieve all the documents of logged in client
     * 
     * @param Request $request
     * @return Response
     */
    public function readFile(Request $request)
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
            $mail = Auth::guard('api-client')->user()->mail;
            Mail::to('inesbkht@gmail.com')->send(new ExceptionOccured($e->getMessage(), $mail));

            return response()->json(['message' => 'Conflict: La requête ne peut être traitée en l’état actuel.', 'error' => $e->getMessage()], 409);
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
            $mail = Auth::guard('api-client')->user()->mail;
            Mail::to('inesbkht@gmail.com')->send(new ExceptionOccured($e->getMessage(), $mail));

            return response()->json(['message' => 'Conflict: La requête ne peut être traitée en l’état actuel.'], 409);
        }
    }
}
