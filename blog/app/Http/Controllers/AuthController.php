<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Employee;



class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login_client','register_client','login_employee','register_employee']]);
    }

    /**
     * Register new client
     *
     * @param Request $request
     * @return Response
     */
    public function register_client(Request $request)
    {
        //validate incoming request 
        $this->validate($request, [
            'lastname' => 'required|string',
            'firstname' => 'required|string',
            'mail' => 'required|email|unique:client',
            'phone' => 'required|numeric',
            'password' => 'required',
        ]);

        try {

            $client = new Client();
            $client->lastname = $request->input('lastname');
            $client->firstname = $request->input('firstname');
            $client->mail = $request->input('mail');
            $client->phone = $request->input('phone');
            $plainPassword = $request->input('password');
            $client->password = app('hash')->make($plainPassword);

            $client->save();

            //return successful response
            return response()->json(['client' => $client, 'message' => 'CREATED'], 201);

        } catch (\Exception $e) {
            //return error message
            return response()->json(['message' => 'L\'enregistrement du client a échoué !', 'error' => $e->getMessage()], 409);
        }

    }

    /**
     * Login method
     */
    public function login_client(Request $request)
    {
          //validate incoming request 
        $this->validate($request, [
            'mail' => 'required|string',
            'password' => 'required|string',
        ]);
        $credentials = $request->only(['mail', 'password']);
        if (!$token = Auth::attempt($credentials)) {
            return response()->json(['message' => 'ACCÈS NON AUTORISÉ! VEUILLEZ VOUS AUTHENTIFIER.'], 401);
        }
        return $this->respondWithToken($token);
    }

    /**
     * Register new employee
     *
     * @param Request $request
     * @return Response
     */
    public function register_employee(Request $request)
    {
        //validate incoming request 
        $this->validate($request, [
            'lastname' => 'required|string',
            'firstname' => 'required|string',
            'mail' => 'required|email|unique:employee',
            'phone' => 'required|numeric',
            'id_role' => 'required|numeric',
            'id_agency' => 'required|numeric',
            'password' => 'required',
            'idNumber' =>'unique:employee'
        ]);

        try {
            //dd($request);
            $employee = new Employee();
            $employee->lastname = $request->input('lastname');
            $$employee->firstname = $request->input('firstname');
            $employee->mail = $request->input('mail');
            $employee->phone = $request->input('phone');
            $plainPassword = $request->input('password');
            $employee->password = app('hash')->make($plainPassword);
            $employee->idNumber = rand(1,100);
            $employee->id_role = $request->input('id_role');
            $employee->id_agency = $request->input('id_agency');


            $employee->save();

            //return successful response
            return response()->json(['employee' => $employee, 'message' => 'CREATED'], 201);

        } catch (\Exception $e) {
            //return error message
            return response()->json(['message' => 'L\'enregistrement de l\'employée a échoué !', 'error' => $e->getMessage()], 409);
        }

    }

    /**
     * Login method for employee
     */
    public function login_employee(Request $request)
    {
          //validate incoming request 
        $this->validate($request, [
            'mail' => 'required|string',
            'password' => 'required|string',
        ]);
        $credentials = $request->only(['mail', 'password']);
        if (!$token = Auth::attempt($credentials)) {
            return response()->json(['message' => 'ACCÈS NON AUTORISÉ! VEUILLEZ VOUS AUTHENTIFIER.'], 401);
        }
        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Vous avez été connecté avec succès !']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(Auth::refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 120
        ]);
    }
}