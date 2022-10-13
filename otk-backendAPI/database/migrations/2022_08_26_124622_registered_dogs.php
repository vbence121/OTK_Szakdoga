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
        Schema::create('registered_dogs', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('dog_id')->constrained()->onDelete('cascade');
            $table->foreignId('dog_judging_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('event_category_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id');
            $table->foreignId('dog_class_id');
            $table->string('status');
            $table->boolean('selected');
            $table->string('declined_reason')->nullable();
            $table->foreignId('start_number')->nullable();
            $table->foreignId('award')->nullable();
            $table->foreignId('title')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('registered_dogs');
    }
};
