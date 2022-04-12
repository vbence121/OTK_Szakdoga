<?php
    class Admins{

        public $DB;

        public function __construct($Udb){
            $this->DB = $Udb;
        }
        
        public function getUserByUname($qUname){
            $query = '
            SELECT *
            FROM admins
            WHERE Uname LIKE \''.$qUname.'\' LIMIT 1
            ';

            $stmt = $this->DB->prepare($query,array($qUname,));
            $stmt->execute();
            if(($stmt != null) and ($stmt->rowCount() == 1)){
                extract($stmt->fetch(PDO::FETCH_ASSOC));
                return array(
                    'Uname' => $Uname,
                    'enc_pass' => $enc_pass,
                    'name' => $name
                );
            }
            else{
                return null;
            }
        }
        public function getAllUser(){
            $query = '
            SELECT *
            FROM admins
            ORDER BY Uname DESC
            ';

            $stmt = $this->DB->prepare($query);
            $stmt->execute();
            if(($stmt != null) and ($stmt->rowCount() > 0)){
                $post_arr = array();
                while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                    extract($row);
                    $post_item = array(
                        'Uname' => $Uname,
                        'enc_pass' => $enc_pass,
                        'name' => $name
                    );
                    array_push($post_arr, $post_item);
                }
                return $post_arr;
            }
            else{
                return null;
            }
        }
        public function customQuery($queryText){
            $stmt = $this->connect->prepare($queryText);
            $stmt->execute();
            if(($stmt != null) and ($stmt->rowCount() > 0)){
                $post_arr = array();
                while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                    extract($row);
                    $post_item = array(
                        'Uname' => $Uname,
                        'enc_pass' => $enc_pass,
                        'name' => $name
                    );
                    array_push($post_arr, $post_item);
                }
                return $post_arr;
            }
            else{
                return null;
            }
        } 

        public function deleteUserByUname($qUname){
            $query = '
            DELETE *
            FROM admins
            WHERE Uname LIKE \''.$qUname.'\' LIMIT 1
            ';

            $stmt = $this->DB->prepare($query,array($qUname,));
            return $stmt->execute();
        }
    }

?>