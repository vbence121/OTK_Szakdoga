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
        Schema::create('hobby_categories', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('type');
            $table->foreignId('category_id');
        });

        DB::table('hobby_categories')->insert([
            ['type' => 'hagyományos', 'category_id' => 4],
            ['type' => 'extra', 'category_id' => 4],
            ['type' => 'különleges', 'category_id' => 4],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hobby_categories');
    }
};
