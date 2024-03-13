<?php

use App\Models\Role;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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

        Schema::table('saved_posts', function (Blueprint $table) {

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

        Schema::table('footprintpeople', function (Blueprint $table) {

            $table->foreign('user_id')->references('id')->on('users');

        });

        Schema::table('footprintfactories', function (Blueprint $table) {

            $table->foreign('machine_id')->references('id')->on('machines');

        });

        Schema::table('purching_c_f_p_s', function (Blueprint $table) {


            $table->foreign('machine_seller_id')->references('id')->on('machines');
            
            $table->foreign('machine_buyer_id')->references('id')->on('machines');

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
