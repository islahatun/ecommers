<?php

namespace App\Http\Controllers;

use App\Models\category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
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
        $category = category::all();

        return response()->json([
            'data'=>$category,
        ],200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = validator::make($request->all(),[
            'category_name' => 'required|unique:categories'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(),422);
        }

        $category   = category::create([
            'category_name'=>$request->category_name
        ]);

        if($category){
            return response()->json([
                'success'=>true,
                'message'=> 'Category created successfully'
            ],201);
        }else{
            return response()->json([
                'success'=>false,
                'message'=> 'Category failed to create'
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
            'category_name' => 'required|unique:categories'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(),422);
        }

        $category   = category::where('id',$id)->update([
            'category_name'=>$request->category_name
        ]);

        if($category){
            return response()->json([
                'success'=>true,
                'message'=> 'Category update successfully'
            ],201);
        }else{
            return response()->json([
                'success'=>false,
                'message'=> 'Category failed to update'
            ],409);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category   = category::where('id',$id)->delete();

        if($category){
            return response()->json([
                'success'=>true,
                'message'=> 'Category delete successfully'
            ],201);
        }else{
            return response()->json([
                'success'=>false,
                'message'=> 'Category failed to delete'
            ],409);
        }
    }
}
