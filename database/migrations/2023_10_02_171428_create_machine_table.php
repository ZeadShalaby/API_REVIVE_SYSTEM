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
        Schema::create('machines', function (Blueprint $table) {
            $table->id();// ! to start in value ->startingValue(1755) //
            $table->string("name")->unique();
            $table->bigInteger('owner_id')->unsigned();
            $table->index('owner_id');
            $table->string('location')->unique();
            $table->bigInteger('type')->unsigned();
            $table->index('type');
            $table->bigInteger('warning')->unsigned()->nullable();
            $table->index('warning');
            $table->bigInteger('carbon_footprint')->unsigned()->nullable();
            $table->index('carbon_footprint');
            $table->bigInteger('total_CF')->unsigned()->nullable(); // ? total of carbon fotprint
            $table->index('total_CF');
            $table->string("weather")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('machines');
    }
};
