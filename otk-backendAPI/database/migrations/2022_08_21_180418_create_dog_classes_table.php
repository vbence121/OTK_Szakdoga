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
        Schema::create('dog_classes', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('type');
            $table->integer('range_start'); // in months
            $table->integer('range_end');   // in months
        });

        DB::table('dog_classes')->insert([
            ['type' => 'Bébi', 'range_start' => '3', 'range_end' => '6'],
            ['type' => 'Kölyök/Puppy', 'range_start' => '6', 'range_end' => '9'],
            ['type' => 'Fiatal (YOUNGER)', 'range_start' => '9', 'range_end' => '12'],
            ['type' => 'Fiatal (YOUNG)', 'range_start' => '12', 'range_end' => '18'],
            ['type' => 'Junior Champion', 'range_start' => '9', 'range_end' => '15'],
            ['type' => 'Növendék', 'range_start' => '15', 'range_end' => '24'],
            ['type' => 'Nyílt', 'range_start' => '15', 'range_end' => '9999'],
            ['type' => 'Munka', 'range_start' => '15', 'range_end' => '9999'],
            ['type' => 'Champion/Bajnok', 'range_start' => '15', 'range_end' => '999'],
            ['type' => 'Győztes/Winners', 'range_start' => '18', 'range_end' => '999'],
            ['type' => 'Veterán', 'range_start' => '84', 'range_end' => '999'],
            ['type' => 'Veterán győztes/Veteran champions', 'range_start' => '84', 'range_end' => '999'],
            ['type' => 'klubchampion', 'range_start' => '0', 'range_end' => '999'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dog_classes');
    }
};
