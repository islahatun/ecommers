<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\exit_product;
use App\Models\transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class transactiosController extends Controller
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
        //
    }

    public function transactionProduct(Request $request){

        $validator = validator::make($request->all(),[
            "data.*.user_id"            => 'required',
            "data.*.product_id"         => 'required',
            "data.*.package_id"         => 'required',
            "data.*.expedisi_id"        => 'required',
            "data.*.order_date"         => 'required',
            "data.*.count"              => 'required',
            "data.*.status_of_payment"  => 'required',
            "data.*.proof_of_payment"   => 'required',
            "data.*.estimasi"           => 'required',
            "data.*.no_rekening"        => 'required',
            "data.*.status_order"       => 'required',
            "data.*.shipping_cost"      => 'required'
        ]);

        // if($validator->fails()){
        //     return response()->json($validator->errors(),422);
        // }



        DB::beginTransaction();
        try{

            transaction::insert($request->input('data'));
            $exitProductData    = array_map(function($item){
                return [
                    'product_id'    => $item['product_id'],
                    'count'         => $item['count']
                ]

                ;
            },$request->input('data'));

            exit_product::insert($exitProductData);

            DB::commit();

            return response()->json([
                'success'   => true,
                'message'   => 'transaction was created successfully'
            ],200);

        }catch (\Exception $e){

            DB::rollBack();

            return response()->json([
                'success'   => false,
                'message'   => 'transaction failed to create',
                'error'     => $validator->errors()
            ],200);

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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
