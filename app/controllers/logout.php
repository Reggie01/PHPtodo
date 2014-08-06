<?php

    class Logout{
        
        public function __construct() {}
        
        public function index() {
            session_start();
            $_SESSION = array();
            session_destroy();
            if(isset($_SESSION['username'])) {
                $logger->debug('Session is not destroyed.');
            }
            
            header('Location:/mvctodolist/public');
        }
    }

