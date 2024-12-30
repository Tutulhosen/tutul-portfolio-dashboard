<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserProfilesTable extends Migration
{
    public function up()
    {
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); 
            $table->string('phone')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('designation')->nullable();
            $table->text('short_description')->nullable();
            $table->string('logo')->nullable(); 
            $table->string('profile_picture')->nullable(); 
            $table->string('resume')->nullable();
            $table->string('github')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('twitter')->nullable();
            $table->string('facebook')->nullable();
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_profiles');
    }
}
