<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dogs', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name');
            $table->string('breed');
            $table->boolean('hobby');
            $table->date('birthdate');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('breederName');
            $table->string('description')->nullable();
            $table->string('motherName')->nullable();
            $table->string('fatherName')->nullable();
            $table->string('category');
            $table->string('registerSernum')->unique();
            $table->string('registerType');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dogs');
    }
};
