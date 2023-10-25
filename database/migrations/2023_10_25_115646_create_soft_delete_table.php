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
        Schema::table('posts', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('tourisms', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('revives', function (Blueprint $table) {
            $table->softDeletes();
        });

       /* Schema::table('users', function (Blueprint $table) {
            $table->softDeletes();
        });*/
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('soft_delete');
    }
};
