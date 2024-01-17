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
        Schema::create('expedisis', function (Blueprint $table) {
            $table->id();
            $table->string('expedisi_name');
            $table->integer('start_estimasi');
            $table->integer('end_estimasi');
            $table->double('shipping_cost');
            $table->integer('distance');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expedisis');
    }
};
