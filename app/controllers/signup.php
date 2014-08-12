<?php

class SignUp extends Controller {
    
    /** $validation object **/
    public $validation;
    public $errors = array();
    public $UserInputsNotValid = False;
    
    public function __construct() { }

    public function index() {
        $logger = Logger::getInstance();
        $logger->debug('Request for signup page.');
        $request = $this->getServerRequest();
        if ($request == 'GET') {
            $this->get();
        } else if ($request == 'POST') {
            $this->post();
        }
    }
    
    public function get() {
        $logger = Logger::getInstance();
        $logger->debug("GET request.  Rendering signup page.");
        $this->render('templates/signup.html', ['pagetitle' => 'Sign Up']);
    }

    public function post() {
        $logger = Logger::getInstance();
        $username = $_POST['username'];
        $password = $_POST['password'];
        $password_verification = $_POST['verify'];
        
        $this->checkUserInputsValid($username, $password, $password_verification);

        if ($this->UserInputsNotValid) {
            $logger->debug("Rendering sign up page again user errors.");
            return $this->render('templates/signup.html', ['pagetitle' => 'Sign Up', 'error' => $this->errors, 'username' => $username]);
        } else {
            $user = $this->model('User');
            if(!($user->userExists($username))){
                
                $this->createUser($username, $password, $securepass, $user);    
            } else {
                $logger->debug('Username already exists.');
                $this->errors['error_username'] = 'Username already exists. Chose another name.';
                return $this->render('templates/signup.html', ['pagetitle' => 'Sign Up', 'error' => $this->errors, 'username' => $username]);
            }
        }
    }
    
    public function setValidation($validation) {
        $logger = Logger::getInstance();
        if(!isset($validation)){
            $logger->debug("Validation instance not set.");
            return; 
        }
        $this->validation = $validation;
    }
    
    private function checkUserInputsValid($username, $password, $password_verification){
        $this->isValidUsername($username);
        $this->isValidPassword($password);
        $this->isValidPasswordVerification($password, $password_verification);
    }

    private function isValidUsername($username) {
        if (!$this->validation->validUsername($username)) {
            $this->errors['error_username'] = 'Username not valid';
            $this->UserInputsNotValid = TRUE;
        }
    }
    
    private function isValidPassword($password){
        if (!$this->validation->validPassword($password)) {
            $this->errors['error_password'] = 'Password not valid';
            $this->UserInputsNotValid = TRUE;
        }
    }
    
    private function isValidPasswordVerification($password, $password_verification) {
        if (!$this->validation->verifyPassword($password, $password_verification)) {
            $this->errors['error_verify'] = 'Passwords don\'t match';
            $this->UserInputsNotValid = TRUE;
        }
    }
    
    private function createUser($username, $password, $securepass, $user){
        $logger = Logger::getInstance();
        $securepass = $this->make_secure($password);
        $user->createUser($username, $securepass);
        $logger->debug("New user created redirecting to login page.");
        header('Location:/mvctodolist/public/login'); 
    }
    
    private function make_secure($password) {
        /** salt should be kept in a separate file * */
        /** method should be in another Class security, not in vcs **/
        $salt = 'jenkins';
        $securepass = hash_hmac('sha256', $password, $salt);
        return $securepass;
    }

    
}

?>