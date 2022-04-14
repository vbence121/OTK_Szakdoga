<?php
    class GET{
        public $DB;

    }

    //header
    header('Acces-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once('../includes/initialize.php');


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
