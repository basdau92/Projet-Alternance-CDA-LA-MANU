<?php

namespace App\Http\Controllers;

use App\Models\Employee;
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
                return response()->json(['employee' =>  Employee::all()], 200);
            } else {
                return response()->json(['message' => 'Vous n\'avez pas les droits nécessaires pour accéder à ces informations.'], 403);
            }
        } catch (\Exception $e) {
            $mail = Auth::user()->mail;
            Mail::to('inesbkht@gmail.com')->send(new ExceptionOccured($e->getMessage(), $mail));

            return response()->json(['message' => 'Aucun employé n\'a été trouvé.'], 404);
        }
    }
}
