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
        Schema::create('dog_judgings', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name');
            $table->boolean('hobby');
            $table->date('birthdate');
            $table->string('gender');
            $table->foreignId('user_id');
            $table->foreignId('dog_id')->unique();
            $table->string('breederName');
            $table->string('motherName')->nullable();
            $table->string('fatherName')->nullable();
            $table->foreignId('breed_id')->constrained();
            $table->string('registerSernum')->nullable();
            $table->foreignId('herd_book_type_id')->constrained();

            $table->foreignId('event_category_id')->constrained();
            $table->string('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dog_judgings');
    }
};
