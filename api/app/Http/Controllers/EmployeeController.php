<?php

namespace App\Http\Controllers;

use App\Models\PropertyList;
use App\Models\Employee;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

use App\Mail\ExceptionOccured;

class EmployeeController extends Controller
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
     * Get one employee by id 
     *
     * @param  int  $id
     * @return Response
     */
    public function singleEmployee()
    {
        try {
            return response()->json(['employee' => Auth::user()], 200);
        } catch (\Exception $e) {
            $mail = Auth::user()->mail;
            Mail::to('inesbkht@gmail.com')->send(new ExceptionOccured($e->getMessage(), $mail));

            return response()->json(['message' => 'L\'employé n\'a pas été trouvé!'], 404);
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
            if (Auth::user()->id_role == 1 || Auth::user()->id_role == 2 || Auth::user()->id_role == 3) {
                $employees = Employee::join('agency', 'employee.id_agency', '=', 'agency.id')->get(['employee.*', 'agency.name', 'agency.address', 'agency.zipcode', 'agency.phone as agencyPhone']);

                return response()->json(['employee' =>  $employees], 200);
            } else {
                return response()->json(['message' => 'Vous n\'avez pas les droits nécessaires pour accéder à ces informations.'], 403);
            }
        } catch (\Exception $e) {
            $mail = Auth::user()->mail;
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
            /* $getAllDatas = PropertyList::where('id_employee', Auth::user()->id)
                ->with('property')
                ->get(); */
            $getAllDatas = PropertyList::join('property','property_list.id_property','=','property.id')->where('id_employee',Auth::user()->id)->get(['property.*']);

            // If successful, return successful response.
            return response()->json(['property' => $getAllDatas], 200);
        } catch (\Exception $e) {

            // If unsuccessful, return a custom error message and a HTML status.
            return response()->json(['message' => 'La liste d\'annonces de propriétés de cet(te) employé(e) n\'a pas pu être affichée!', 'Error' => $e->getMessage()], 404);
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

            if (Auth::user()->id_role == 1 || Auth::user()->id_role == 2 || Auth::user()->id_role == 3) {


                //$getAllDatas = PropertyList::join('property', 'property_list.id_property', '=', 'property.id')->join('employee', 'property_list.id_employee', '=', 'employee.id')->get(['property.*', 'employee.id as id_employee', 'employee.lastname', 'employee.firstname']);

                $getAllDatas = PropertyList::join('property','property_list.id_property','=','property.id')->join('employee','property_list.id_employee','=','employee.id')->join('agency','employee.id_agency','agency.id')->where('agency.id','=',Auth::user()->id_agency)->get(['property.*','employee.id','employee.firstname','agency.id','agency.name']);

                // If successful, return successful response.
                return response()->json(['property' => $getAllDatas], 200);
            } else {
                return response()->json(['message' => 'Vous n\'avez pas les droits nécessaires pour accéder à ces informations.'], 403);
            }
        } catch (\Exception $e) {

            // If unsuccessful, return a custom error message and a HTML status.
            return response()->json(['message' => 'La liste d\'annonces de propriétés n\'a pas pu être affichée !', 'Error' => $e->getMessage()], 404);
        }
    }
}
