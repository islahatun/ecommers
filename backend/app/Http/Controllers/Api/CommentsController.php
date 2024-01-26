<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\comment;
use Illuminate\Http\Request;

class CommentsController extends Controller
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

    public function getData($user_id)
    {
        $data = comment::where('user_id', $user_id)->get();

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
            'comment' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $result     = comment::create([
            'user_id'   => 1,
            'comment'   => $request->comment
        ]);

        if ($result) {
            return response()->json([
                'success'   => true,
                'message'   => 'Coomment Created Successfully'
            ], 201);
        } else {
            return response()->json([
                'message'   => false,
                'message'   => 'Comment fails create '
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
            'comment' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $result     = comment::where('id', $id)->update([
            'comment'   => $request->comment
        ]);

        if ($result) {
            return response()->json([
                'success'   => true,
                'message'   => 'Coomment updated Successfully'
            ], 201);
        } else {
            return response()->json([
                'message'   => false,
                'message'   => 'Comment fails update '
            ], 409);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
