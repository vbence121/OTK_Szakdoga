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
            ['title' => 'publishing',
            'created_at' => '2022-10-08', 
            'content' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industr
             Lorem Ipsum has been the industrys standard dummy text ever since the 1500s
             , when an unknown printer took a galley of type and scrambled it to make a type specimen book.
              It has survived not only five centuries, but also the leap into electronic typesetting,
               remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets
                containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus
                 PageMaker including versions of Lorem Ipsum.'],
            ['title' => 'recently',
            'created_at' => '2022-10-08', 
            'content' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industr
             Lorem Ipsum has been the industrys standard dummy text ever since the 1500s
             , when an unknown printer took a galley of type and scrambled it to make a type specimen book.
              It has survived not only five centuries, but also the leap into electronic typesetting,
               remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets
                containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus
                 PageMaker including versions of Lorem Ipsum.'],
            ['title' => 'simply dummy text of',
            'created_at' => '2022-10-08', 
            'content' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industr
             Lorem Ipsum has been the industrys standard dummy text ever since the 1500s
             , when an unknown printer took a galley of type and scrambled it to make a type specimen book.
              It has survived not only five centuries, but also the leap into electronic typesetting,
               remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets
                containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus
                 PageMaker including versions of Lorem Ipsum.
                 
                 "At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat."'],
            ['title' => 'Lorem Ipsum',
            'created_at' => '2022-10-08', 
            'content' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industr
             Lorem Ipsum has been the industrys standard dummy text ever since the 1500s
             , when an unknown printer "At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat." took a galley of type and scrambled it to make a type specimen book.
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
            ['title' => 'Lorem Ipsum',
            'created_at' => '2022-10-08', 
            'content' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industr
             Lorem Ipsum has been the industrys standard dummy text ever since the 1500s
             , when an unknown "At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat."sum.'],

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
                   remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets
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
                , when an unknown printer took a galley of type and scrambled it to make a type specimen book.
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
                      It has survived not only five centuries, but also the leap into electronic typesetting,
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
                    Lorem Ipsum has been the industrys standard dummy text ever since the 1500s
                    Lorem Ipsum has been the industrys standard dummy text ever since the 1500s
                    , when an unknown printer took a galley of type and scrambled it to make a type specimen book.
                    It has survived not only five centuries, but also the leap into electronic typesetting,
                    remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets
                    containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus
                        PageMaker including versions of Lorem Ipsum. "At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat."'],
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
