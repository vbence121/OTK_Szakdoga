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
            $table->boolean('hobby');
            $table->date('birthdate');
            $table->string('gender');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('breederName');
            $table->string('description')->nullable();
            $table->string('motherName')->nullable();
            $table->string('fatherName')->nullable();
            $table->foreignId('breed_id')->constrained()->onDelete('cascade');
            $table->string('registerSernum')->unique()->nullable();
            $table->foreignId('herd_book_type_id')->constrained()->onDelete('cascade');
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
