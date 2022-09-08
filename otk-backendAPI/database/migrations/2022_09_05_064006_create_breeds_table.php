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
            $table->string('breed');
            $table->string('type');
            $table->timestamps();
        });

        DB::table('breeds')->insert(
            [
                [
                    'type' => 'FCI',
                    'group' => 'FCI I.',
                    'breed' => 'AUSZTRÁLIAI JUHÁSZKUTYA'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI I.',
                    'breed' => 'BEARDED COLLIE'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI I.',
                    'breed' => 'BELGA JUHÁSZKUTYA, GROENENDAEL'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI I.',
                    'breed' => 'BELGA JUHÁSZKUTYA, LAEKENOIS'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI I.',
                    'breed' => 'BELGA JUHÁSZKUTYA, MALINOIS'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI I.',
                    'breed' => 'BELGA JUHÁSZKUTYA, TERVUEREN'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI I.',
                    'breed' => 'BERGAMASCO'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI I.',
                    'breed' => 'BERGER DE BEAUCE'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI I.',
                    'breed' => 'BERGER DE BRIE'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI I.',
                    'breed' => 'BERGER DE PICARDE'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI I.',
                    'breed' => 'BERGER DE PYRENÉES'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI I.',
                    'breed' => 'BOBTAIL'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI I.',
                    'breed' => 'BORDER COLLIE'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI I.',
                    'breed' => 'COLLIE, hosszúszőrű'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI I.',
                    'breed' => 'COLLIE, rövidszőrű'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI I.',
                    'breed' => 'CSEH FARKASKUTYA'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI I.',
                    'breed' => 'DÉLOROSZ JUHÁSZKUTYA'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI I.',
                    'breed' => 'FLANDRIAI BOUVIER'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI I.',
                    'breed' => 'KOMONDOR'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI I.',
                    'breed' => 'KUVASZ'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI I.',
                    'breed' => 'LENGYEL ALFÖLDI JUHÁSZKUTYA'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI I.',
                    'breed' => 'LENGYEL HEGYI KUTYA'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI I.',
                    'breed' => 'MAREMMANO'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI I.',
                    'breed' => 'MINIATURE AMERICAN SHEPHERD'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI I.',
                    'breed' => 'MUDI'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI I.',
                    'breed' => 'NÉMET JUHÁSZKUTYA normál'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI I.',
                    'breed' => 'NÉMET JUHÁSZKUTYA hosszúszőrű'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI I.',
                    'breed' => '* PULI, fehér'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI I.',
                    'breed' => '* PULI, fekete'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI I.',
                    'breed' => '* KOMONDOR'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI I.',
                    'breed' => '* KUVASZ'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI I.',
                    'breed' => 'PULI, fekete'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI I.',
                    'breed' => 'PULI, fehér'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI I.',
                    'breed' => 'PULI, maszkos fakó'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI I.',
                    'breed' => 'PULI, szürke'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI I.',
                    'breed' => 'PUMI'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI I.',
                    'breed' => 'SCHAPENDOES'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI I.',
                    'breed' => 'CHIPPERKE'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI I.',
                    'breed' => 'SHELTIE'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI I.',
                    'breed' => 'SVÁJCI FEHÉR JUHÁSZKUTYA'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI I.',
                    'breed' => 'WELSH CORGI, CARDIGAN'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI I.',
                    'breed' => 'WELSH CORGI, PEMBR'
                ],

                [
                    'type' => 'FCI',
                    'group' => 'FCI II.',
                    'breed' => 'AFFENPINSCHER'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI II.',
                    'breed' => 'AIDI'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI II.',
                    'breed' => 'ANGOL BULLDOG'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI II.',
                    'breed' => 'ANGOL MASZTIFF'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI II.',
                    'breed' => 'APPENZELLNER'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI II.',
                    'breed' => 'ARGENTIN DOG'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI II.',
                    'breed' => 'BERNI PÁSZTORKUTYA'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI II.',
                    'breed' => 'BORDEAUX-I DOG'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI II.',
                    'breed' => 'BOXER, csíkos'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI II.',
                    'breed' => 'BOXER, sárga'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI II.',
                    'breed' => 'BULLMASZTIFF'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI II.',
                    'breed' => 'CANE CORSO'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI II.',
                    'breed' => 'DOBERMANN, barna'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI II.',
                    'breed' => 'DOBERMANN, Fekete-cser'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI II.',
                    'breed' => 'FILA BRASILEIRO'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI II.',
                    'breed' => 'HOVAWART'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI II.',
                    'breed' => 'KAUKÁZUSI JUHÁSZKUTYA'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI II.',
                    'breed' => 'KÖZÉP-ÁZSIAI JUHÁSZKUTYA'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI II.',
                    'breed' => 'LANDSEER'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI II.',
                    'breed' => 'LEONBERGER'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI II.',
                    'breed' => '* MOSZKVAI ŐRKUTYA'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI II.',
                    'breed' => 'MAJORCA MASTIFF'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI II.',
                    'breed' => 'MASTINO NAPOLETANO'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI II.',
                    'breed' => 'NÉMET DOG, csíkos'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI II.',
                    'breed' => 'NÉMET DOG, fekete'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI II.',
                    'breed' => 'NÉMET DOG, foltos'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI II.',
                    'breed' => 'NÉMET DOG, kék'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI II.',
                    'breed' => 'NÉMET DOG, sárga'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI II.',
                    'breed' => 'NÉMET PINSCHER'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI II.',
                    'breed' => 'NÉMET PINSCHER, TÖRPE'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI II.',
                    'breed' => 'OROSZ FEKETE TERRIER'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI II.',
                    'breed' => 'OSZTRÁK PINSCHER'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI II.',
                    'breed' => 'PIRENEUSI HEGYIKUTYA'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI II.',
                    'breed' => 'ROTTWEILER'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI II.',
                    'breed' => 'SARPLANINAC'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI II.',
                    'breed' => 'SCHNAUZER, ÓRIÁS, fekete'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI II.',
                    'breed' => 'SCHNAUZER, ÓRIÁS, só-bors'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI II.',
                    'breed' => 'SCHNAUZER, STANDARD, fekete'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI II.',
                    'breed' => 'SCHNAUZER, STANDARD, só-bors'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI II.',
                    'breed' => 'SCHNAUZER, TÖRPE, fehér'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI II.',
                    'breed' => 'SCHNAUZER, TÖRPE, fekete'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI II.',
                    'breed' => 'SCHNAUZER, TÖRPE, fekete-ezüst'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI II.',
                    'breed' => 'SCHNAUZER, TÖRPE, só-bors'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI II.',
                    'breed' => 'SHAR-PEI'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI II.',
                    'breed' => 'SZENT BERNÁTHEGYI, hosszúszőrű'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI II.',
                    'breed' => 'SZENT BERNÁTHEGYI, rövidszőrű'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI II.',
                    'breed' => 'TIBETI MASZTIFF'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI II.',
                    'breed' => 'ÚJFUNDLANDI'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI III.',
                    'breed' => 'AIREDALE TERRIER'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI III.',
                    'breed' => 'AMERIKAI STAFFORDSHIRE TERRIER'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI III.',
                    'breed' => 'ANGOL BULLTERRIER'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI III.',
                    'breed' => 'ANGOL BULLTERRIER-MINIATŰR'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI III.',
                    'breed' => 'ANGOL STAFFORDSHIRE BULL TERRIER'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI III.',
                    'breed' => 'ANGOL TOY TERRIER'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI III.',
                    'breed' => 'AUSZTRÁL TERRIER'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI III.',
                    'breed' => 'BEDLINGTON TERRIER'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI III.',
                    'breed' => 'BORDER TERRIER'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI III.',
                    'breed' => 'CAIRN TERRIER'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI III.',
                    'breed' => 'CESKY TERRIER'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI III.',
                    'breed' => 'DANDIE DIAMOND TERRIER'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI III.',
                    'breed' => 'FOXTERRIER, drótszőrű'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI III.',
                    'breed' => 'FOXTERRIER, simaszőrű'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI III.',
                    'breed' => 'GLEN OF IMMALE TERRIER'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI III.',
                    'breed' => 'ÍR TERRIER'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI III.',
                    'breed' => 'JACK RUSSEL TERRIER SIMASZŐRŰ'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI III.',
                    'breed' => 'JACK RUSSEL TERRIER SZÁLKÁSSZŐRŰ'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI III.',
                    'breed' => 'JAPÁN TERRIER'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI III.',
                    'breed' => 'KERRY-BLUE TERRIER'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI III.',
                    'breed' => 'LAKELAND TERRIER'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI III.',
                    'breed' => 'MANCHESTER TERRIER'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI III.',
                    'breed' => 'NÉMET JAGDTERRIER'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI III.',
                    'breed' => 'NORFOLK TERRIER'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI III.',
                    'breed' => 'NORWICH TERRIER'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI III.',
                    'breed' => 'PARSON RUSSELL TERRIER'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI III.',
                    'breed' => 'SEALYHAM TERRIER'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI III.',
                    'breed' => 'SILKY TERRIER'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI III.',
                    'breed' => 'SKÓT TERRIER'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI III.',
                    'breed' => 'SKYE TERRIER'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI III.',
                    'breed' => 'SOFT COATED WHEATEN TERRIER'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI III.',
                    'breed' => 'WELSH TERRIER'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI III.',
                    'breed' => 'WEST HIGHLAND WHITE TERRIER'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI III.',
                    'breed' => 'YORKSHIRE TERRIER'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI IV.',
                    'breed' => 'TACSKÓ, KANINCHEN, hosszúszőrű'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI IV.',
                    'breed' => 'TACSKÓ, KANINCHEN, rövidszőrű'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI IV.',
                    'breed' => 'TACSKÓ, KANINCHEN, szálkásszőrű'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI IV.',
                    'breed' => 'TACSKÓ, STANDARD, szálkásszőrű'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI IV.',
                    'breed' => 'TACSKÓ, STANDARD, hosszúszőrű'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI IV.',
                    'breed' => 'TACSKÓ, STANDARD, rövidszőrű'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI IV.',
                    'breed' => 'TACSKÓ, TÖRPE, hosszúszőrű'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI IV.',
                    'breed' => 'TACSKÓ, TÖRPE, rövidszőrű'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI IV.',
                    'breed' => 'TACSKÓ, TÖRPE, szálkásszőrű'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI V.',
                    'breed' => 'AKITA INU'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI V.',
                    'breed' => 'ALASZKAI MALAMUT'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI V.',
                    'breed' => 'AMERIKAI AKITA'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI V.',
                    'breed' => 'BASENJI'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI V.',
                    'breed' => 'CHOW-CHOW, HOSSZÚSZŐRŰ, fahéj'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI V.',
                    'breed' => 'CHOW-CHOW, HOSSZÚSZŐRŰ, fekete'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI V.',
                    'breed' => 'CHOW-CHOW, HOSSZÚSZŐRŰ, kék'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI V.',
                    'breed' => 'CHOW-CHOW, HOSSZÚSZŐRŰ, krém'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI V.',
                    'breed' => 'CHOW-CHOW, HOSSZÚSZŐRŰ, vörös'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI V.',
                    'breed' => 'CHOW-CHOW, RÖVIDSZŐRŰ, fahéj'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI V.',
                    'breed' => 'CHOW-CHOW, RÖVIDSZŐRŰ, fekete'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI V.',
                    'breed' => 'CHOW-CHOW, RÖVIDSZŐRŰ, kék'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI V.',
                    'breed' => 'CHOW-CHOW, RÖVIDSZŐRŰ, krém'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI V.',
                    'breed' => 'CHOW-CHOW, RÖVIDSZŐRŰ, vörös'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI V.',
                    'breed' => 'Cirneco dell\'Etna'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI V.',
                    'breed' => 'EURASIER'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI V.',
                    'breed' => 'FÁRAÓKUTYA'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI V.',
                    'breed' => 'FINN SPITZ'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI V.',
                    'breed' => 'GRÖNLANDI KUTYA'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI V.',
                    'breed' => 'HOKKAIDÓ'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI V.',
                    'breed' => 'IZLANDI JUHÁSZKUTYA'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI V.',
                    'breed' => 'JAPÁN SPITZ'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI V.',
                    'breed' => 'JÄMTHUND'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI V.',
                    'breed' => 'KAI'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI V.',
                    'breed' => 'KÁNAÁNKUTYA'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI V.',
                    'breed' => 'KARÉLIAI MEDVEKUTYA'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI V.',
                    'breed' => 'KEESHOND'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI V.',
                    'breed' => 'KOREAI JINDO KUTYA'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI V.',
                    'breed' => 'LAJKA'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI V.',
                    'breed' => 'LAPP PÁSZTORKUTYA'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI V.',
                    'breed' => 'LAPPKUTYA'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI V.',
                    'breed' => 'LUNDEHUND'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI V.',
                    'breed' => 'NORVÉG BUHUND'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI V.',
                    'breed' => 'NORVÉG ELKHOUND'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI V.',
                    'breed' => 'NÉMET KIS SPITZ'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI V.',
                    'breed' => 'NÉMET KÖZÉP SPITZ'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI V.',
                    'breed' => 'NÉMET NAGY SPITZ'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI V.',
                    'breed' => 'PERUI SZŐRTELEN KUTYA'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI V.',
                    'breed' => 'PHARAOH HOUND'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI V.',
                    'breed' => 'PODENCO CANARIO'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI V.',
                    'breed' => 'PODENCO IBICENCO'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI V.',
                    'breed' => 'POMERÁNIAI'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI V.',
                    'breed' => 'SAMOYEDE'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI V.',
                    'breed' => 'SHIBA INU'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI V.',
                    'breed' => 'SHIKOKU'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI V.',
                    'breed' => 'SZIBÉRIAI HUSKY'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI V.',
                    'breed' => 'THAI BANGKAEW DOG'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI V.',
                    'breed' => 'THAI RIDGEBACK'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI V.',
                    'breed' => 'VOLPINO ITALIANO'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI V.',
                    'breed' => 'WOLFSPITZ '
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI VI.',
                    'breed' => 'AMERIKAI FOXHOUND'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI VI.',
                    'breed' => 'ANGOL FOXHOUND'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI VI.',
                    'breed' => 'BAJOR HEGYI VÉREB'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI VI.',
                    'breed' => 'BALKÁNI KOPÓ'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI VI.',
                    'breed' => 'BASSET BLEU DE GASCOGNE'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI VI.',
                    'breed' => 'BASSET HOUND'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI VI.',
                    'breed' => 'BEAGLE'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI VI.',
                    'breed' => 'BEAGLE HARRIER'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI VI.',
                    'breed' => 'BERNER LAUFHOUND'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI VI.',
                    'breed' => 'BERNI KISKOPÓ'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI VI.',
                    'breed' => 'BILLY'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI VI.',
                    'breed' => 'BIOODHOUND'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI VI.',
                    'breed' => 'BRANDLBRACKE'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI VI.',
                    'breed' => 'BLACK AND TAN COONHOUND'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI VI.',
                    'breed' => 'DALMATA'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI VI.',
                    'breed' => 'DREVER'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI VI.',
                    'breed' => 'DUNKER'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI VI.',
                    'breed' => 'ERDÉLYI KOPÓ'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI VI.',
                    'breed' => 'FRANCIA TRICOLOR KOPÓ'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI VI.',
                    'breed' => 'GRIFFON BLEU DE GASCOGNE'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI VI.',
                    'breed' => 'HAMILTON STÖVARE'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI VI.',
                    'breed' => 'HANNOVERI VÉREB'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI VI.',
                    'breed' => 'HARRIER'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI VI.',
                    'breed' => 'LUCERNI KISKOPÓ'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI VI.',
                    'breed' => 'NAGY ANGOL-FRANCIA TRICOLOR KOPÓ'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI VI.',
                    'breed' => 'OSZTRÁK RÖVIDSZŐRŰ VIZSLA'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI VI.',
                    'breed' => 'OTTERHOUND'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI VI.',
                    'breed' => 'PETIT BASSET GRIFFON VENDÉEN'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI VI.',
                    'breed' => 'PETIT BLUE DE GASCOGNE'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI VI.',
                    'breed' => 'PETIT GRIFFON BLEU DE GASCOGNE'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI VI.',
                    'breed' => 'PORCELAINE'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI VI.',
                    'breed' => 'RODÉZIAI RIDGEBACK'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI VI.',
                    'breed' => 'SCHWAYZER LAUFHOUND'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI VI.',
                    'breed' => 'SZLOVÁK KOPÓ'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI VI.',
                    'breed' => 'ANGOL SZETTER'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI VII.',
                    'breed' => 'BRETON SPÁNIEL'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI VII.',
                    'breed' => 'CESKY FOUSEK'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI VII.',
                    'breed' => 'CSEH VIZSLA, szálkásszőrű'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI VII.',
                    'breed' => 'DRÓTSZŐRŰ MAGYAR VIZSLA'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI VII.',
                    'breed' => 'EPAGNEUL BLEU PICARD'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI VII.',
                    'breed' => 'EPAGNEUL BRETON'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI VII.',
                    'breed' => 'GORDON SZETTER'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI VII.',
                    'breed' => 'GRIFFON drótszőrű'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI VII.',
                    'breed' => 'ÍR SETTER'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI VII.',
                    'breed' => 'KIS MÜNSTERLANDI VIZSLA'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI VII.',
                    'breed' => 'NAGY MÜNSTERLANDI VIZSLA'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI VII.',
                    'breed' => 'NÉMET VIZSLA, drótszőrű'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI VII.',
                    'breed' => 'NÉMET VIZSLA, hosszúszőrű'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI VII.',
                    'breed' => 'NÉMET VIZSLA, rövidszőrű'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI VII.',
                    'breed' => 'NÉMET VIZSLA, szálkás szőrű'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI VII.',
                    'breed' => 'SZLOVÁK DRÓTSZŐRŰ VIZSLA'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI VII.',
                    'breed' => 'OLASZ PINONE'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI VII.',
                    'breed' => 'OLASZ VIZSLA'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI VII.',
                    'breed' => 'POINTER'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI VII.',
                    'breed' => 'PUDELPOINTER'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI VII.',
                    'breed' => 'RÖVIDSZŐRŰ MAGYAR VIZSLA'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI VII.',
                    'breed' => 'WEIMARANER '
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI VIII.',
                    'breed' => 'AMERIKAI COCKER SPÁNIEL'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI VIII.',
                    'breed' => 'AMERIKAI VIZI SPÁNIEL'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI VIII.',
                    'breed' => 'ANGOL COCKER SPÁNIEL'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI VIII.',
                    'breed' => 'ANGOL SPRINGER SPÁNIEL'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI VIII.',
                    'breed' => 'CURLY-COATED RETRIEVER'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI VIII.',
                    'breed' => 'FLAT-COATED RETRIEVER'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI VIII.',
                    'breed' => 'GOLDEN RETRIEVER'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI VIII.',
                    'breed' => 'ÍR VIZI SPÁNIEL'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI VIII.',
                    'breed' => 'KOOIKERHONDJE'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI VIII.',
                    'breed' => 'LABRADOR RETRIEVER'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI VIII.',
                    'breed' => 'LAGOTTO ROMAGNOLO'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI VIII.',
                    'breed' => 'NÉMET FÜRJÉSZEB'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI VIII.',
                    'breed' => 'SUSSAU SPÁNIEL'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI VIII.',
                    'breed' => 'WELSH SPRINGER SPANIEL'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI IX.',
                    'breed' => 'BARBANCON'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI IX.',
                    'breed' => 'BELGA GRIFFON'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI IX.',
                    'breed' => 'BICHON FRISE'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI IX.',
                    'breed' => 'BICHON HAVANAIS'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI IX.',
                    'breed' => 'BOLOGNESE'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI IX.',
                    'breed' => 'BOSTON TERRIER'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI IX.',
                    'breed' => 'BROUXELI GRIFFON'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI IX.',
                    'breed' => 'CAVALIER KING CHARLES SPANIEL'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI IX.',
                    'breed' => 'CHIHUAHUA, hosszúszőrű'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI IX.',
                    'breed' => 'CHIHUAHUA, rövidszőrű'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI IX.',
                    'breed' => 'COTON DE TULAER'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI IX.',
                    'breed' => 'FRANCIA BULLDOG'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI IX.',
                    'breed' => 'JAPÁN CHIN'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI IX.',
                    'breed' => 'KÍNAI MEZTELEN KUTYA'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI IX.',
                    'breed' => 'KÍNAI MEZTELEN KUTYA (powder puff)'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI IX.',
                    'breed' => 'KING CHARLES SPENIEL'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI IX.',
                    'breed' => 'LHASA APSO'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI IX.',
                    'breed' => 'MÁLTAI SELYEMKUTYA'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI IX.',
                    'breed' => 'MOPS'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI IX.',
                    'breed' => 'PAPILLON'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI IX.',
                    'breed' => 'PEKINGI PALOTAKUTYA'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI IX.',
                    'breed' => 'PETIT CHIEN LION'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI IX.',
                    'breed' => 'RUSSIAN TOY LONG-HAIRED'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI IX.',
                    'breed' => 'RUSSIAN TOY SHORT-HAIRED'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI IX.',
                    'breed' => 'SHIH-TZU'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI IX.',
                    'breed' => 'TIBETI SPANIEL'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI IX.',
                    'breed' => 'TIBETI TERRIER'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI IX.',
                    'breed' => 'USZKÁR, KÖZÉP, fekete'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI IX.',
                    'breed' => '* USZKÁR, KÖZÉP, apricot'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI IX.',
                    'breed' => 'USZKÁR, KÖZÉP, FAWN'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI IX.',
                    'breed' => 'USZKÁR, KÖZÉP, barna'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI IX.',
                    'breed' => 'USZKÁR, KÖZÉP, ezüst'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI IX.',
                    'breed' => 'USZKÁR, KÖZÉP, fehér'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI IX.',
                    'breed' => '* USZKÁR, KÖZÉP, red'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI IX.',
                    'breed' => 'USZKÁR, ÓRIÁS, fekete'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI IX.',
                    'breed' => '* USZKÁR, ÓRIÁS, apricot'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI IX.',
                    'breed' => 'USZKÁR, ÓRIÁS, FAWN'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI IX.',
                    'breed' => 'USZKÁR, ÓRIÁS, barna'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI IX.',
                    'breed' => 'USZKÁR, ÓRIÁS, ezüst'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI IX.',
                    'breed' => 'USZKÁR, ÓRIÁS, fehér'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI IX.',
                    'breed' => '* USZKÁR, ÓRIÁS, red'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI IX.',
                    'breed' => 'USZKÁR, TÖRPE, fekete'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI IX.',
                    'breed' => '* USZKÁR, TÖRPE, apricot'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI IX.',
                    'breed' => 'USZKÁR, TÖRPE, FAWN'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI IX.',
                    'breed' => 'USZKÁR, TÖRPE, barna'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI IX.',
                    'breed' => 'USZKÁR, TÖRPE, ezüst'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI IX.',
                    'breed' => 'USZKÁR, TÖRPE, fehér'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI IX.',
                    'breed' => '* USZKÁR, TÖRPE, red'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI IX.',
                    'breed' => 'USZKÁR, TOY, fekete'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI IX.',
                    'breed' => '* USZKÁR, TOY, apricot'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI IX.',
                    'breed' => 'USZKÁR, TOY, FAWN'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI IX.',
                    'breed' => 'USZKÁR, TOY, barna'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI IX.',
                    'breed' => 'USZKÁR, TOY, ezüst'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI IX.',
                    'breed' => 'USZKÁR, TOY, fehér'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI IX.',
                    'breed' => '* USZKÁR, TOY, red'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI X.',
                    'breed' => 'AFGÁN AGÁR'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI X.',
                    'breed' => 'ANGOL AGÁR'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI X.',
                    'breed' => 'AZAWAKH'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI X.',
                    'breed' => 'BARZOJ'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI X.',
                    'breed' => 'DEEHOUND'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI X.',
                    'breed' => 'GALGO ESPAGNOL'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI X.',
                    'breed' => 'ÍR FARKAS'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI X.',
                    'breed' => 'MAGYAR AGÁR'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI X.',
                    'breed' => 'OLASZ TÖRPE AGÁR'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI X.',
                    'breed' => 'SALUKI'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI X.',
                    'breed' => 'SLOUGHI'
                ],
                [
                    'type' => 'FCI',
                    'group' => 'FCI X.',
                    'breed' => 'WHIPPET'
                ],
                [
                    'type' => 'FCI IN',
                    'group' => 'Különleges',
                    'breed' => '* FRANCIA BULLDOG  black%tan '
                ],
                [
                    'type' => 'FCI IN',
                    'group' => 'Különleges',
                    'breed' => '* FRANCIA BULLDOG blue%tan '
                ],
                [
                    'type' => 'FCI IN',
                    'group' => 'Különleges',
                    'breed' => '* FRANCIA BULLDOG csokoládé, csokoládé foltos '
                ],
                [
                    'type' => 'FCI IN',
                    'group' => 'Különleges',
                    'breed' => '* FRANCIA BULLDOG kék, kék foltos '
                ],
                [
                    'type' => 'FCI IN',
                    'group' => 'Különleges',
                    'breed' => '* FRANCIA BULLDOG lilac '
                ],
                [
                    'type' => 'FCI IN',
                    'group' => 'Különleges',
                    'breed' => '* FRANCIA BULLDOG lilac csíkos '
                ],
                [
                    'type' => 'FCI IN',
                    'group' => 'Különleges',
                    'breed' => '* FRANCIA BULLDOG sable '
                ],
                [
                    'type' => 'FCI IN',
                    'group' => 'Különleges',
                    'breed' => 'ALASZKAI KLEE KAI (mini husky) '
                ],
                [
                    'type' => 'FCI IN',
                    'group' => 'Különleges',
                    'breed' => 'AMERIKAI BULLDOG, bully '
                ],
                [
                    'type' => 'FCI IN',
                    'group' => 'Különleges',
                    'breed' => 'AMERIKAI BULLDOG, standard '
                ],
                [
                    'type' => 'FCI IN',
                    'group' => 'Különleges',
                    'breed' => 'ANGOL BULLDOG (El nem ismert szín) '
                ],
                [
                    'type' => 'FCI IN',
                    'group' => 'Különleges',
                    'breed' => 'CONTINENTAL BULLDOG '
                ],
                [
                    'type' => 'FCI IN',
                    'group' => 'Különleges',
                    'breed' => 'FRANCIA BULLDOG (egyéb színverzió) '
                ],
                [
                    'type' => 'FCI IN',
                    'group' => 'Különleges',
                    'breed' => 'FRANCIA BULLDOG merle '
                ],
                [
                    'type' => 'FCI IN',
                    'group' => 'Különleges',
                    'breed' => 'MINI BOULÉ '
                ],
                [
                    'type' => 'FCI IN',
                    'group' => 'Különleges',
                    'breed' => 'AMERICAN BULLY Classic '
                ],
                [
                    'type' => 'FCI IN',
                    'group' => 'Különleges',
                    'breed' => 'AMERICAN BULLY Extreme '
                ],
                [
                    'type' => 'FCI IN',
                    'group' => 'Különleges',
                    'breed' => 'AMERICAN BULLY Extreme Pocket '
                ],
                [
                    'type' => 'FCI IN',
                    'group' => 'Különleges',
                    'breed' => 'AMERICAN BULLY Pocket '
                ],
                [
                    'type' => 'FCI IN',
                    'group' => 'Különleges',
                    'breed' => 'AMERICAN BULLY Pocket Mikro '
                ],
                [
                    'type' => 'FCI IN',
                    'group' => 'Különleges',
                    'breed' => 'AMERICAN BULLY Standard '
                ],
                [
                    'type' => 'FCI IN',
                    'group' => 'Különleges',
                    'breed' => 'AMERICAN BULLY XL '
                ],
                [
                    'type' => 'FCI IN',
                    'group' => 'Különleges',
                    'breed' => 'AMERICAN BULLY XXL '
                ],
                [
                    'type' => 'FCI IN',
                    'group' => 'Különleges',
                    'breed' => 'AMERICAN EXOTIK BULLY '
                ],
                [
                    'type' => 'FCI IN',
                    'group' => 'Különleges',
                    'breed' => 'AMERIKAI PITBULL Terrier '
                ],
                [
                    'type' => 'FCI IN',
                    'group' => 'Különleges',
                    'breed' => 'SHORTY BULL '
                ],
                [
                    'type' => 'FCI IN',
                    'group' => 'Különleges',
                    'breed' => 'BOERBOEL '
                ],
                [
                    'type' => 'FCI IN',
                    'group' => 'Különleges',
                    'breed' => 'BOLONKA FRANZUSKA '
                ],
                [
                    'type' => 'FCI IN',
                    'group' => 'Különleges',
                    'breed' => 'BOLONKA ZWETNA '
                ],
                [
                    'type' => 'FCI IN',
                    'group' => 'Különleges',
                    'breed' => 'BOXER (el nem ismert színű) '
                ],
                [
                    'type' => 'FCI IN',
                    'group' => 'Különleges',
                    'breed' => '* BIEWER YORKSHIRE TERRIER  kék -fehér arany '
                ],
                [
                    'type' => 'FCI IN',
                    'group' => 'Különleges',
                    'breed' => '* BIEWER YORKSHIRE TERRIER fekete-fehér arany '
                ],
                [
                    'type' => 'FCI IN',
                    'group' => 'Különleges',
                    'breed' => '* BÍRÓ YORKSHIRE TERRIER chokolate '
                ],
                [
                    'type' => 'FCI IN',
                    'group' => 'Különleges',
                    'breed' => '* BÍRÓ YORKSHIRE TERRIER chokolate-weis gold '
                ],
                [
                    'type' => 'FCI IN',
                    'group' => 'Különleges',
                    'breed' => 'ADDA YORKSHIRE TERRIER '
                ],
                [
                    'type' => 'FCI IN',
                    'group' => 'Különleges',
                    'breed' => 'AMERIKAI MEZTELEN TERRIER '
                ],
                [
                    'type' => 'FCI IN',
                    'group' => 'Különleges',
                    'breed' => 'BIEWER YORKSHIRE TERRIER '
                ],
                [
                    'type' => 'FCI IN',
                    'group' => 'Különleges',
                    'breed' => 'BIRO YORKSHIRE TERRIER '
                ],
                [
                    'type' => 'FCI IN',
                    'group' => 'Különleges',
                    'breed' => 'BLACK YORKSHIRE TERRIER '
                ],
                [
                    'type' => 'FCI IN',
                    'group' => 'Különleges',
                    'breed' => 'BLUE DIAMOND BIEWER YORKSHIRE TERRIER '
                ],
                [
                    'type' => 'FCI IN',
                    'group' => 'Különleges',
                    'breed' => 'CHOKOLADE MERLE YORKSHIRE TERRIER '
                ],
                [
                    'type' => 'FCI IN',
                    'group' => 'Különleges',
                    'breed' => 'ÓCEÁN PEARL YORKSHIRE TERRIER '
                ],
                [
                    'type' => 'FCI IN',
                    'group' => 'Különleges',
                    'breed' => 'WHITE YORKSHIRE TERRIER '
                ],
                [
                    'type' => 'FCI IN',
                    'group' => 'Különleges',
                    'breed' => '* GOLLDUST YORKSHIRE TERRIER arany '
                ],
                [
                    'type' => 'FCI IN',
                    'group' => 'Különleges',
                    'breed' => '* GOLLDUST YORKSHIRE TERRIER arany-fehér '
                ],
                [
                    'type' => 'FCI IN',
                    'group' => 'Különleges',
                    'breed' => '* MERLE GOLDUST YORKSHIRE TERRIER '
                ],
                [
                    'type' => 'FCI IN',
                    'group' => 'Különleges',
                    'breed' => 'BLUE MERLE YORKSHIRE TERRIER '
                ],
                [
                    'type' => 'FCI IN',
                    'group' => 'Különleges',
                    'breed' => 'BLUE/BLACK % TAN YORKSHIRE TERRIE '
                ],
                [
                    'type' => 'FCI IN',
                    'group' => 'Különleges',
                    'breed' => 'CHOKOLADE YORKSHIRE TERRIER '
                ],
                [
                    'type' => 'FCI IN',
                    'group' => 'Különleges',
                    'breed' => 'GOLDDUST YORKSHIRE TERRIER '
                ],
                [
                    'type' => 'FCI IN',
                    'group' => 'Különleges',
                    'breed' => 'MERLE YORKSHIRE TERRIER (egyéb) '
                ],
                [
                    'type' => 'FCI IN',
                    'group' => 'Különleges',
                    'breed' => 'SABLE MERLE YORKSHIRE TERRIER '
                ],
                [
                    'type' => 'FCI IN',
                    'group' => 'Különleges',
                    'breed' => '* NÉMET JUHÁSZKUTYA black%silver hosszúszőrű '
                ],
                [
                    'type' => 'FCI IN',
                    'group' => 'Különleges',
                    'breed' => '* NÉMET JUHÁSZKUTYA black%silver normál '
                ],
                [
                    'type' => 'FCI IN',
                    'group' => 'Különleges',
                    'breed' => '* NÉMET JUHÁSZKUTYA blue sable hosszúszőrű '
                ],
                [
                    'type' => 'FCI IN',
                    'group' => 'Különleges',
                    'breed' => '* NÉMET JUHÁSZKUTYA blue sable normál '
                ],
                [
                    'type' => 'FCI IN',
                    'group' => 'Különleges',
                    'breed' => 'BANDOG TÖRZSKÖNYVEZETT PÉLDÁNYOK '
                ],
                [
                    'type' => 'FCI IN',
                    'group' => 'Különleges',
                    'breed' => 'BULGARIAN SHEPHERD DOG '
                ],
                [
                    'type' => 'FCI IN',
                    'group' => 'Különleges',
                    'breed' => 'CATAHOULA LEOPARD DOG '
                ],
                [
                    'type' => 'FCI IN',
                    'group' => 'Különleges',
                    'breed' => 'HOVAWART egyéb színek '
                ],
                [
                    'type' => 'FCI IN',
                    'group' => 'Különleges',
                    'breed' => 'KELET EUROPAI JUHÁSZ '
                ],
                [
                    'type' => 'FCI IN',
                    'group' => 'Különleges',
                    'breed' => 'MAGYAR SZELINDEK '
                ],
                [
                    'type' => 'FCI IN',
                    'group' => 'Különleges',
                    'breed' => 'MOSZKVAI ŐRKUTYA '
                ],
                [
                    'type' => 'FCI IN',
                    'group' => 'Különleges',
                    'breed' => 'NÉMET DOG (el nem ismert színek) '
                ],
                [
                    'type' => 'FCI IN',
                    'group' => 'Különleges',
                    'breed' => 'NÉMET JUHÁSZKUTYA kék-cser hosszúszőrű '
                ],
                [
                    'type' => 'FCI IN',
                    'group' => 'Különleges',
                    'breed' => 'NÉMET JUHÁSZKUTYA kék-cser rövidszőrű '
                ],
                [
                    'type' => 'FCI IN',
                    'group' => 'Különleges',
                    'breed' => 'NÉMET JUHÁSZKUTYA liver-colored hosszúszőrű '
                ],
                [
                    'type' => 'FCI IN',
                    'group' => 'Különleges',
                    'breed' => 'NÉMET JUHÁSZKUTYA liver-colored normál '
                ],
                [
                    'type' => 'FCI IN',
                    'group' => 'Különleges',
                    'breed' => 'OROSZ FEKETE TERRIER (el nem ismert színv.) '
                ],
                [
                    'type' => 'FCI IN',
                    'group' => 'Különleges',
                    'breed' => 'Pryter '
                ],
                [
                    'type' => 'FCI IN',
                    'group' => 'Különleges',
                    'breed' => 'PARTI VAGY FOLTOS USZKÁR, közép '
                ],
                [
                    'type' => 'FCI IN',
                    'group' => 'Különleges',
                    'breed' => 'PARTI VAGY FOLTOS USZKÁR, közép (BARNA) '
                ],
                [
                    'type' => 'FCI IN',
                    'group' => 'Különleges',
                    'breed' => 'PARTI VAGY FOLTOS USZKÁR, közép (EZÜST) '
                ],
                [
                    'type' => 'FCI IN',
                    'group' => 'Különleges',
                    'breed' => 'PARTI VAGY FOLTOS USZKÁR, közép (FAWN) '
                ],
                [
                    'type' => 'FCI IN',
                    'group' => 'Különleges',
                    'breed' => 'PARTI VAGY FOLTOS USZKÁR, közép (FEHÉR, L. CREAM) '
                ],
                [
                    'type' => 'FCI IN',
                    'group' => 'Különleges',
                    'breed' => 'PARTI VAGY FOLTOS USZKÁR, közép (FEKETE) '
                ],
                [
                    'type' => 'FCI IN',
                    'group' => 'Különleges',
                    'breed' => 'PARTI VAGY FOLTOS USZKÁR, közép (KÉK-BLUE) '
                ],
                [
                    'type' => 'FCI IN',
                    'group' => 'Különleges',
                    'breed' => 'PARTI VAGY FOLTOS USZKÁR, óriás '
                ],
                [
                    'type' => 'FCI IN',
                    'group' => 'Különleges',
                    'breed' => 'PARTI VAGY FOLTOS USZKÁR, óriás (BARNA) '
                ],
                [
                    'type' => 'FCI IN',
                    'group' => 'Különleges',
                    'breed' => 'PARTI VAGY FOLTOS USZKÁR, óriás (EZÜST) '
                ],
                [
                    'type' => 'FCI IN',
                    'group' => 'Különleges',
                    'breed' => 'PARTI VAGY FOLTOS USZKÁR, óriás (FAWN) '
                ],
                [
                    'type' => 'FCI IN',
                    'group' => 'Különleges',
                    'breed' => 'PARTI VAGY FOLTOS USZKÁR, óriás (FEHÉR, L. CREAM) '
                ],
                [
                    'type' => 'FCI IN',
                    'group' => 'Különleges',
                    'breed' => 'PARTI VAGY FOLTOS USZKÁR, óriás (FEKETE) '
                ],
                [
                    'type' => 'FCI IN',
                    'group' => 'Különleges',
                    'breed' => 'PARTI VAGY FOLTOS USZKÁR, óriás (KÉK-BLUE) '
                ],
                [
                    'type' => 'FCI IN',
                    'group' => 'Különleges',
                    'breed' => 'PARTI VAGY FOLTOS USZKÁR, törpe '
                ],
                [
                    'type' => 'FCI IN',
                    'group' => 'Különleges',
                    'breed' => 'PARTI VAGY FOLTOS USZKÁR, törpe (BARNA) '
                ],
                [
                    'type' => 'FCI IN',
                    'group' => 'Különleges',
                    'breed' => 'PARTI VAGY FOLTOS USZKÁR, törpe (EZÜST) '
                ],
                [
                    'type' => 'FCI IN',
                    'group' => 'Különleges',
                    'breed' => 'PARTI VAGY FOLTOS USZKÁR, törpe (FAWN) '
                ],
                [
                    'type' => 'FCI IN',
                    'group' => 'Különleges',
                    'breed' => 'PARTI VAGY FOLTOS USZKÁR, törpe (FEHÉR, L. CREAM) '
                ],
                [
                    'type' => 'FCI IN',
                    'group' => 'Különleges',
                    'breed' => 'PARTI VAGY FOLTOS USZKÁR, törpe (FEKETE) '
                ],
                [
                    'type' => 'FCI IN',
                    'group' => 'Különleges',
                    'breed' => 'PARTI VAGY FOLTOS USZKÁR, törpe (KÉK-BLUE) '
                ],
                [
                    'type' => 'FCI IN',
                    'group' => 'Különleges',
                    'breed' => 'PARTI VAGY FOLTOS USZKÁR, toy '
                ],
                [
                    'type' => 'FCI IN',
                    'group' => 'Különleges',
                    'breed' => 'PARTI VAGY FOLTOS USZKÁR, toy (BARNA) '
                ],
                [
                    'type' => 'FCI IN',
                    'group' => 'Különleges',
                    'breed' => 'PARTI VAGY FOLTOS USZKÁR, toy (EZÜST) '
                ],
                [
                    'type' => 'FCI IN',
                    'group' => 'Különleges',
                    'breed' => 'PARTI VAGY FOLTOS USZKÁR, toy (FAWN) '
                ],
                [
                    'type' => 'FCI IN',
                    'group' => 'Különleges',
                    'breed' => 'PARTI VAGY FOLTOS USZKÁR, toy (FEHÉR, L. CREAM) '
                ],
                [
                    'type' => 'FCI IN',
                    'group' => 'Különleges',
                    'breed' => 'PARTI VAGY FOLTOS USZKÁR, toy (FEKETE) '
                ],
                [
                    'type' => 'FCI IN',
                    'group' => 'Különleges',
                    'breed' => 'PARTI VAGY FOLTOS USZKÁR, toy (KÉK-BLUE) '
                ],
                [
                    'type' => 'FCI IN',
                    'group' => 'Különleges',
                    'breed' => 'PHANTOM VAGY RAJZOS USZKÁR, óriás '
                ],
                [
                    'type' => 'FCI IN',
                    'group' => 'Különleges',
                    'breed' => 'PHANTOM VAGY RAJZOS USZKÁR, közép '
                ],
                [
                    'type' => 'FCI IN',
                    'group' => 'Különleges',
                    'breed' => 'PHANTOM VAGY RAJZOS USZKÁR, törpe '
                ],
                [
                    'type' => 'FCI IN',
                    'group' => 'Különleges',
                    'breed' => '* POMERANIAN CHOCOLATE AND TAN MERLE '
                ],
                [
                    'type' => 'FCI IN',
                    'group' => 'Különleges',
                    'breed' => '* POMERANIAN PARTI-COLOR '
                ],
                [
                    'type' => 'FCI IN',
                    'group' => 'Különleges',
                    'breed' => 'PHANTOM VAGY RAJZOS USZKÁR, toy '
                ],
                [
                    'type' => 'FCI IN',
                    'group' => 'Különleges',
                    'breed' => 'POMERANIAN '
                ],
                [
                    'type' => 'FCI IN',
                    'group' => 'Különleges',
                    'breed' => '* RUSSIAN TOY LONG-HAIRED '
                ],
                [
                    'type' => 'FCI IN',
                    'group' => 'Különleges',
                    'breed' => '* RUSSIAN TOY SHORTHAIR '
                ],
                [
                    'type' => 'FCI IN',
                    'group' => 'Különleges',
                    'breed' => 'Mame Shiba '
                ],
                [
                    'type' => 'FCI IN',
                    'group' => 'Különleges',
                    'breed' => 'MINIATURE AUSTRALIAN SHEPHERD '
                ],
                [
                    'type' => 'FCI IN',
                    'group' => 'Különleges',
                    'breed' => 'TOY AUSTRALIAN SHEPHERD '
                ],
                [
                    'type' => 'FCI IN',
                    'group' => 'Különleges',
                    'breed' => 'HOSSZÚ LÁBÚ SÁRGA ERDÉLYI KOPÓ '
                ],
                [
                    'type' => 'FCI IN',
                    'group' => 'Különleges',
                    'breed' => 'RÖVID LÁBÚ ERDÉLYI KOPÓ '
                ],
                [
                    'type' => 'FCI IN',
                    'group' => 'Különleges',
                    'breed' => 'SCHNAUZER, TÖRPE, particolor '
                ],
                [
                    'type' => 'FCI IN',
                    'group' => 'Különleges',
                    'breed' => 'SILKEN WINDHOUND '
                ],
                [
                    'type' => 'FCI IN',
                    'group' => 'Különleges',
                    'breed' => 'SINKA '
                ],
                [
                    'type' => 'FCI IN',
                    'group' => 'Különleges',
                    'breed' => 'SPANIEL, coboly '
                ],
                [
                    'type' => 'FCI IN',
                    'group' => 'Különleges',
                    'breed' => 'SPANIEL, csokoládé-coboly '
                ],
                [
                    'type' => 'FCI IN',
                    'group' => 'Különleges',
                    'breed' => 'TACSKÓ KANINCHEN PIEBALD hosszúszőrű '
                ],
                [
                    'type' => 'FCI IN',
                    'group' => 'Különleges',
                    'breed' => 'TACSKÓ KANINCHEN PIEBALD rövidszőrű '
                ],
                [
                    'type' => 'FCI IN',
                    'group' => 'Különleges',
                    'breed' => 'TACSKÓ, TÖRPE, PIEBALD hosszúszőrű '
                ],
                [
                    'type' => 'FCI IN',
                    'group' => 'Különleges',
                    'breed' => 'TACSKÓ, TÖRPE, PIEBALD rövidszőrű '
                ],
                [
                    'type' => 'FCI IN',
                    'group' => 'Különleges',
                    'breed' => 'TAJGAN '
                ],
                [
                    'type' => 'FCI IN',
                    'group' => 'Különleges',
                    'breed' => 'WHIPPET hosszú szőrű '
                ],
                [
                    'type' => 'FCI IN',
                    'group' => 'Különleges',
                    'breed' => 'WORKING PIT BULLDOG '
                ],
                [
                    'type' => 'FCI IN',
                    'group' => 'Különleges',
                    'breed' => '* EGYÉB '
                ],
                [
                    'type' => 'FCI IN',
                    'group' => 'Különleges',
                    'breed' => 'YAKUTIAN LAIKA '
                ],
                [
                    'type' => 'FN',
                    'group' => 'Fajtanélküli',
                    'breed' => 'Fajtanélküli'
                ],
            ]
        );
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
