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
        Schema::create('purchasing_carbon_footprint', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('machine_id')->unsigned();
            $table->index('machine_id');
            $table->bigInteger('seller_id')->unsigned()->nullable();
            $table->index('seller_id');
            $table->bigInteger('buyer_id')->unsigned()->nullable();
            $table->index('buyer_id');
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
        Schema::dropIfExists('purchasing_carbon_footprint');
    }
};
