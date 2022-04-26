<?php
    require_once(__DIR__.DS.'Rcontroller.php');
    require_once(__DIR__.DS.'users.php');
    require_once(__DIR__.DS.'admin.php');

    Class APIcontroller{
        private $users;
        private $admins;

        public function __construct($db)
        {
            $this->users = New Users($db);
            $this->admins = New Admins($db);
        }

        // Handle none defined function calls
        public function __call($name, $arguments)
        {
            $this->sendOutput('', array('HTTP/1.1 404 Not Found'));
        }

        protected function sendOutput($data, $httpHeaders=array())
        {
            header_remove('Set-Cookie');
     
            if (is_array($httpHeaders) && count($httpHeaders)) {
                foreach ($httpHeaders as $httpHeader) {
                    header($httpHeader);
                }
            }
     
            echo $data;
            exit;
        }
        
        // USER SECTION
        public function getAll_users(){      $this->users->getAllUser();         }
        public function getByUname_users(){  $this->users->getUserByUname();     }
        public function delete_users(){      $this->users->deleteUserByUname();  }
        public function login_users(){       $this->users->checkLogin();         }
        public function register_users(){    $this->users->createUser();         }
    }
?>