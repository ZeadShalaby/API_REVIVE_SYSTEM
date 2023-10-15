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

        Schema::table('follow', function (Blueprint $table) {

            $table->foreign('following_id')->references('id')->on('users');

            $table->foreign('followers_id')->references('id')->on('users');

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
