<?php
    require_once __DIR__.'Rcontroller.php';
    require_once __DIR__.'users.php';
    require_once __DIR__.'admin.php';

    Class APIcontroller{
        private $users;
        private $admins;

        public function __construct($db)
        {
            $users = New Users($db);
            $admins = New Admins($db);
        }

        // Handle none defined function calls
        public function __call($name, $arguments)
        {
            $this->sendOutput('', array('HTTP/1.1 404 Not Found'));
        }


        // USER SECTION
        public function getAllUsers(){ $this->users->getAllUsers();}
        private function getUnamefromParams(){
            $qUname = '';
            if (isset($this->user->arrQueryStringParams['Uname']) && $this->user->arrQueryStringParams['Uname']) {
                $qUname = $this->users->arrQueryStringParams['Uname'];
            }
            return $qUname;
        }
        public function getUserByUname(){
            $this->users->getUserByUname(
                $this->getUnamefromParams()
            );
        }
        public function deleteUser(){
            $this->users->deleteUs(
                $this->getUnamefromParams()
            );
        }
    }
?>