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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->string('gmail')->nullable();
            $table->string('password');
            $table->bigInteger('role')->unsigned();
            $table->index('role');
            $table->bigInteger('phone')->unique();
            $table->index('phone');
            $table->string('social_type')->nullable();
            $table->string('social_id')->nullable();
            $table->string('profile_photo');
            $table->timestamps();
            $table->timestamp('email_verified_at')->nullable();
        //  $table->rememberToken();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
