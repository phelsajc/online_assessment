<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use  App\User;
use  App\Users;

class AuthController extends Controller
{
    /**
     * Store a new user.
     *
     * @param  Request  $request
     * @return Response
     */
    public function register(Request $request)
    {
       // dd($request);
       $data = json_decode($request->get('data'), true);
       // return response()->json(['user' => $data, 'message' => 'CREATED'], 201);
        //validate incoming request  000001
        /* $this->validate($request->get('data'), [
            //username
            'lname' => 'required|string',
            'fname' => 'required|string',
            'mname' => 'required|string',
            'emp_no' => 'required|string|unique:users',
            'password' => 'required|confirmed',
        ]);  */    

        $rules = array(
            'lname' => 'required|string',
            'fname' => 'required|string',
            'mname' => 'required|string',
            'emp_no' => 'required|string|unique:users',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required ',
      );
        $this->validate( $request , $rules);
        
        try {
           
            $user = new Users;
            $user->lastname = $request->input('lname');
            $user->firstname = $request->input('fname');
            $user->middlename = $request->input('mname');
            $user->emp_no = $request->input('emp_no');
            $user->username = $request->input('emp_no');
            $plainPassword = $request->input('password');
            $user->password = app('hash')->make($plainPassword);
            $user->save();

            //return successful response
            return response()->json(['user' => $user, 'message' => 'CREATED'], 201);

        } catch (\Exception $e) {
            //return error message
            return response()->json(['message' => 'User Registration Failed!'], 409);
        }

    }


    /**
     * Get a JWT via given credentials.
     *
     * @param  Request  $request
     * @return Response
     */
    public function login(Request $request)
    {
          //validate incoming request 
        $this->validate($request, [
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only(['username', 'password']);

        if (! $token = Auth::attempt($credentials)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        
        $getRespondToken = $this->respondWithToken($token);
        /* $data_user = array(
            "user_id"=> Auth::user()->user_id,
            "emp_no"=> Auth::user()->emp_no,
            "name"=> Auth::user()->lastname.', '.Auth::user()->firstname,
            "department_id"=> Auth::user()->department_id,
            "contact_no"=> Auth::user()->contact_no,
        ); */
        $output = array(
            "UserId"=> Auth::user()->user_id,
            "Empno"=> Auth::user()->emp_no,
            "DisplayName"=> Auth::user()->lastname.', '.Auth::user()->firstname,
            "department_id"=> Auth::user()->department_id,
            "contact_no"=> Auth::user()->contact_no,
            "Avatar"=> Auth::user()->picture,
            "token" => $getRespondToken->original['token'],"expires_in" => $getRespondToken->original['expires_in'],"token_type" => $getRespondToken->original['token_type'],"credentials"=>$credentials );
        return $output ;
        //$this->respondWithToken($output);
    }
}
