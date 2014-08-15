<?php

class Login extends Controller {
    
    /** $validation object **/
    public $validation;
    public $errors = array();
    public $have_error = False;
    public $hello = 'hello';

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
        $this->render('templates/login.html.twig', ['pagetitle' => 'Login']);
    }

    public function post() {
        $logger = Logger::getInstance();
        $username = $_POST['userid'];
        $password = $_POST['pass'];

        $this->checkUserInputsValid($username, $password);

        if ($this->have_error) {
            $logger->debug("Password or username not valid. Redirect to login page.");
            return $this->render('/templates/login.html.twig', ['error' => $this->errors]);
        } else {
            $UserExists = $this->verifyUserExists($username, $password);
            if ($UserExists) {
                $logger->debug("User exists.");
                header('Location:/mvctodolist/public/users');
            } else {
                $logger->debug("User does not exist.");
                $this->errors['user_error'] = 'User does not exist.';
                return $this->render('/templates/login.html.twig', ['error' => $this->errors]);
            }
        }
    }

    public function setValidation($validation) {
        $logger = Logger::getInstance();
        if(!isset($validation)){
            $logger->debug("Validation method not set.");
            return; 
        }
        $this->validation = $validation;
    }

    public function checkUserInputsValid($username, $password) {
        $this->isValidUsername($username);
        $this->isValidPassword($password);
    }

    private function isValidUsername($username) {
        $logger = Logger::getInstance();
        if (!$this->validation->validUsername($username)) {
            $logger->debug("User id is not valid.");
            $this->have_error = TRUE;
            $this->errors['user_error'] = "User id is not valid";
        }
    }

    private function isValidPassword($password) {
        $logger = Logger::getInstance();
        if (!$this->validation->validPassword($password)) {
            $logger->debug("Password is not set.");
            $this->have_error = TRUE;
            $this->errors['pass_error'] = 'Password is not set.';
        }
    }

    private function verifyUserExists($password, $username) {
        $logger = Logger::getInstance();
        $logger->debug("Create user object to check if user exists.");
        $user = $this->model('User');
        $userExist = $user->verifyUser($password, $username);
        $checkUserExist = $userExist ? TRUE : FALSE;
        return $checkUserExist;
    }

}
