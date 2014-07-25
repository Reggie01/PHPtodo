<?php

class Login extends Controller {
    
    
    public function __construct(){
    }
    
    public function index(){
        $logger = Logger::getInstance();
        $logger->debug('Getting server Request for login page');
        $request = $this->getServerRequest();
        
        if($request == 'GET') {
            $this->get();
            $logger->debug('Server Request: GET');
        }
        if($request == 'POST') {
            $this->post();
            $logger->debug('Server Request: Post');
        }
    }
    
    
    public function get(){
        echo substr($_SERVER['PHP_SELF'], -10);
        $logger = Logger::getInstance();
        $logger->debug('Rendering login page.');
        $this->render('templates/login.html.twig', ['pagetitle'=>'login']);
    }
    
    public function post(){
        $logger = Logger::getInstance();
        
        $have_error = FALSE;
        $errors = [];
        
        if (!validUserName()){
            $logger->debug("User id is not valid.");
            $have_error = TRUE;
            $have_error['user_error'] = "User id is not valid";

        } else {
            $logger->debug("User id is not set.");
            $have_error = TRUE;
            $have_error['user_error'] = 'User id is not set.';
        }
        
        if ($this->validPassword()){
            
        } else {
            $logger->debug("Password is not set.");
            $have_error = TRUE;
            $have_error['pass_error'] = 'Password is not set.';
        }
        
        $logger->debug();
    }
    
    public function validUsername() {
        $regexForValidUser = '/([a-zA-Z0-9_-]){3,20}$/';
        if (preg_match($regexForValidUser, $username)) {
            
            return TRUE;
        }
        return FALSE;
    }

    public function validPassword($password) {
        $regexForValidPassword = '/.{3,20}/';
        if (preg_match($regexForValidPassword, $password)) {
            return TRUE;
        }
        return FALSE;
    } 
}


