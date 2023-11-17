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
