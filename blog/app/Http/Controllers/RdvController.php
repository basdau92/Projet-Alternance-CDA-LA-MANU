<?php

namespace App\Http\Controllers;

use App\Models\Rdv;
use Illuminate\Http\Request;
use App\Mail\ExceptionOccured;
use App\Mail\RdvMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

class RdvController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Create a new RDV
     */
    public function createRdv(Request $request)
    {
        
        $this->validate($request, [
            'label' => 'required',
            'beginning' => 'required|date_format:d-m-Y H:i:s',
            'end' => 'required|date_format:d-m-Y H:i:s',
            'lastname' => 'required|string',
            'firstname' => 'required|string',
            'mail' => 'email|unique:rdv',
            'phone' => 'numeric',
            'is_visit' => 'required|boolean',
            'id_employee' => 'required'
        ]);

        try {

            $rdv = new Rdv();
            
            $rdv->id_employee = Auth::user()->id;
            
            $label = $rdv->id_label = $request->input('label');
            
            $beginning = $rdv->beginning = $request->input('beginning');
            
            $end = $rdv->end = $request->input('end');
            $description = $rdv->description = $request->input('description');
            $rdv->lastname = $request->input('lastname');
            $rdv->firstname = $request->input('firstname');
            $clientMail = $rdv->mail = $request->input('mail');
            $rdv->phone = $request->input('phone');
            $rdv->is_visit = $request->input('is_visit');
            $address = $rdv->address = $request->input('address');
            $city = $rdv->city = $request->input('city');
            $zipcode = $rdv->zipcode = $request->input('zipcode');

            $rdv->save();

            Mail::to($clientMail)->send(new RdvMail($label, $beginning, $end, $description, $address, $city, $zipcode));

            return response()->json(['rdv' => $rdv, 'message' => 'RDV CRÉE'], 201);
        } catch (\Exception $e) {
            $mail = Auth::user()->mail;
            Mail::to('inesbkht@gmail.com')->send(new ExceptionOccured($e->getMessage(), $mail));

            return response()->json(['message' => 'Conflict: La requête ne peut être traitée en l’état actuel.'], 409);
        }
    }
}
