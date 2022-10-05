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
        $this->middleware('auth:api', ['except' => ['employeeRdv']]);
    }

    /**
     * Create a new RDV
     */
    public function createRdv(Request $request)
    {

        $this->validate($request, [
            'beginning' => 'required|date_format:Y-m-d H:i:s',
            'end' => 'required|date_format:Y-m-d H:i:s',
            'lastname' => 'required|string',
            'firstname' => 'required|string',
            'mail' => 'email|required',
            'phone' => 'numeric',
            'address' => 'required|string',
            'city' => 'required|string',
            'zipcode' => 'required|string',
            'is_visit' => 'required|boolean',
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

            return response()->json(['rdv' => $rdv, 'message' => 'Le RDV a été créé avec succès.'], 201);
        } catch (\Exception $e) {
            $mail = Auth::user()->mail;
            Mail::to('inesbkht@gmail.com')->send(new ExceptionOccured($e->getMessage(), $mail));

            return response()->json(['message' => 'Conflict: La requête ne peut être traitée en l’état actuel.', $e->getMessage()], 409);
        }
    }

    /**
     * Get all rdv related to an employee
     *
     * @param  int  $id
     * @return Response
     */
    public function employeeRdv($id)
    {
        try {

            //Get all the rdv related to a specific employee
            $getEmployeeRdv = Rdv::where('id_employee', $id)
                ->with([
                    'employee',
                    'label',
                ])
                ->get();

            return response()->json(['rdv' => $getEmployeeRdv], 200);
        } catch (\Exception $e) {

            //Else it returns a http status with message error.
            return response()->json(['message' => 'Accès non autorisé : vous ne disposez pas des droits nécessaires.', 'error' => $e->getMessage()], 401);
        }
    }

    /**
     * Get all rdv for an authentified employee
     *
     * 
     * @return Response
     */
    public function showAuthEmployeeRdv()
    {
        try {
            $getAuthEmployeeRdv =
                Rdv::join('employee', 'rdv.id_employee', '=', 'employee.id')
                ->join('label', 'rdv.id_label', '=', 'label.id')
                ->join('agency', 'rdv.id_agency', '=', 'agency.id')
                ->where('id_employee', Auth::userOrFail()->id)
                ->get(['rdv.*', 'employee.lastname as employeeLastname', 'employee.firstname as employeeFirstname', 'employee.matricule', 'label.name as label', 'agency.name']);

            return response()->json(['rdv' => $getAuthEmployeeRdv], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'La liste des rendez-vous pour cet(te) employé(e) n\'a pas été trouvée !', 'error' => $e->getMessage()], 404);
        }
    }
}
