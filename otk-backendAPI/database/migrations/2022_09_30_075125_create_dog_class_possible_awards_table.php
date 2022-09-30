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
        Schema::create('dog_class_possible_awards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dog_class_id')->constrained('possible_awards','id');
            $table->foreignId('possible_awards_id')->constrained('dog_classes','id');
        });

        DB::table('dog_class_possible_awards')->insert([
            ['dog_class_id' => 1, 'possible_awards_id' => 1],
            ['dog_class_id' => 2, 'possible_awards_id' => 1],
            ['dog_class_id' => 3, 'possible_awards_id' => 1],
            ['dog_class_id' => 4, 'possible_awards_id' => 1],

            ['dog_class_id' => 1, 'possible_awards_id' => 2],
            ['dog_class_id' => 2, 'possible_awards_id' => 2],
            ['dog_class_id' => 3, 'possible_awards_id' => 2],
            ['dog_class_id' => 4, 'possible_awards_id' => 2],

            ['dog_class_id' => 5,  'possible_awards_id' => 3],
            ['dog_class_id' => 6,  'possible_awards_id' => 3],
            ['dog_class_id' => 7,  'possible_awards_id' => 3],
            ['dog_class_id' => 8,  'possible_awards_id' => 3],
            ['dog_class_id' => 9,  'possible_awards_id' => 3],
            ['dog_class_id' => 10, 'possible_awards_id' => 3],
            
            ['dog_class_id' => 5,  'possible_awards_id' => 4],
            ['dog_class_id' => 6,  'possible_awards_id' => 4],
            ['dog_class_id' => 7,  'possible_awards_id' => 4],
            ['dog_class_id' => 8,  'possible_awards_id' => 4],
            ['dog_class_id' => 9,  'possible_awards_id' => 4],
            ['dog_class_id' => 10, 'possible_awards_id' => 4],
            
            ['dog_class_id' => 5,  'possible_awards_id' => 5],
            ['dog_class_id' => 6,  'possible_awards_id' => 5],
            ['dog_class_id' => 7,  'possible_awards_id' => 5],
            ['dog_class_id' => 8,  'possible_awards_id' => 5],
            ['dog_class_id' => 9,  'possible_awards_id' => 5],
            ['dog_class_id' => 10, 'possible_awards_id' => 5],

            ['dog_class_id' => 5,  'possible_awards_id' => 6],
            ['dog_class_id' => 6,  'possible_awards_id' => 6],
            ['dog_class_id' => 7,  'possible_awards_id' => 6],
            ['dog_class_id' => 8,  'possible_awards_id' => 6],
            ['dog_class_id' => 9,  'possible_awards_id' => 6],
            ['dog_class_id' => 10, 'possible_awards_id' => 6],

            ['dog_class_id' => 5,  'possible_awards_id' => 7],
            ['dog_class_id' => 6,  'possible_awards_id' => 7],
            ['dog_class_id' => 7,  'possible_awards_id' => 7],
            ['dog_class_id' => 8,  'possible_awards_id' => 7],
            ['dog_class_id' => 9,  'possible_awards_id' => 7],
            ['dog_class_id' => 10, 'possible_awards_id' => 7],

            ['dog_class_id' => 5,  'possible_awards_id' => 9],
            ['dog_class_id' => 6,  'possible_awards_id' => 9],
            ['dog_class_id' => 7,  'possible_awards_id' => 9],
            ['dog_class_id' => 8,  'possible_awards_id' => 9],
            ['dog_class_id' => 9,  'possible_awards_id' => 9],
            ['dog_class_id' => 10, 'possible_awards_id' => 9],

            ['dog_class_id' => 5,  'possible_awards_id' => 10],
            ['dog_class_id' => 6,  'possible_awards_id' => 10],
            ['dog_class_id' => 7,  'possible_awards_id' => 10],
            ['dog_class_id' => 8,  'possible_awards_id' => 10],
            ['dog_class_id' => 9,  'possible_awards_id' => 10],
            ['dog_class_id' => 10, 'possible_awards_id' => 10],

            ['dog_class_id' => 5,  'possible_awards_id' => 11],
            ['dog_class_id' => 6,  'possible_awards_id' => 11],
            ['dog_class_id' => 7,  'possible_awards_id' => 11],
            ['dog_class_id' => 8,  'possible_awards_id' => 11],
            ['dog_class_id' => 9,  'possible_awards_id' => 11],
            ['dog_class_id' => 10, 'possible_awards_id' => 11],

            ['dog_class_id' => 5,  'possible_awards_id' => 12],
            ['dog_class_id' => 6,  'possible_awards_id' => 12],
            ['dog_class_id' => 7,  'possible_awards_id' => 12],
            ['dog_class_id' => 8,  'possible_awards_id' => 12],
            ['dog_class_id' => 9,  'possible_awards_id' => 12],
            ['dog_class_id' => 10, 'possible_awards_id' => 12],

            ['dog_class_id' => 5,  'possible_awards_id' => 13],
            ['dog_class_id' => 6,  'possible_awards_id' => 13],
            ['dog_class_id' => 7,  'possible_awards_id' => 13],
            ['dog_class_id' => 8,  'possible_awards_id' => 13],
            ['dog_class_id' => 9,  'possible_awards_id' => 13],
            ['dog_class_id' => 10, 'possible_awards_id' => 13],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dog_class_possible_awards');
    }
};
