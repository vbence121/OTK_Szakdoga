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
        Schema::create('possible_titles', function (Blueprint $table) {
            $table->id();
            $table->string('name');

            DB::table('dog_class_possible_awards')->insert([
                ['name' => 'W-HU MKSZ Puppy I.'],
                ['name' => 'W-HU MKSZ Puppy II.'],
                ['name' => 'W-HU MKSZ Puppy III.'],
                ['name' => 'W-HU MKSZ Puppy IV.'],
                ['name' => 'W-HU MKSZ Puppy V.'],

                ['name' => 'W-HU MKSZ HPJY'],
                ['name' => 'W-HU MKSZ HPJ'],
                ['name' => 'W-HU MKSZ CAC'],
                ['name' => 'W-HU MKSZ Res. CAC'],
                
                ['name' => 'W-HU MKSZ HPJCH'],
                ['name' => 'W-HU MKSZ Res. HPJCH'],

                ['name' => 'W-HU MKSZ CACWin'],
                ['name' => 'W-HU MKSZ Res. CACWin'],

                ['name' => 'W-HU MKSZ CACVetCH'],
                ['name' => 'W-HU MKSZ Res. CACVetCH'],

                ['name' => 'WCHSA-HU MKSZ BOB/HFGY'],
                ['name' => 'WCHSA-HU MKSZ BOS'],
            ]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('possible_titles');
    }
};
