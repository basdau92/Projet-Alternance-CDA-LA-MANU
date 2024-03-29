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
        $this->middleware(null, ['except' => ['loginClient', 'registerClient', 'loginEmployee', 'registerEmployee']]);
    }

    /**
     * Register new client
     *
     * @param Request $request
     * @return Response
     */
    public function registerClient(Request $request)
    {
        //validate incoming request 
        $this->validate($request, [
            'lastname' => 'required|string',
            'firstname' => 'required|string',
            'mail' => 'required|email|unique:client',
            'phone' => 'required|numeric',
            'password' => [
                'required',
                'min:6',
                'regex:/(?=.*[a-z])(?=.*[A-Z])(?=.*[\W_])(?=^.*[^\s].*$).*$/'
            ]
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
            return response()->json(['client' => $client, 'message' => 'Votre compte a bien été créé. Vous pouvez vous authentifier.'], 201);
        } catch (\Exception $e) {
            //return error message
            return response()->json(['message' => 'L\'enregistrement a échoué.', 'error' => $e->getMessage()], 409);
        }
    }

    /**
     * Login method
     */
    public function loginClient(Request $request)
    {
        //validate incoming request 
        $this->validate($request, [
            'mail' => 'required|email',
            'password' => 'required'
        ]);
        $credentials = $request->only(['mail', 'password']);
        if (!$token = Auth::guard('api-client')->attempt($credentials)) {
            return response()->json(['message' => 'Accès non autorisé. Veuillez vérifier vos informations.'], 401);
        }
        return $this->respondWithToken($token);
    }

    /**
     * Register new employee
     *
     * @param Request $request
     * @return Response
     */
    public function registerEmployee(Request $request)
    {
        //validate incoming request 
        $this->validate($request, [
            'lastname' => 'required|string',
            'firstname' => 'required|string',
            'mail' => 'required|email|unique:employee',
            'phone' => 'required|numeric',
            'id_role' => 'required|numeric',
            'id_agency' => 'required|numeric',
            'matricule' => 'unique:employee',
            'password' => [
                'required',
                'min:6',
                'regex:/(?=.*[a-z])(?=.*[A-Z])(?=.*[\W_])(?=^.*[^\s].*$).*$/'
            ]
        ]);

        try {
            $employee = new Employee();

            $employee->lastname = $request->input('lastname');
            $employee->firstname = $request->input('firstname');
            $employee->mail = $request->input('mail');
            $employee->phone = $request->input('phone');
            $plainPassword = $request->input('password');
            $employee->password = app('hash')->make($plainPassword);
            $employee->matricule = rand(10000, 99999);
            $employee->id_role = $request->input('id_role');
            $employee->id_agency = $request->input('id_agency');
            $employee->save();

            //return successful response
            return response()->json(['employee' => $employee, 'message' => 'Le compte employé a bien été créé.'], 201);
        } catch (\Exception $e) {
            //return error message
            return response()->json(['message' => 'L\'enregistrement de l\'employé a échoué.', 'error' => $e->getMessage()], 409);
        }
    }

    /**
     * Login method for employee
     */
    public function loginEmployee(Request $request)
    {
        //validate incoming request 
        $this->validate($request, [
            'matricule' => 'required|numeric',
            'password' => 'required',
        ]);
        $credentials = $request->only(['matricule', 'password']);
        if (!$token = Auth::guard('api-employee')->attempt($credentials)) {
            return response()->json(['message' => 'Accès non autorisé. Veuillez vérifier vos informations.'], 401);
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

        return response()->json(['message' => 'Vous avez été déconnecté avec succès !']);
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
