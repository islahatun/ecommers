<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UsersConttroller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function getData(){
        $data = User::all();

        return response()->json([
            'data'  => $data
        ],200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = validator::make($request->all(),[
            'name'      =>'required',
            'email'     =>'required|email|unique:users',
            'password'  =>'required|min:8'
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

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = validator::make($request->all(),[
            'name'      =>'required',
            'email'     =>'required|email|unique:users'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(),422);
        }

        $user   = User::where('id',$id)->update([
            'name'      => $request->name,
            'email'     => $request->email
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $delete = User::where('id',$id)->delete();
        if($delete){
            return response()->json([
                'success'=> true,
                'message'=> 'Account deleted successfully'
            ],201);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Account failed to delete'
              ],409);
        }
    }
}
