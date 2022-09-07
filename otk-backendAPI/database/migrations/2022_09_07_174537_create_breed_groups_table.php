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
        Schema::create('breed_groups', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('herd_book_type_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });

        DB::table('breed_groups')->insert([
            ['name' => 'FCI I.', 'herd_book_type_id' => 1],
            ['name' => 'FCI II.', 'herd_book_type_id' => 1],
            ['name' => 'FCI III.', 'herd_book_type_id' => 1],
            ['name' => 'FCI IV.', 'herd_book_type_id' => 1],
            ['name' => 'FCI V.', 'herd_book_type_id' => 1],
            ['name' => 'FCI VI.', 'herd_book_type_id' => 1],
            ['name' => 'FCI VII.', 'herd_book_type_id' => 1],
            ['name' => 'FCI VIII.', 'herd_book_type_id' => 1],
            ['name' => 'FCI IX.', 'herd_book_type_id' => 1],
            ['name' => 'FCI X.', 'herd_book_type_id' => 1],
            ['name' => 'KÜLÖNLEGES', 'herd_book_type_id' => 1],
            ['name' => 'fajtanélküli', 'herd_book_type_id' => 1],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('breed_groups');
    }
};
