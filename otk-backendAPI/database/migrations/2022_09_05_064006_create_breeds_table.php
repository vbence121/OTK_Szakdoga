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
        Schema::create('breeds', function (Blueprint $table) {
            $table->id();
            $table->string('group');
            $table->string('section');
            $table->string('type');
            $table->timestamps();
        });

        DB::table('breeds')->insert([
            ['group' => 'Juhász és pásztorkutyák',
            'section' => 'Juhászkutyák',
            'type' => 'Juhászkutyák'],
            ['group' => 'Juhász és pásztorkutyák',
            'section' => 'Pásztorkutyák',
            'type' => 'Pásztorkutyák (kivéve svájci pásztorkutyák) '],

            ['group' => ' Pinscherek, schnauzerek - molosszerek - svájci hegyi- és pásztorkutyák',
            'section' => 'Pinscherek és schnauzerek',
            'type' => 'Pinscherek'],
             ['group' => ' Pinscherek, schnauzerek - molosszerek - svájci hegyi- és pásztorkutyák',
            'section' => 'Pinscherek és schnauzerek',
            'type' => 'Schnauzerek'],
             ['group' => ' Pinscherek, schnauzerek - molosszerek - svájci hegyi- és pásztorkutyák',
            'section' => 'Pinscherek és schnauzerek',
            'type' => 'Smoushond'],
            ['group' => ' Pinscherek, schnauzerek - molosszerek - svájci hegyi- és pásztorkutyák',
            'section' => 'Pinscherek és schnauzerek',
            'type' => 'Fekete terrier'],
            ['group' => ' Pinscherek, schnauzerek - molosszerek - svájci hegyi- és pásztorkutyák',
            'section' => 'Molosszerek',
            'type' => 'Masztiff típusú kutyák'],
            ['group' => ' Pinscherek, schnauzerek - molosszerek - svájci hegyi- és pásztorkutyák',
            'section' => 'Molosszerek',
            'type' => 'Hegyi típusú kutyák'],
            ['group' => ' Pinscherek, schnauzerek - molosszerek - svájci hegyi- és pásztorkutyák',
            'section' => 'Svájci hegyi- és pásztorkutyák ',
            'type' => 'Svájci hegyi- és pásztorkutyák '],


            ['group' => 'Terrierek',
            'section' => 'Nagy és közepes méretű terrierek',
            'type' => 'Nagy és közepes méretű terrierek'],
            ['group' => 'Terrierek',
            'section' => 'Kis méretű terrierek ',
            'type' => 'Kis méretű terrierek '],
            ['group' => 'Terrierek',
            'section' => 'Bull típusú terrierek',
            'type' => 'Bull típusú terrierek'],
            ['group' => 'Terrierek',
            'section' => 'Apró méretű terrierek ',
            'type' => 'Apró méretű terrierek '],

            ['group' => 'Tacskók',
            'section' => 'Tacskók',
            'type' => 'Tacskók'],

            ['group' => 'Spiccek és ősi típusú kutyák',
            'section' => 'Északi szánhúzó kutyák',
            'type' => 'Északi szánhúzó kutyák'],
            ['group' => 'Spiccek és ősi típusú kutyák',
            'section' => 'Északi vadászkutyák ',
            'type' => ' Északi vadászkutyák '],
            ['group' => 'Spiccek és ősi típusú kutyák',
            'section' => 'Északi őrző- és terelőkutyák ',
            'type' => 'Északi őrző- és terelőkutyák '],
            ['group' => 'Spiccek és ősi típusú kutyák',
            'section' => 'Európai spiccek',
            'type' => 'Európai spiccek'],
            ['group' => 'Spiccek és ősi típusú kutyák',
            'section' => 'Ázsiai spiccek és rokon fajták',
            'type' => 'Ázsiai spiccek és rokon fajták'],
            ['group' => 'Spiccek és ősi típusú kutyák',
            'section' => 'Ősi típusú kutyák',
            'type' => 'Ősi típusú kutyák'],
            ['group' => 'Spiccek és ősi típusú kutyák',
            'section' => 'Ősi típusú vadászkutyák',
            'type' => 'Ősi típusú vadászkutyák'],
            ['group' => 'Spiccek és ősi típusú kutyák',
            'section' => 'Ősi típusú vadászkutyák hátukon csíkkal',
            'type' => 'Ősi típusú vadászkutyák hátukon csíkkal'],
             
            ['group' => 'Kopók és rokon fajták',
            'section' => 'Kopók',
            'type' => 'Nagy méretű kopók'],
            ['group' => 'Kopók és rokon fajták',
            'section' => 'Kopók',
            'type' => 'Közepes méretű kopók'],
            ['group' => 'Kopók és rokon fajták',
            'section' => 'Kopók',
            'type' => 'Kis méretű kopók'],
            ['group' => 'Kopók és rokon fajták',
            'section' => 'Vérebek',
            'type' => 'Vérebek'],
            ['group' => 'Kopók és rokon fajták',
            'section' => 'Rokon fajták',
            'type' => 'Rokon fajták'],

            ['group' => 'Vizslák és szetterek',
            'section' => 'Kontinentális vizslák',
            'type' => 'Kontinentális vizsla típusúak'],
            ['group' => 'Vizslák és szetterek',
            'section' => 'Kontinentális vizslák',
            'type' => 'Spániel típusúak'],
            ['group' => 'Vizslák és szetterek',
            'section' => 'Kontinentális vizslák',
            'type' => 'Griffon típusúak'],
            ['group' => 'Vizslák és szetterek',
            'section' => 'Brit és ír vizslák és szetterek',
            'type' => 'Pointerek'],
            ['group' => 'Vizslák és szetterek',
            'section' => 'Brit és ír vizslák és szetterek',
            'type' => 'Szetterek'],

            ['group' => 'Retrieverek - hajtókutyák - vízi vadászok',
            'section' => 'Retrieverek',
            'type' => 'Retrieverek'],
            ['group' => 'Retrieverek - hajtókutyák - vízi vadászok',
            'section' => 'Hajtókutyák',
            'type' => 'Hajtókutyák'],
            ['group' => 'Retrieverek - hajtókutyák - vízi vadászok',
            'section' => 'Vízi vadászok',
            'type' => 'Vízi vadászok'],

            ['group' => 'Társasági kutyák',
            'section' => 'Bichonok és rokon fajták',
            'type' => 'Bichonok'],
            ['group' => 'Társasági kutyák',
            'section' => 'Bichonok és rokon fajták',
            'type' => 'Coton de Tuléar'],
            ['group' => 'Társasági kutyák',
            'section' => 'Bichonok és rokon fajták',
            'type' => 'Kis oroszlánkutya'],
            ['group' => 'Társasági kutyák',
            'section' => 'Uszkárok',
            'type' => 'Uszkárok'],
            ['group' => 'Társasági kutyák',
            'section' => 'Kis méretű belga kutyák',
            'type' => 'Griffonok'],
            ['group' => 'Társasági kutyák',
            'section' => 'Kis méretű belga kutyák',
            'type' => 'Petit Brabançon'],
            ['group' => 'Társasági kutyák',
            'section' => 'Meztelen kutyák',
            'type' => 'Meztelen kutyák'],
            ['group' => 'Társasági kutyák',
            'section' => 'Tibeti fajták',
            'type' => 'Tibeti fajták'],
            ['group' => 'Társasági kutyák',
            'section' => 'Csivavák',
            'type' => 'Csivavák'],
            ['group' => 'Társasági kutyák',
            'section' => 'Angol apró termetű spániel',
            'type' => 'Angol apró termetű spániel'],
            ['group' => 'Társasági kutyák',
            'section' => 'Japán csin és pekingi palotakutya',
            'type' => 'Japán csin és pekingi palotakutya'],
            ['group' => 'Társasági kutyák',
            'section' => 'Kontinentális apró termetű spániel',
            'type' => 'Kontinentális apró termetű spániel'],
            ['group' => 'Társasági kutyák',
            'section' => 'Kromfohrländer',
            'type' => 'Kromfohrländer'],
            ['group' => 'Társasági kutyák',
            'section' => 'Kis termetű, molosszer típusú kutyák',
            'type' => 'Kis termetű, molosszer típusú kutyák'],

            ['group' => 'Agarak',
            'section' => 'Hosszúszőrű agarak',
            'type' => 'Hosszúszőrű agarak'],
            ['group' => 'Agarak',
            'section' => 'Drótszőrű agarak',
            'type' => 'Drótszőrű agarak'],
            ['group' => 'Agarak',
            'section' => 'Rövidszőrű agarak',
            'type' => 'Rövidszőrű agarak'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('breeds');
    }
};
