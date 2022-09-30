<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('possible_awards', function (Blueprint $table) {
            $table->id();
            $table->string('name');
        });

        DB::table('possible_awards')->insert([
            ['name' => 'Nagyon igéretes'],
            ['name' => 'Igéretes'],
            ['name' => 'Nem igéretes'],
            ['name' => 'Nem bírálható'],
            ['name' => 'Kitűnő'],
            ['name' => 'Nagyon jó'],
            ['name' => 'Jó'],
            ['name' => 'Megfelelő'],
            ['name' => 'Kizárva'],
            ['name' => 'Nem bírálható'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('possible_awards');
    }
};
