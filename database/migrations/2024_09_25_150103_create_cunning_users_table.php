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
        Schema::create('cunning_users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('photo')->nullable();
            $table->string('location')->nullable();
            $table->string('country')->nullable();
            $table->bigInteger('coin')->nullable();
            $table->integer('gem')->nullable();
            $table->integer('match')->nullable();
            $table->integer('win')->nullable();
            $table->integer('death')->nullable();
            $table->rememberToken();
            $table->timestamp('last_ping_time')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cunning_users');
    }
};
