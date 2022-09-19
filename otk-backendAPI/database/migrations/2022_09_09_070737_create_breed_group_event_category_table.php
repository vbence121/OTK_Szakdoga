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
        Schema::create('breed_group_event_category', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('breed_group_id');
            $table->foreignId('event_category_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('breed_group_event_category');
    }
};
