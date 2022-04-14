<?php

    class Post{
        // private
        private $connect;
        private $table = 'post';

        // public
        public $ID;
        public $category_ID;
        public $category_name;
        public $title;
        public $author;
        public $body;
        public $cDate;  // creation date

        public function __construct($db){
            $this->connect = $db;
        }

        public function readDB(){   // get post from db
            // prepare query and excecute
            $query = 'SELECT
                c.name as category_name,
                p.id,
                p.title,
                p.category_id,
                p.body,
                p.author,
                p.creation_date
                FROM
                '.$this->table.' p
                LEFT JOIN 
                    categories c ON p.category_id = c.id
                    ORDER BY p.creation_date DESC
                ';

            $stmt = $this->connect->prepare($query);
            $stmt->execute();
            return $stmt;
        }

        public function readSingle(){
            $query = 'SELECT
                c.name as category_name,
                p.id,
                p.title,
                p.category_id,
                p.body,
                p.author,
                p.creation_date
                FROM
                '.$this->table.' p
                LEFT JOIN 
                    categories c ON p.category_id = c.id
                    WHERE p.id = ? LIMIT 1
                ';

            $stmt = $this->connect->prepare($query);

            $stmt->bindParam(1, $this->id);

            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            
            $this->title = $row['title'];
            $this->author = $row['author'];
            $this->body = $row['body'];
            $this->category_id = $row['category_id'];
            $this->creation_date = $row['creation_date'];

            //return $stmt;
        }
    }

?>