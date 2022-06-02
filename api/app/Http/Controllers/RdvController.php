<?php

namespace App\Http\Controllers;

use App\Mail\ExceptionOccured;
use App\Mail\RdvMail;
use App\Models\Employee;
use App\Models\Rdv;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

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
            'beginning' => 'required|date_format:Y-m-d H:i:s',
            'end' => 'required|date_format:Y-m-d H:i:s',
            'lastname' => 'required|string',
            'firstname' => 'required|string',
            'mail' => 'email|required',
            'phone' => 'numeric',
            'is_visit' => 'required|boolean',
            'id_employee' => 'required',
            'id_agency' => 'required',
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
            $agency = $rdv->id_agency = $request->input('id_agency');
            $rdv->save();

            Mail::to($clientMail)->send(new RdvMail($label, $beginning, $end, $description, $address, $city, $zipcode, $agency));

            return response()->json(['rdv' => $rdv, 'message' => 'RDV CRÉE'], 201);
        } catch (\Exception $e) {
            $mail = Auth::user()->mail;
            Mail::to('inesbkht@gmail.com')->send(new ExceptionOccured($e->getMessage(), $mail));

            return response()->json(['message' => 'Conflict: La requête ne peut être traitée en l’état actuel.', $e->getMessage()], 409);
        }
    }

    /**
     * Get all rdv for an employee
     *
     *
     * @return Response
     */
    public function employeeRdv()
    {
        //Retrieve the datas of the current authentificated user
        $user = Auth::user();

        //If user is an employee he can get access to all his rdv 
        if ($user->id_role == 4) {

            //Get the id among the retrieved datas of the user 
            $idEmployee = $user->id;

            //Get all the rdv related to the id_employee
            $getEmployeeRdv = Rdv::where('id_employee', $idEmployee)
                ->with([
                    'employee',
                    'label'
            ])
                ->get();

            return response()->json(['rdv' => $getEmployeeRdv], 200);
        } else {
            //Else it returns a http status with message error
            return response()->json(['message' => 'Accès non autorisé : vous ne disposez pas des droits nécessaires.'], 401);
        }
    }
}

