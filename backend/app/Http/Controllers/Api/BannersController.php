<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;


class BannersController extends Controller
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
        $banners        = Banner::all();

        $imagePaths     = Storage::files('banners');
        $dataBanners    =[];
        foreach($banners as $b){
            $getPic     = $b->image;
            $imagePaths = Storage::files('banners');

            /* fungsi in_array adalah untuk memeriksa apakah suatu nilai tertentu ada di dalam array.
            dalam kasus ini ingin memeriksa apakah ada productImage di dalam array imagePaths
             */
            if(in_array($getPic,$imagePaths)){
                $banner_image  = asset('storage/' . $getPic);
            }else{
                $banner_image  = null;
            }
            $status     = "Publish";
            if($b->status != 1){
                $status = "private";
            }
            $dataBanners[] = [
                'id'         => $b->id,
                'status'     => $status,
                'image'      => $banner_image,
                'created_at' => $b->created_at,

            ];

        }


        return response()->json([
            'data'=>$dataBanners,
        ],200);
    }

    public function getDataImages(){
        $imagePaths = Storage::files('banners');

        $images = array_map(function ($path) {
            return ['url' => asset('storage/' . $path)];
        }, $imagePaths);

        return response()->json(['data' => $images]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = validator::make($request->all(), [
            'image'     => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            'status'    => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if ($request->file('image')) {

            $banners             = banner::create([
                'image'             => $request->file('image')->store('banners'),
                'status'            => $request->status
            ]);

            if ($banners) {
                return response()->json([
                    'success'   => true,
                    'message'   => 'Banner created Successfully'
                ], 201);
            }

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
            'image' => 'required|image|file|max:1024',
            'status' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if ($request->file('image')) {

            Storage::delete($request->oldImage);

            $banners             = banner::where('id',$id)->update([
                'image'          => $request->file('image')->store('banners'),
                'status'         => $request->status
            ]);

            if ($banners) {
                return response()->json([
                    'success'   => true,
                    'message'   => 'Banner updated Successfully'
                ], 201);
            }

            return response()->json([
                'success'       => false,
                'message'       => 'Banner fails to update'
            ], 409);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        dd($id);
        $data       = banner::find();
        if($data){
            storage::delete($data->image);
        }
        $banners    = banner::where('id', $id)->delete();

        if ($banners) {
            return response()->json([
                'success'   => true,
                'message'   => 'Banner deleted Successfully'
            ], 201);
        }

        return response()->json([
            'success'       => false,
            'message'       => 'Banner fails to delete'
        ], 409);
    }
}
