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
        Schema::create('purching_c_f_p_s', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('machine_seller_id')->unsigned()->nullable();
            $table->index('machine_seller_id');
            $table->bigInteger('machine_buyer_id')->unsigned()->nullable();
            $table->index('machine_buyer_id');
            $table->bigInteger('carbon_footprint')->unsigned()->nullable();
            $table->index('carbon_footprint');
            $table->bigInteger('expire')->unsigned()->default(1);
            $table->index('expire');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purching_c_f_p_s');
    }
};
