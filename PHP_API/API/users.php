<?php
    class Users{
        /* 
        // public
        public $Uname;
        public $enc_pass;
        public $name;
        public $mobile;
        public $tagsag;
        */

        public $DB;

        public function __construct($Udb){
            $this->DB = $Udb;
        }

        public function getUserByUname($qUname){
            $query = '
            SELECT *
            FROM users
            WHERE Uname LIKE \''.$qUname.'\' LIMIT 1
            ';

            $stmt = $this->DB->prepare($query,array($qUname,));
            $stmt->execute();
            if(($stmt != null) and ($stmt->rowCount() == 1)){
                extract($stmt->fetch(PDO::FETCH_ASSOC));
                return array(
                    'Uname' => $Uname,
                    'enc_pass' => $enc_pass,
                    'name' => $name,
                    'mobile' => $mobile,
                    'tagsag' => $tagsag
                );
            }
            else{
                return null;
            }
        }
        public function getAllUser(){
            $query = '
            SELECT *
            FROM users
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
                        'name' => $name,
                        'mobile' => $mobile,
                        'tagsag' => $tagsag
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
                        'name' => $name,
                        'mobile' => $mobile,
                        'tagsag' => $tagsag
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
            DELETE
            FROM users
            WHERE Uname LIKE \''.$qUname.'\' LIMIT 1
            ';

            $stmt = $this->DB->prepare($query,array($qUname,));
            return $stmt->execute();
        }

        public function updateUser($Uname, $name="", $enc_pass="", $mobile="", $tagsag=""){
            $set = 'Set ';
            if($name!="")       $set= $set.' name = \''.$name.'\', ';
            if($enc_pass!="")   $set= $set.' enc_pass = \''.$enc_pass.'\', ';
            if($mobile!="")     $set= $set.' mobile = \''.$mobile.'\', ';
            if($tagsag!="")     $set= $set.' tagsag = \''.$tagsag.'\', ';
            $set = trim($set);
            if(substr($set,-1) == ',') $set = substr($set,0,-1);
            $query = '
            Update users
            '.$set.'
            WHERE Uname LIKE \''.$Uname.'\' LIMIT 1
            ';
            //return array($set);
            $stmt = $this->DB->prepare($query,array($Uname,));
            return $stmt->execute();
        }

        public function createUser($Uname="", $name="", $enc_pass="", $mobile="", $tagsag=""){
            $set = 'Insert into users Values (';
        
            if($Uname=="") return false;
            $set= $set.'\''.$Uname.'\', ';

            if($enc_pass=="") return false;
            $set= $set.'\''.$enc_pass.'\', ';

            if($name=="") return false;
            $set= $set.'\''.$name.'\', ';

            if($mobile!="")   $set= $set.'\''.$mobile.'\', ';
            else $set= $set.'\''.' '.'\', ';

            if($tagsag!="")     $set= $set.'\''.$tagsag.'\')';
            else $set= $set.'\''.' '.'\')';

            //return array($set);

            $stmt = $this->DB->prepare($set,array($Uname,));
            return $stmt->execute();
        }
    }

?>