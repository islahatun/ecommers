<?php

namespace App\Http\Controllers\api;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $credentials = $request->only('email','password');

        if(Auth::attempt($credentials)){
            $user   = Auth::user();
            // install laravel passport untuk bisa menjalankan createToken atau bisa menggunakan sanctum
            // bisa menggunakan accessToken atau plainTextToken
            //  'AuthToken' hanyalah sebuah string biasa bisa diisi apa aja
            $token  = $user->createToken('AuthToken')->accessToken;

            return response()->json(['token'=>$token],200);
        }else{
            return response()->json(['error'=>'Unauthorized'],200);
        }
    }
}
