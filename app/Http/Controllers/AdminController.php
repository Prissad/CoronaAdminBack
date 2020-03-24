<?php

namespace App\Http\Controllers;

use App\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Hash;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;





class AdminController extends Controller
{
 /*   public function signUp(Request $request){
        $email=$request['email'];
        $password=$request['password'];
        $password=Hash::make($password);
        $name=$request['name'];
        $phone=$request['phone'];
        $cin=$request['cin'];

        $admin=new Admin();
        $admin->email=$email;
        $admin->name=$name;
        $admin->password=$password;
        $admin->phone=$phone;
        $admin->cin=$cin;

        $admin->save();

        //return redirect()->back();
        return "ajouté";

    }

    public function login(Request $request){
        $email=$request['email'];
        $password=$request['password'];

        $admin = Admin::where('email', $email)->first();
        if(($admin != null)&&(Hash::check($password,$admin->password))){
            return response()->json(['success' => $admin->name]);
        }
        else{
            return response()->json(['error'=>'Unauthorised'], 401);
        }

        $input = $request->only('email', 'password');
        $jwt_token = null;
        if (!$jwt_token = JWTAuth::attempt($input)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Email or Password',
            ], 401);
        }
        // get the user
        $user = Auth::user();

        return response()->json([
            'success' => true,
            'token' => $jwt_token,
            'user' => $user
        ]);

    }*/

    public function register(Request $request)
    {
        $admin = Admin::create([
            'email'    => $request->email,
            'name' => $request->name,
            'phone' => $request->phone,
            'cin' => $request->cin,
            'password' => $request->password,
        ]);

        $token = auth()->login($admin);

        return $this->respondWithToken($token);
    }

    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => auth()->factory()->getTTL() * 60
        ]);
    }

}
