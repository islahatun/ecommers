<?php

namespace App\Http\Controllers;

use App\Models\banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class BannerController extends Controller

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

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = validator::make($request->all(),[
            'image' => 'required',
            'status'=> 'required'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(),422);
        }

        if(isset($request->image)){
            $lampiran           = base64_decode($request->image);
            $lampiranFileName   = 'banners-'.$request->image;

            $file               = Storage::disk('public_banners');
            $file->put($lampiranFileName,$lampiran);

           $banners             = banner::create([
            'image'             => $lampiranFileName,
            'status'            => $request->status
           ]);

           if($banners){
            return response()->json([
                'success'   => true,
                'message'   => 'Banner created Successfully'
            ],201);
           }

           return response()->json([
            'success'       => false,
            'message'       => 'Banner fails to create'
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
            'image' => 'required',
            'status'=> 'required'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(),422);
        }

        if(isset($request->image)){
            $lampiran           = base64_decode($request->image);
            $lampiranFileName   = 'banners-'.$request->image;

            $file               = Storage::disk('public_banners');
            $file->put($lampiranFileName,$lampiran);

           $banners             = banner::where('id',$id)->update([
            'image'             => $lampiranFileName,
            'status'            => $request->status
           ]);

           if($banners){
            return response()->json([
                'success'   => true,
                'message'   => 'Banner updated Successfully'
            ],201);
           }

           return response()->json([
            'success'       => false,
            'message'       => 'Banner fails to update'
           ],409);

        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $banners    = banner::where('id',$id)->delete();

        if($banners){
            return response()->json([
                'success'   => true,
                'message'   => 'Banner deleted Successfully'
            ],201);
           }

           return response()->json([
            'success'       => false,
            'message'       => 'Banner fails to delete'
           ],409);
    }
}
