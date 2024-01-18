<?php

namespace App\Http\Controllers;

use App\Models\expedisi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class expedisiController extends Controller
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

    public function getData()
    {
        $expedisi = expedisi::all();

        return response()->json([
            'data'  => $expedisi
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = validator::make($request->all(), [
            'expedisi_name' => 'required|unique:expedisis',
            'start_estimasi' => 'required',
            'end_estimasi'  => 'required',
            'shipping_cost' => 'required|numeric',
            'distance'      => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $expedisi = expedisi::create([
            'expedisi_name' => $request->expedisi_name,
            'start_estimasi' => $request->start_estimasi,
            'end_estimasi'  => $request->end_estimasi,
            'shipping_cost' => $request->shipping_cost,
            'distance'      => $request->distance
        ]);

        if ($expedisi) {
            return response()->json([
                'success'   => true,
                'message'   => 'Expedisi created successfully'
            ], 200);
        } else {
            return response()->json([
                'success'   => false,
                'message'   => 'Expedisi failed to create'
            ], 409);
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
        $validator = validator::make($request->all(), [
            'expedisi_name' => 'required|unique:expedisis',
            'start_estimasi' => 'required',
            'end_estimasi'  => 'required',
            'shipping_cost' => 'required|numeric',
            'distance'      => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $expedisi = expedisi::where('id', $id)->update([
            'expedisi_name' => $request->expedisi_name,
            'start_estimasi' => $request->start_estimasi,
            'end_estimasi'  => $request->end_estimasi,
            'shipping_cost' => $request->shipping_cost,
            'distance'      => $request->distance
        ]);

        if ($expedisi) {
            return response()->json([
                'success'   => true,
                'message'   => 'Expedisi updated successfully'
            ], 200);
        } else {
            return response()->json([
                'success'   => false,
                'message'   => 'Expedisi failed to update'
            ], 409);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $expedisi = expedisi::where('id', $id)->delete();

        if($expedisi){
            return response()->json([
                'success'   => true,
                'message'   => 'Expedisi deleted successfully'
            ]);
        }else{
            return response()->json([
                'success'   => false,
                'message'   => 'Expedisi failed to delete'
            ]);
        }


    }
}
