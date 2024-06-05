<?php

namespace App\Http\Controllers;

use App\Models\User;
use Error;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function register(Request $r)
    {
        DB::beginTransaction();
        try{
            $req1=$r->id?'nullable|string|min:6|confirmed':'required|string|min:6|confirmed';
            $req2=$r->id?'required|string|email|max:255':'required|string|email|max:255|unique:users';
            $validatedData = $r->validate([
                'name' => 'required|string|max:255',
                'email' => $req2,
                'password' => $req1,
            ]);
            $user =$r->id?User::find($r->id):new User();
            $user->name=strtoupper($r->id?$r->name:$r->name.' '.$r->last);
            $user->email=$r->id?$r->email: $validatedData['email'];
            if($r->filled('password')){
                $user->password = Hash::make($validatedData['password']);
            }
            $user->save();
            $token = JWTAuth::fromUser($user);

            DB::commit();
            return response()->json(['status'=>200,'response'=>'datos añadidos correctamente','token'=>$token]);
        }catch(Exception $e){
            DB::rollBack();
          return response()->json(['status'=>500,'response'=>$e->getMessage()]);
        }
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!$token = Auth::attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return response()->json(['token' => $token]);
    }

    public function getUser(Request $request)
    {
        return response()->json(Auth::user());
    }
}
