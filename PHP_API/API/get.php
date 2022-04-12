<?php
    class GET{
        public $DB;

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
    }

    //header
    header('Acces-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once('../core/initialize.php');


    //init USER
    $UserDB = new Users($db);

    //$result = $UserDB->getUserByUname("t.lajos@email.hu");
    //$result = $UserDB->getAllUser();
    //($UserDB->deleteUserByUname("delete")) ? $result = array("Message"=>"deleted") : $result = array("Message"=>"failed");
    //$result = $UserDB->updateUser('t@t.t','test123');
    $result = $UserDB->createUser('test@t.t','test123', 'test', '+36', '0');
    
    if($result != null){
        echo json_encode(array('data'=>$result));
    }
    else{
        echo json_encode(array('message' => 'No post found'));
    }
?>
