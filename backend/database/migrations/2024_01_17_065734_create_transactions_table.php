<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('product_id');
            $table->foreignId('package_id');
            $table->foreignId('expedisi_id');
            $table->foreignId('bank_id');
            $table->string('no_order');
            $table->date('order_date');
            $table->integer('count');
            $table->double('total',18,2);
            $table->enum('status_of_payment',['Y','N']);
            $table->string('proof_of_payment')->nullable();
            $table->string('no_resi')->nullable();
            $table->string('estimasi')->nullable();
            $table->string('no_rekening')->nullable();
            $table->integer('status_order')->nullable();
            $table->double('shipping_cost',18,2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
