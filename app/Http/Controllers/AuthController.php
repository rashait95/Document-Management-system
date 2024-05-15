<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;


class AuthController extends Controller 
{
    public function register(RegisterRequest $request){
       
       try{
        DB::beginTransaction();
            $user=User::create([
                'name'=>$request->name,
                'email'=>$request->email,
                'password'=>Hash::make($request->password),
            ]);
           
            $token = $user->createToken('authToken')->plainTextToken;

            DB::commit();
            return response()->json([
                'status' => 'success',
                'message' => 'User created successfully',
                'user' => $user,
                'authorisation' => [
                    'token' => $token,
                    'type' => 'bearer',
                ]
            ]);
        } catch(Throwable  $th){

            DB::rollback();
            Log::error($th);
            return response()->json([
                'status'=>'user not created',
                'error'=>$th->getMessage(),
                
            ], 500);
    
    }    }
    

    
    public function login(LoginRequest $request){
        
        try{
        
            DB::beginTransaction();
       $credentials = $request->only('email', 'password');

        $token = Auth::attempt($credentials);
        if (!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized',
            ], 401);
        }

        $user = Auth::user();
        return response()->json([
                'status' => 'success',
                'user' => $user,
                'authorisation' => [
                    'token' => $token,
                    'type' => 'bearer',
                ]
            ]);
    
        
    
    }catch(\Throwable  $th){
    
        DB::rollback();
        Log::error($th);
        return response()->json([
            'status'=>'user not authorized',
            'error'=>$th->getMessage(),
            
        ], 500);
    
    }
    }


    public function logout(){
        Auth::guard('api')->logout();
    
    return response()->json([
        'status' => 'success',
        'message' => 'logout'
    ], 200);
    }
    
}
