<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use  App\Users;

class UserController extends Controller
{
     /**
     * Instantiate a new UserController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Get the authenticated User.
     *
     * @return Response
     */
    public function update(Request $request)
    {        
        $rules = array(
            'name' => 'string',
            'user_name' => 'string|min:4|max:20',
            'avatar' => 'dimensions:max_width=256,max_height=256',
            'email' => 'string',
            'user_role' => 'string',
            'registered_at' => 'string',
            'created_at' => 'string',
            'updated_at' => 'string',
        );
        $this->validate( $request , $rules);        
        try {  
            $user = Users::where('user_id',$request->id)
            ->update([
                'name'=>$request->name,
                'user_name'=>$request->user_name,
                'avatar'=>$request->avatar,
                'email'=>$request->email,
                'user_role'=>$request->user_role,
                'registered_at'=>$request->registered_at,
                'created_at'=>$request->created_at,
               'updated_at'=>$request->updated_at,            
            ]);
            return response()->json(['message' => 'UPDATED'], 201);
        } catch (\Exception $e) {
            //return error message
            return response()->json(['messagex' =>$request['id'] ], 409);
        }
    }  

}
