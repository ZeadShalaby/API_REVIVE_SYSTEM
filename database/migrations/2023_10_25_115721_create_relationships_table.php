







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

            $table->foreign('user_id')->references('id')->on('users');            

        });

        Schema::table('favourites', function (Blueprint $table) {

            $table->foreign('posts_id')->references('id')->on('posts');

            $table->foreign('user_id')->references('id')->on('users');

        });

        Schema::table('comments', function (Blueprint $table) {

            $table->foreign('posts_id')->references('id')->on('posts');

            $table->foreign('user_id')->references('id')->on('users');

        });

        Schema::table('follows', function (Blueprint $table) {

            $table->foreign('following_id')->references('id')->on('users');

            $table->foreign('followers_id')->references('id')->on('users');

        });

        Schema::table('machines', function (Blueprint $table) {

            $table->foreign('owner_id')->references('id')->on('users');

        });

        Schema::table('revives', function (Blueprint $table) {

            $table->foreign('machine_id')->references('id')->on('machines');

        });

        Schema::table('tourisms', function (Blueprint $table) {

            $table->foreign('machine_id')->references('id')->on('machines');

        });

        Schema::table('filemachines', function (Blueprint $table) {

            $table->foreign('user_id')->references('id')->on('users');

        });


        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('relationships');
    }
};
