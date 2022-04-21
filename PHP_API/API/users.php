<?php
    class Users extends RequestController{
        /* 
        // public
        public $Uname;
        public $enc_pass;
        public $name;
        public $mobile;
        public $tagsag;
        */

        public function getUserByUname(){
            $query = '
            SELECT *
            FROM users
            ';

            $methodRequest = $_SERVER["REQUEST_METHOD"];
            $querySttringParams = $this->getQueryStringParams();
            //echo($querySttringParams);
            if(strtoupper($methodRequest) == 'GET'){
                try{
                    if (isset($querySttringParams['uname']) && $querySttringParams['uname'] && ($this->inputValidate('uname',$querySttringParams['uname']) != null)) {
                        $query = $query.' WHERE Uname LIKE \''.($this->inputValidate('uname',$querySttringParams['uname'])).'\'';
                    }
                    else{
                        $this->sendOutput(json_encode(array('error' => 'Missing Uname filter.')), 
                        array('Content-Type: application/json', 'HTTP/1.1 422 Unprocessable Entity'));
                    }
                    if (isset($querySttringParams['limit']) && $querySttringParams['limit']) {
                        $query = $query.' LIMIT '.$querySttringParams['limit'];
                    }

                    $stmt = $this->DB->prepare($query);
                    $stmt->execute();
                    if(($stmt != null) and ($stmt->rowCount() == 1)){
                        extract($stmt->fetch(PDO::FETCH_ASSOC));
                        $this->sendOutput(json_encode(array(
                            'Uname' => $Uname,
                            'enc_pass' => $enc_pass,
                            'name' => $name,
                            'mobile' => $mobile,
                            'tagsag' => $tagsag
                        )),
                        array('Content-Type: application/json', 'HTTP/1.1 200 OK'));
                    }
                } catch(ERROR $ex){
                    $this->sendOutput(json_encode(array('error' => 'Unexpected error. Try again later.')), 
                    array('Content-Type: application/json', 'HTTP/1.1 500 Internal Server Error'));
                }
            }
            else{
                $this->sendOutput(json_encode(array('error' => 'Unsupported Method call.')), 
                array('Content-Type: application/json', 'HTTP/1.1 422 Unprocessable Entity'));
            }
        }

        public function getAllUser(){
            $query = '
            SELECT *
            FROM users
            ORDER BY Uname DESC
            ';

            $methodRequest = $_SERVER["REQUEST_METHOD"];
            $querySttringParams = $this->getQueryStringParams();

            if(strtoupper($methodRequest) == 'GET'){
                try{
                    if (isset($querySttringParams['limit']) && $querySttringParams['limit']) {
                        $query = $query.' LIMIT '.$querySttringParams['limit'];
                    }

                    $stmt = $this->DB->prepare($query);
                    $stmt->execute();
                    if(($stmt != null) and ($stmt->rowCount() > 0)){
                        $get_arr = array();
                        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                            extract($row);
                            $post_item = array(
                                'Uname' => $Uname,
                                'enc_pass' => $enc_pass,
                                'name' => $name,
                                'mobile' => $mobile,
                                'tagsag' => $tagsag
                            );
                            array_push($get_arr, $post_item);
                        }

                        $this->sendOutput(json_encode($get_arr),array('Content-Type: application/json', 'HTTP/1.1 200 OK'));
                    }
                } catch(ERROR $ex){
                    $this->sendOutput(json_encode(array('error' => 'Unexpected error. Try again later.')), 
                    array('Content-Type: application/json', 'HTTP/1.1 500 Internal Server Error'));
                }
            }
            else{
                $this->sendOutput(json_encode(array('error' => 'Unsupported Method call.')), 
                array('Content-Type: application/json', 'HTTP/1.1 422 Unprocessable Entity'));
            }
        }

        public function deleteUserByUname(){
            $query = '
            DELETE
            FROM users
            ';
            $methodRequest = $_SERVER["REQUEST_METHOD"];
            $querySttringParams = $this->getQueryStringParams();

            if(strtoupper($methodRequest) == 'DELETE'){
                try{
                    if (isset($querySttringParams['uname']) && $querySttringParams['uname'] && ($this->inputValidate('uname',$querySttringParams['uname']) != null)) {
                        $query = $query.' WHERE Uname LIKE \''.($this->inputValidate('uname',$querySttringParams['uname'])).'\'';
                    }
                    else{
                        $this->sendOutput(json_encode(array('error' => 'Missing Uname filter.')), 
                        array('Content-Type: application/json', 'HTTP/1.1 422 Unprocessable Entity'));
                    }
                    $stmt = $this->DB->prepare($query);
                    $stmt->execute();
                    $this->sendOutput(json_encode(array('message' => 'OK')), 
                    array('Content-Type: application/json', 'HTTP/1.1 200 OK'));
                } catch(ERROR $ex){
                    $this->sendOutput(json_encode(array('error' => 'Unexpected error. Try again later.')), 
                    array('Content-Type: application/json', 'HTTP/1.1 500 Internal Server Error'));
                }
            }
            else{
                $this->sendOutput(json_encode(array('error' => 'Unsupported Method call.')), 
                array('Content-Type: application/json', 'HTTP/1.1 422 Unprocessable Entity'));
            }
        }

        public function updateUser(){
            $Uname = null;
            $enc_pass = null;
            $name= null;
            $mobile=null;
            $tagsag=null;

            $methodRequest = $_SERVER["REQUEST_METHOD"];
            $querySttringParams = $this->getQueryStringParams();

            if(strtoupper($methodRequest) == 'PUT'){
                try{
                    if (isset($querySttringParams['uname']) && $querySttringParams['uname'] && ($this->inputValidate('uname', $querySttringParams['uname']) != null)) {
                        $Uname = $this->inputValidate('uname', $querySttringParams['uname']);
                    }
                    else{
                        $this->sendOutput(json_encode(array('error' => 'Missing Uname filter.')), 
                        array('Content-Type: application/json', 'HTTP/1.1 422 Unprocessable Entity'));
                    }
                    if (isset($querySttringParams['encpass']) && $querySttringParams['encpass']) {
                        $enc_pass = $querySttringParams['encpass'];
                    }
                    /*else{
                        $this->sendOutput(json_encode(array('error' => 'Missing encpass param. User lockout prevented')), 
                        array('Content-Type: application/json', 'HTTP/1.1 422 Unprocessable Entity'));
                    }*/
                    if (isset($querySttringParams['name']) && $querySttringParams['name'] && ($this->inputValidate('name', $querySttringParams['name']) != null)) {
                        $name = $this->inputValidate('name', $querySttringParams['name']);
                    }
                    if (isset($querySttringParams['mobile']) && $querySttringParams['mobile'] && ($this->inputValidate('mobile', $querySttringParams['mobile']) != null)) {
                        $name = $this->inputValidate('mobile', $querySttringParams['mobile']);
                    }
                    if (isset($querySttringParams['tagsag']) && $querySttringParams['tagsag'] && ($this->inputValidate('tagsag', $querySttringParams['tagsag']) != null)) {
                        $name = $this->inputValidate('tagsag', $querySttringParams['tagsag']);
                    }
    
                    $query = 'UPDATE users ';
                    if($name!=null){ $query = $query.'name= \''.$name.'\', ';}
                    if($mobile!=null){ $query = $query.'mobile= \''.$mobile.'\', ';}
                    if($tagsag!=null){ $query = $query.'tagsag= \''.$tagsag.'\', ';}
                    if($enc_pass!=null){ $query = $query.'encpass= \''.$enc_pass.'\', ';}
                    if(substr($query,-1) == ',') $query = substr($query,0,-1);
                    if($Uname == null){
                        $this->sendOutput(json_encode(array('error' => 'Unexpected error. Try again later.')), 
                        array('Content-Type: application/json', 'HTTP/1.1 500 Internal Server Error'));
                    }
                    else{
                        $query = $query.'WHERE Uname LIKE \''.$Uname.'\'';
                    }
                    if (isset($querySttringParams['limit']) && $querySttringParams['limit']) {
                        $query = $query.' LIMIT '.$querySttringParams['limit'];
                    }
                    $stmt = $this->DB->prepare($query);
                    $stmt->execute();
                    $this->sendOutput(json_encode(array('message' => 'OK')), 
                    array('Content-Type: application/json', 'HTTP/1.1 200 OK'));
                } catch(ERROR $ex){
                    $this->sendOutput(json_encode(array('error' => 'Unexpected error. Try again later.')), 
                    array('Content-Type: application/json', 'HTTP/1.1 500 Internal Server Error'));
                }
            }
            else{
                $this->sendOutput(json_encode(array('error' => 'Unsupported Method call.')), 
                array('Content-Type: application/json', 'HTTP/1.1 422 Unprocessable Entity'));
            }
        }

        public function createUser(){
            $Uname = null;
            $enc_pass = "";
            $name= "";
            $mobile="";
            $tagsag="";

            $methodRequest = $_SERVER["REQUEST_METHOD"];
            $querySttringParams = $this->getQueryStringParams();

            if(strtoupper($methodRequest) == 'POST'){
                try{
                    if (isset($querySttringParams['uname']) && $querySttringParams['uname'] && ($this->inputValidate('uname', $querySttringParams['uname']) != null)) {
                        $Uname = $this->inputValidate('uname', $querySttringParams['uname']);
                    }
                    else{
                        $this->sendOutput(json_encode(array('error' => 'Missing Uname filter.')), 
                        array('Content-Type: application/json', 'HTTP/1.1 422 Unprocessable Entity'));
                    }
                    if (isset($querySttringParams['encpass']) && $querySttringParams['encpass']) {
                        $enc_pass = $querySttringParams['encpass'];
                    }
                    /*else{
                        $this->sendOutput(json_encode(array('error' => 'Missing encpass param. User lockout prevented')), 
                        array('Content-Type: application/json', 'HTTP/1.1 422 Unprocessable Entity'));
                    }*/
                    if (isset($querySttringParams['name']) && $querySttringParams['name'] && ($this->inputValidate('name', $querySttringParams['name']) != null)) {
                        $name = $this->inputValidate('name', $querySttringParams['name']);
                    }
                    if (isset($querySttringParams['mobile']) && $querySttringParams['mobile'] && ($this->inputValidate('mobile', $querySttringParams['mobile']) != null)) {
                        $name = $this->inputValidate('mobile', $querySttringParams['mobile']);
                    }
                    if (isset($querySttringParams['tagsag']) && $querySttringParams['tagsag'] && ($this->inputValidate('tagsag', $querySttringParams['tagsag']) != null)) {
                        $name = $this->inputValidate('tagsag', $querySttringParams['tagsag']);
                    }

                    $set = 'INSERT INTO users Values (';
        
                    if($Uname==null){
                        $this->sendOutput(json_encode(array('error' => 'Unexpected error. Try again later.')), 
                        array('Content-Type: application/json', 'HTTP/1.1 500 Internal Server Error'));
                    }
                    else{
                        $set= $set.'\''.$Uname.'\', ';
                    }
        
                    $set= $set.'\''.$enc_pass.'\', ';
                    $set= $set.'\''.$name.'\', ';
                    $set= $set.'\''.$mobile.'\', ';
                    $set= $set.'\''.$tagsag.'\')';

                    $stmt = $this->DB->prepare($set);
                    $stmt->execute();
                    $this->sendOutput(json_encode(array('message' => 'OK')), 
                    array('Content-Type: application/json', 'HTTP/1.1 200 OK'));
                } catch(ERROR $ex){
                    $this->sendOutput(json_encode(array('error' => 'Unexpected error. Try again later.')), 
                    array('Content-Type: application/json', 'HTTP/1.1 500 Internal Server Error'));
                }
            }
            else{
                $this->sendOutput(json_encode(array('error' => 'Unsupported Method call.')), 
                array('Content-Type: application/json', 'HTTP/1.1 422 Unprocessable Entity'));
            }
        }

        public function searchQuery($queryT=null){
            if($queryT == null){
                return null;
            }
            $query = 'SELECT * FROM users '.$queryT;
            $stmt = $this->DB->prepare($query);
            $stmt->execute();
            if(($stmt != null) and ($stmt->rowCount() > 0)){
                $get_arr = array();
                while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                    extract($row);
                    $query_item = array(
                        'Uname' => $Uname,
                        'enc_pass' => $enc_pass,
                        'name' => $name,
                        'mobile' => $mobile,
                        'tagsag' => $tagsag
                    );
                    array_push($get_arr, $query_item);
                }
                return $get_arr;
            }
            else{
                return null;
            }
        }
    }

?>