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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('content');
            $table->timestamps();
        });

        DB::table('posts')->insert([
            ['title' => 'Lorem Ipsum',
            'created_at' => '2022-10-08', 
            'content' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industr
             Lorem Ipsum has been the industrys standard dummy text ever since the 1500s
             , when an unknown printer took a galley of type and scrambled it to make a type specimen book.
              It has survived not only five centuries, but also the leap into electronic typesetting,
               remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets
                containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus
                 PageMaker including versions of Lorem Ipsum.'],

            ['title' => 'Why do we use it?', 'created_at' => '2022-10-08', 'content' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industr
            Lorem Ipsum has been the industrys standard dummy text ever since the 1500s
            , when an unknown printer took a galley of type and scrambled it to make a type specimen book.
            It has survived not only five centuries, but also the leap into electronic typesetting,
            remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets
            containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus
                PageMaker including versions of Lorem Ipsum.'],

            ['title' => 'Where can I get some?', 'created_at' => '2022-10-08', 'content' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industr
            Lorem Ipsum has been the industrys standard dummy text ever since the 1500s
            , when an unknown printer took a galley of type and scrambled it to make a type specimen book.
            It has survived not only five centuries, but also the leap into electronic typesetting,
            remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets
            containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus
                PageMaker including versions of Lorem Ipsum.'],
            
                ['title' => 'Lorem Ipsum',
                'created_at' => '2022-10-08', 
                'content' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industr
                 Lorem Ipsum has been the industrys standard dummy text ever since the 1500s
                 , when an unknown printer took a galley of type and scrambled it to make a type specimen book.
                  It has survived not only five centuries, but also the leap into electronic typesetting,
                   remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets
                    containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus
                     PageMaker including versions of Lorem Ipsum.'],
    
                ['title' => 'Why do we use it?', 'created_at' => '2022-10-08', 'content' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industr
                Lorem Ipsum has been the industrys standard dummy text ever since the 1500s
                , when an unknown printer took a galley of type and scrambled it to make a type specimen book.
                It has survived not only five centuries, but also the leap into electronic typesetting,
                remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets
                containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus
                    PageMaker including versions of Lorem Ipsum.'],
    
                ['title' => 'Where can I get some?', 'created_at' => '2022-10-08', 'content' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industr
                Lorem Ipsum has been the industrys standard dummy text ever since the 1500s
                , when an unknown printer took a galley of type and scrambled it to make a type specimen book.
                It has survived not only five centuries, but also the leap into electronic typesetting,
                remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets
                containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus
                    PageMaker including versions of Lorem Ipsum.'],
            
                    ['title' => 'Lorem Ipsum',
                    'created_at' => '2022-10-08', 
                    'content' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industr
                     Lorem Ipsum has been the industrys standard dummy text ever since the 1500s
                     , when an unknown printer took a galley of type and scrambled it to make a type specimen book.
                      It has survived not only five centuries, but also the leap into electronic typesetting,
                       remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets
                        containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus
                         PageMaker including versions of Lorem Ipsum.'],
        
                    ['title' => 'Why do we use it?', 'created_at' => '2022-10-08', 'content' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industr
                    Lorem Ipsum has been the industrys standard dummy text ever since the 1500s
                    , when an unknown printer took a galley of type and scrambled it to make a type specimen book.
                    It has survived not only five centuries, but also the leap into electronic typesetting,
                    remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets
                    containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus
                        PageMaker including versions of Lorem Ipsum.'],
        
                    ['title' => 'Where can I get some?', 'created_at' => '2022-10-08', 'content' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industr
                    Lorem Ipsum has been the industrys standard dummy text ever since the 1500s
                    , when an unknown printer took a galley of type and scrambled it to make a type specimen book.
                    It has survived not only five centuries, but also the leap into electronic typesetting,
                    remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets
                    containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus
                        PageMaker including versions of Lorem Ipsum.'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
};
