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
     * Get all Employees.
     *
     * @return Response
     */
    public function allEmployees()
    {
        return response()->json(['employee' =>  Employee::all()], 200);
    }
}
