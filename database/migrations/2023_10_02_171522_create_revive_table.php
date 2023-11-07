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
            $table->bigInteger('machine_id')->unsigned();
            $table->index('machine_id');
            $table->bigInteger('co2')->unsigned();
            $table->index('co2');
            $table->bigInteger('o2')->unsigned();
            $table->index('o2');
            $table->bigInteger('degree')->unsigned();
            $table->index('degree');
            $table->bigInteger('expire')->unsigned()->default(0);
            $table->index('expire');
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
