<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $validator = validator::make($request->all(),[
            'name'      =>'required',
            'email'     =>'required|email|unique:users',
            'password'  =>'required|min:8|confirmed'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(),422);
        }

        $user   = User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => Hash::make($request->password)
        ]);

        if($user){
            return response()->json([
                'success'=> true,
                'message'=> 'Account created successfully'
            ],201);
        } else{
          return response()->json([
            'success' => false,
            'message' => 'Account failed to create'
          ],409);
        }
    }
}
