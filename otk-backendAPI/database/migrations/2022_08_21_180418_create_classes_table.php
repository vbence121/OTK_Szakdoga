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
            ['type' => 'Bébi'],
            ['type' => 'Kölyök/Puppy'],
            ['type' => 'Fiatal (YOUNGER)'],
            ['type' => 'Fiatal (YOUNG)'],
            ['type' => 'Junior Champion'],
            ['type' => 'Növendék'],
            ['type' => 'Nyílt'],
            ['type' => 'Munka'],
            ['type' => 'Champion/Bajnok'],
            ['type' => 'Győztes/Winners'],
            ['type' => 'veterán'],
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
