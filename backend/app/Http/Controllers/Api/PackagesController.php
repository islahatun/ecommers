<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Models\package;
use Illuminate\Http\Request;

class PackagesController extends Controller
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
        $data = package::all();

        return response()->json([
            'data' => $data
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator   = validator::make($request->all(), [
            'package_name' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $result     = package::create([
            'package_name'   => $request->package_name

        ]);

        if ($result) {
            return response()->json([
                'success'   => true,
                'message'   => 'Package Created Successfully'
            ], 201);
        } else {
            return response()->json([
                'message'   => false,
                'message'   => 'Package fails create '
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
        $validator   = validator::make($request->all(), [
            'package_name' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $result     = package::where('id', $id)->update([
            'package_name'   => $request->package_name

        ]);

        if ($result) {
            return response()->json([
                'success'   => true,
                'message'   => 'Package updated Successfully'
            ], 201);
        } else {
            return response()->json([
                'message'   => false,
                'message'   => 'package fails update '
            ], 409);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $result = package::where('id', $id)->delete();

        if ($result) {
            return response()->json([
                'success'   => true,
                'message'   => "Package deleted successfully"
            ], 200);
        } else {
            return response()->json([
                'success'   => false,
                'message'   => "Package fails delete"
            ], 409);
        }
    }
}
