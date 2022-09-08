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
        Schema::create('classes', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('type');
        });

        DB::table('classes')->insert([
            ['type' => 'bébi'],
            ['type' => 'kölyök'],
            ['type' => 'fiatal'],
            ['type' => 'növendék'],
            ['type' => 'nyílt'],
            ['type' => 'munka'],
            ['type' => 'bajnok'],
            ['type' => 'veterán'],
            ['type' => 'klubchampion'],

        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('classes');
    }
};
