<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\incoming_product;
use App\Models\exit_product;
use Illuminate\Http\Request;
use App\Models\product;

class ProdutsController extends Controller
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
        $banners    = product::all();
        $imagePaths = Storage::files('products');
        $dataBanners = [];

        // mengambil data file gambar
        foreach ($banners as $b) {
            $productImage   = $b->product_image;
            /* fungsi in_array adalah untuk memeriksa apakah suatu nilai tertentu ada di dalam array.
            dalam kasusu ini ingin memeriksa apakah ada productImage di dalam array imagePaths
             */
            if (in_array($productImage, $imagePaths)) {
                $product_image  = asset('storage/' . $productImage);
            } else {
                $product_image  = null;
            }
            $dataBanners[] = [
                'id'            => $b->id,
                'category_id'   => $b->category_id,
                'category_name' => $b->categories->category_name,
                'product_image' => $product_image,
                'price'         => $b->price,
                'description'   => $b->description,
                'weight'        => $b->weight,
                'stock'         => $b->stock
            ];
        }
        // mengambil data file gambar end

        return response()->json([
            'data' => $dataBanners,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validator = validator::make($request->all(), [
            'category_id'       => 'required',
            'product_name'      => 'required',
            'description'       => 'required',
            'price'             => 'required',
            'weight'            => 'required',
            'product_image'     => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if ($request->file('product_image')) {
            $result = product::create([
                'category_id'      => $request->category_id,
                'product_name'     => $request->product_name,
                'description'      => $request->description,
                'price'            => $request->price,
                'weight'           => $request->weight,
                'product_image'    => $request->file('product_image')->store('products'),
            ]);
        }

        if ($result) {
            return response()->json([
                'success'   => true,
                'message'   => 'Product created successfully'
            ]);
        } else {
            return response()->json([
                'success'   => false,
                'message'   => 'Product fails create'
            ]);
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
            'category_id'       => 'required',
            'product_name'      => 'required',
            'description'       => 'required',
            'price'             => 'required',
            'weight'            => 'required',
            'product_image'     => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if ($request->file('product_image')) {
            $result = product::where('id', $id)->update([
                'category_id'      => $request->category_id,
                'product_name'     => $request->product_name,
                'description'      => $request->description,
                'price'            => $request->price,
                'weight'           => $request->weight,
                'product_image'    => $request->file('product_image')->store('products'),
            ]);
        }


        if ($result) {
            return response()->json([
                'success'   => true,
                'message'   => 'Product updated successfully'
            ]);
        } else {
            return response()->json([
                'success'   => false,
                'message'   => 'Product fails update'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::beginTransaction();
        try {
            product::where('id', $id)->delete();

            incoming_product::where('id_product', $id)->delete();
            exit_product::where('id_product', $id)->delete();

            // Jika kedua insert berhasil, commit transaksi
            DB::commit();

            return response()->json([
                'success'   => true,
                'message'   => 'Product deleted successfully'
            ], 200);
        } catch (\Exception $e) {


            DB::rollBack();

            return response()->json([
                'success'   => true,
                'message'   => 'Product fails delete'
            ], 409);
        }
    }

    public function createStock(Request $request)
    {
        $validator = validator::make($request->all(), [
            'id_product'        => 'required',
            'incoming_product'  => 'required',
            'date_of_entry'     => 'required'
        ]);


        // if ($validator) {
        //     return response()->json($validator->errors(), 422);
        // }

        DB::beginTransaction();

        try {

            incoming_product::create([
                'id_product'        => $request->id_product,
                'incoming_product'  => $request->incoming_product,
                'date_of_entry'     => $request->date_of_entry
            ]);

            $product        = product::where('id', $request->id_product)->first();

            product::where('id', $request->id_product)->update([
                'stock'     => $product->stock + $request->incoming_product
            ]);

            // Jika kedua insert berhasil, commit transaksi
            DB::commit();

            return response()->json([
                'success'   => true,
                'message'   => 'stock item created successfully'
            ], 200);
        } catch (\Exception $e) {

            // Jika ada kesalahan, batalkan transaksi
            DB::rollBack();

            return response()->json([
                'success'   => false,
                'message'   => 'Stock fails create',
                'errors'    => $validator->errors()
            ], 500);
        }
    }

    public function updateStock(Request $request, string $id)
    {
        $validator = validator::make($request->all(), [
            'incoming_product_old'  => 'required',
            'incoming_product'      => 'required',
            'date_of_entry'         => 'required'
        ]);

        // if ($validator) {
        //     return response()->json($validator->errors(), 422);
        // }

        DB::beginTransaction();

        try {

            incoming_product::where('id', $id)->update([
                'incoming_product'  => $request->incoming_product,
                'date_of_entry'     => $request->date_of_entry
            ]);

            $product        = product::where('id', $request->id_product)->first();

            product::where('id', $request->id_product)->update([
                'stock'     => ($product->stock - $request->incoming_product_old) + $request->date_of_entry
            ]);

            // Jika kedua insert berhasil, commit transaksi
            DB::commit();

            return response()->json([
                'success'   => true,
                'message'   => 'stock item updated successfully'
            ], 200);
        } catch (\Exception $e) {

            // Jika ada kesalahan, batalkan transaksi
            DB::rollBack();

            return response()->json([
                'success'   => false,
                'message'   => 'Stock fails update',
                'errors'    => $validator->errors()
            ]);
        }
    }

    public function deleteStock($id, $id_product)
    {
        DB::beginTransaction();

        try {

            incoming_product::where('id', $id)->delete();
            product::where('id', $id)->delete();

            // Jika kedua insert berhasil, commit transaksi
            DB::commit();

            return response()->json([
                'success'   => true,
                'message'   => 'Stock deleted successfully'
            ]);
        } catch (\Exception $e) {

            // Jika ada kesalahan, batalkan transaksi
            DB::rollBack();

            return response()->json([
                'success'   => false,
                'message'   => 'Stock fails delete'
            ]);
        }
    }
}
