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
       $data = json_decode($request->get('data'), true);
        $rules = array(
            'lname' => 'required|string',
            'fname' => 'required|string',
            'mname' => 'required|string',
            'emp_no' => 'required|string|unique:users',
        );
        $this->validate( $request , $rules);        
        try {
           
            $user = new Users;
            $user->lastname = $request->input('lname');
            $user->firstname = $request->input('fname');
            $user->middlename = $request->input('mname');
            $user->emp_no = $request->input('emp_no');
            $user->is_validated = 0;
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
        if(Auth::user()->is_validated!=1 && Auth::user()->row_status!=1){
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        $output = array(
            "UserId"=> Auth::user()->user_id,
            "DisplayName"=> Auth::user()->lastname.', '.Auth::user()->firstname,
            "token" => $getRespondToken->original['token'],"expires_in" => $getRespondToken->original['expires_in'] );
        return $output ;
    }

    /**
     * Reset password.
     *
     * @param  Request  $request
     * @return Response
     */
    public function reset_password(Request $request)
    {
        $data = json_decode($request->get('data'), true);  
        $rules = array(
            'token' => 'required',
            'currentPassword' => 'required|string',
            'newPassword' => 'required|string',
            'retypePassword' => 'required|string|same:newPassword',
        );
        $this->validate( $request , $rules);
    
        try { 
            $hasher = app('hash');
            $user = Users::where(["user_id"=>$request->user_id])->first();
            if($hasher->check($request->currentPassword, $user->password)) {
                Users::where(['user_id'=>$user->user_id])->update([
                    'password'=> app('hash')->make($request->newPassword),
                ]);
            }else{            
                return response()->json(['message' => 'Current Password does not match!'], 409);
            }
            return response()->json(['status'=>"OK", 'message' => 'UPDATED'], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'User Registration Failed!'], 409);
        }
       
    }
}
