<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Employee;
use App\Models\Property;
use App\Mail\ExceptionOccured;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class EmployeeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api-employee');
    }

    /**
     * Get one employee by id 
     *
     * @param  int  $id
     * @return Response
     */
    public function singleEmployee()
    {
        try {
            return response()->json(['employee' => Auth::guard('api-employee')->user()], 200);
        } catch (\Exception $e) {
            $mail = Auth::guard('api-employee')->user()->mail;
            Mail::to('inesbkht@gmail.com')->send(new ExceptionOccured($e->getMessage(), $mail));

            return response()->json(['message' => 'Impossible de récupérer les informations de cet(te) employé(e).'], 409);
        }
    }

    /**
     * Get all Employees if permission accorded
     *
     * @return Response
     */
    public function allEmployees()
    {
        try {
            if (Auth::guard('api-employee')->user()->id_role == 1 || Auth::guard('api-employee')->user()->id_role == 2) {
                $employees = Employee::leftJoin('agency', 'employee.id_agency', '=', 'agency.id')
                    ->get(['employee.*', 'agency.name', 'agency.address', 'agency.zipcode', 'agency.phone as agencyPhone']);

                return response()->json(['employee' =>  $employees], 200);
            } elseif (Auth::guard('api-employee')->user()->id_role == 3) {
                $employees = Employee::leftJoin('agency', 'employee.id_agency', '=', 'agency.id')
                    ->where('employee.id_agency', Auth::guard('api-employee')->user()->id_agency)
                    ->get(['employee.*', 'agency.name', 'agency.address', 'agency.zipcode', 'agency.phone as agencyPhone']);

                return response()->json(['employee' =>  $employees], 200);
            } else {
                return response()->json(['message' => 'Vous n\'avez pas les droits nécessaires pour accéder à ces informations.'], 403);
            }
        } catch (\Exception $e) {
            $mail = Auth::guard('api-employee')->user()->mail;
            Mail::to('inesbkht@gmail.com')->send(new ExceptionOccured($e->getMessage(), $mail));

            return response()->json(['message' => 'Aucun employé n\'a été trouvé.'], 404);
        }
    }

    /** SHOW ALL PROPERTIES ASSOCIATED TO AN EMPLOYEE
     * Get all properties.
     *
     * 
     * @return Response
     */
    public function allEmployeeProperties()
    {
        try {
            // Try to get several datas related to the PropertyList model/table by Eloquence.
            $properties = Property::leftJoin('property_list', 'property_list.id_property', '=', 'property.id')
                ->where('id_employee', Auth::guard('api-employee')->user()->id)
                ->get(['property.*']);

            if (sizeof($properties) == 0) {
                return response()->json(['message' => 'Aucun bien immobilier n\'est rattaché à cet(te) employé(e).'], 404);
            } else {
                // If successful, return successful response.
                return response()->json(['property' => $properties], 200);
            }
        } catch (\Exception $e) {

            // If unsuccessful, return a custom error message and a HTML status.
            return response()->json(['message' => 'La liste des biens immobiliers de cet(te) employé(e) n\' pas pu être récupéré.', 'Error' => $e->getMessage()], 409);
        }
    }

    /** SHOW ALL PROPERTIES FOR DESKTOP APP WITH AUTH
     * Get all properties.
     *
     * 
     * @return Response
     */
    public function allProperties()
    {
        try {

            if (Auth::guard('api-employee')->user()->id_role == 1 || Auth::guard('api-employee')->user()->id_role == 2 || Auth::guard('api-employee')->user()->id_role == 3) {

                $properties = Property::leftJoin('property_list', 'property_list.id_property', '=', 'property.id')
                    ->leftJoin('employee', 'property_list.id_employee', '=', 'employee.id')
                    ->leftJoin('agency', 'employee.id_agency', '=', 'agency.id')
                    ->where('agency.id', '=', Auth::guard('api-employee')->user()->id_agency)
                    ->get(['property.*', 'employee.id', 'employee.firstname', 'employee.lastname', 'employee.matricule', 'agency.id', 'agency.name as AgencyName']);

                if (sizeof($properties) == 0) {
                    return response()->json(['message' => 'Aucun bien immobilier n\'est rattaché à cette agence.'], 404);
                } else {
                    // If successful, return successful response.
                    return response()->json(['property' => $properties], 200);
                }
            } else {
                return response()->json(['message' => 'Vous n\'avez pas les droits nécessaires pour accéder à ces informations.'], 403);
            }
        } catch (\Exception $e) {

            // If unsuccessful, return a custom error message and a HTML status.
            return response()->json(['message' => 'La liste des biens immobiliers n\'a pas pu être affichée.', 'Error' => $e->getMessage()], 409);
        }
    }

    /**
     * Get all Client.
     *
     * @return Response
     */
    public function allClients()
    {
        try {
            $customers = Client::leftJoin('agency', 'client.id_agency', '=', 'agency.id')
                ->get(['client.*', 'agency.name']);
            return response()->json(['client' =>  $customers], 200);
        } catch (\Exception $e) {
            $mail = Auth::guard('api-employee')->user()->mail;
            Mail::to('inesbkht@gmail.com')->send(new ExceptionOccured($e->getMessage(), $mail));

            return response()->json(['message' => 'Conflict: La requête ne peut être traitée en l’état actuel.'], 409);
        }
    }
}
