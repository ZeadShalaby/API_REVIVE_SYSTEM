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
        Schema::create('revives', function (Blueprint $table) {
            $table->id();
            $table->string("name")->unique();
            $table->bigInteger('owner_id')->unsigned();
            $table->index('owner_id');
            $table->string('location')->unique();
            $table->bigInteger('co2')->unsigned();
            $table->index('co2');
            $table->bigInteger('o2')->unsigned();
            $table->index('o2');
            $table->bigInteger('degree')->unsigned();
            $table->index('degree');
            $table->timestamps();
        });
    }
   
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('revives');
    }
};
