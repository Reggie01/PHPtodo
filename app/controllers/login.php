<?php

class Login extends Controller {

    public function __construct() {
        
    }

    public function index() {
        $logger = Logger::getInstance();
        $logger->debug('Getting server Request for login page');
        $request = $this->getServerRequest();

        if ($request == 'GET') {
            $logger->debug('Server Request: GET');
            $this->get();
        }
        if ($request == 'POST') {
            $logger->debug('Server Request: Post');
            $this->post();
        }
    }

    public function get() {
        $logger = Logger::getInstance();
        $logger->debug('Rendering login page.');
        $this->render('templates/login.html.twig', ['pagetitle' => 'login']);
    }

    public function post() {
        $logger = Logger::getInstance();
        $have_error = FALSE;
        $errors = [];
        $username = $_POST['userid'];
        $password = $_POST['pass'];
        
        if (file_exists('../app/models/Validation.php')) {
            require_once('../app/models/Validation.php');
            $validation = new Validation();
        } else {
            $logger->debug('Validation object not instantiated. Validation does\'nt exist');
        }

        if (!$validation->validUsername($username)) {
            $logger->debug("User id is not valid.");
            $have_error = TRUE;
            $errors['user_error'] = "User id is not valid";
        }

        if (!$validation->validPassword($password)) {
            $logger->debug("Password is not set.");
            $have_error = TRUE;
            $errors['pass_error'] = 'Password is not set.';
        }

        if ($have_error) {
            $logger->debug("Password or username not valid. Redirect to login page.");
            return $this->render('/templates/login.html.twig', ['error' => $errors]);
        } else {
            $checkVerification = $this->verifyPassword($username, $password);   
            if ($checkVerification) {
                $logger->debug("User exists.");
            } else {
                $logger->debug("User does not exist.");
            }
        }  
    }
    
    private function verifyPassword($password, $username){
        $logger = Logger::getInstance();
        $logger->debug("Create user object to check if user exists.");
        $user = $this->model('User');
        $userExist = $user->verifyUser($password, $username);
        $checkUserExist = $userExist ? TRUE : FALSE;
        return $checkUserExist;
    }
 
}
