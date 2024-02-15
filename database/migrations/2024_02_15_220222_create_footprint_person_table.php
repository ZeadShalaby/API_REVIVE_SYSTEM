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
        Schema::create('footprintpeople', function (Blueprint $table) {
            $table->id();// ! to start in value ->startingValue(1755) //
            $table->bigInteger('user_id')->unsigned();
            $table->index('user_id');
            $table->bigInteger('carbon_footprint')->unsigned();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('footprintpeople');

    }
};
