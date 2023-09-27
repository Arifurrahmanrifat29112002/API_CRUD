<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController as BaseController;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticationController extends BaseController
{

    public function Registration(Request $request){
        
        $validation = validator::make($request->all(),[
            'name'    => 'required',
            'email'   => 'required|email',
            'password'=>  'required',
            'password_confirm' => 'required|same:password'  // required and has to match the password field
        ]);

        if ($validation -> fails()){
            return $this->sendError('validation Error',$validation->errors());
        }

        $password = bcrypt($request->password);
        $user = User::create([
            "name"      =>     $request['name'],
            "email"     =>     $request["email"],
            "password"  =>     $password,
        ]);

        $success['token'] = $user->createToken('RestApi')->plainTextToken;
        $success['name'] = $user->name;

        return $this->sendRespons($success,'user regiestration successfully');

    }


    public function Login(Request $request){
        $validation = validator::make($request->all(),[
            'email'   => 'required|email',
            'password'=>  'required',
        ]);

        if ($validation -> fails()) {
            return $this->sendError('Validation Error',$validation->errors());
        }

        if (Auth::attempt(['email'=>$request->email,'password'=>$request->password])) {
            $user = Auth::user();

            $success['token'] = $user->createToken('RestApi')->plainTextToken;
            $success['name'] = $user->name;

            return $this->sendRespons($success,'user login successfully');
        }else{
            return $this->sendError('Unauthorised',['error' =>"Invalid email or Password"]);
        }
    }

    //Auth::user() logout
    public function logout(){
        Auth::user()->tokens()->delete();
        return $this->sendRespons([],'user logout');
    }
}
