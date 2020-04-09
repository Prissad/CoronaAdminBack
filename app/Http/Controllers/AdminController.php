<?php

namespace App\Http\Controllers;

use App\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
//use Hash;
use Illuminate\Support\Facades\Hash;
use function MongoDB\BSON\toJSON;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;





class AdminController extends Controller
{

    public function register(Request $request)
    {
        $gouv=$request->gouv;
        $deleg=$request->deleg;

        $id = DB::table('delegations')
            ->join('gouvernorats', 'delegations.gouvernorat_id', 'gouvernorats.id')
            ->where([
                ['gouvernorats.name', '=', $gouv],
                ['delegations.name', '=', $deleg]
            ])
            ->select('delegations.id')
            ->get();


        $admin = Admin::create([
            'email'    => $request->email,
            'name' => $request->name,
            'phone' => $request->phone,
            'cin' => $request->cin,
            'password' => $request->password,
            'delegation_id' => $id->first()->id,
        ]);

        $token = auth()->login($admin);

        return $this->respondWithToken($token);
        //return $id->first()->id;
        //return response()->json($id);
    }

    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $email=request('email');
        $psswd=request('password');

        $admins = DB::table('admins')
            ->where([
                ['admins.email', '=', $email],
                //Hash::check($psswd,'admins.password')
            ])
            ->select('admins.*')
            ->get();

        foreach ($admins as $admin){
            if(Hash::check($psswd,$admin->password)){
                $deleg_id=$admin;
                break;
            }
        }

        //return $this->respondWithToken($token);
        return $this->respond($token,$deleg_id->delegation_id,$deleg_id->name);

    }

    public function logout(Request $request)
    {
        /*auth()->logout();
        JWTAuth::invalidate(JWTAuth::parseToken());
        return response()->json(['message' => 'Successfully logged out']);*/
        $token = $request->header( 'Authorization' );

        try {
            JWTAuth::parseToken()->invalidate( $token );

            return response()->json( [
                'error'   => false,
                'message' => trans( 'auth.logged_out' )
            ] );
        } catch ( TokenExpiredException $exception ) {
            return response()->json( [
                'error'   => true,
                'message' => trans( 'auth.token.expired' )

            ], 401 );
        } catch ( TokenInvalidException $exception ) {
            return response()->json( [
                'error'   => true,
                'message' => trans( 'auth.token.invalid' )
            ], 401 );

        } catch ( JWTException $exception ) {
            return response()->json( [
                'error'   => true,
                'message' => trans( 'auth.token.missing' )
            ], 500 );
        }
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => auth()->factory()->getTTL() * 60
        ]);
    }

    protected function respond($token,$deleg,$name)
    {
        return response()->json([
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => auth()->factory()->getTTL() * 60,
            'deleg_id'     => $deleg,
            'name'         => $name
        ]);
    }

}
