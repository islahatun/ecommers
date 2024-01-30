<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\bank;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BanksController extends Controller
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
        $banks = bank::all();

        return response()->json([
            'data'=>$banks,
        ],200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = validator::make($request->all(),[
            "data"              => 'required|array',
            "data.*.bank_code"  => 'required|unique:banks',
            "data.*.bank_name"  => 'required|unique:banks'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(),422);
        }

        // multiple insert data
        $banks   = bank::insert($request->input("data"));

        if($banks){
            return response()->json([
                'success'=>true,
                'message'=> 'Bank created successfully'
            ],201);
        }else{
            return response()->json([
                'success'=>false,
                'message'=> 'Bank failed to create'
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
            'bank_code' => 'required|unique:banks',
            'bank_name' => 'required|unique:banks'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(),422);
        }

        $banks   = bank::where('id',$id)->update([
            'bank_code' =>$request->bank_code,
            'bank_name' =>$request->bank_name
        ]);

        if($banks){
            return response()->json([
                'success'=>true,
                'message'=> 'Bank update successfully'
            ],201);
        }else{
            return response()->json([
                'success'=>false,
                'message'=> 'Bank failed to update'
            ],409);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $banks   = bank::where('id',$id)->delete();

        if($banks){
            return response()->json([
                'success'=>true,
                'message'=> 'Bank delete successfully'
            ],201);
        }else{
            return response()->json([
                'success'=>false,
                'message'=> 'Bank failed to delete'
            ],409);
        }
    }
}
