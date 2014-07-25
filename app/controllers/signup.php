<?php

class SignUp extends Controller {
    
    private $password;
    private $username;
    
    public function __construct() {
        
    }

    public function index() {
        $request = $this->getServerRequest();
        if ($request == 'GET') {
            $errors = [];
            //var_dump($errors);
            $this->render('templates/signup.html', ['pagetitle' => 'Sign Up']);
        } else if ($request == 'POST') {
            $this->post();
        }
    }

    public function post() {
        $logger = Logger::getInstance();
        $errors = array();
        $have_error = FALSE;

        $username = null;
        $password = null;
        $verify = null;


        if (!$this->validUsername()) {
            $errors['error_username'] = 'Username not valid';
            $have_error = TRUE;
        }

        if (!$this->validPassword()) {
            $errors['error_password'] = 'Password not valid';
            $have_error = TRUE;
        } 
        
        
        if (!empty($_POST['verify'])) {
            $verify = $_POST['verify'];
            $logger->debug('Verifying email entered correctly 2x.');
            $logger->debug('Value of user verify' . $verify);
            if(!($verify === $this->password)){
                $logger->debug('Passwords did not match');
                $errors['error_verify'] = 'Passwords don\'t match';
                $have_error = TRUE;
            }
        } else {
            $logger->debug('Verification was not filled out.');
            $errors['error_verify'] = 'Passwords don\'t match';
            $have_error = TRUE; 
        }

//        if (!$this->validEmail($email)) {
//            $errors['error_email'] = 'Email not valid';
//            $have_error = TRUE;
//        }

        if ($have_error) {
            $logger->debug("Rendering sign up page again user errors.");
            return $this->render('templates/signup.html', ['error' => $errors, 'username' => $username ]);
        } else {
            $todo = $this->model('User');
            $username = $this->getUsername();
            $password = $this->getPassword();
            $securepass = $this->make_secure($password);
            $todo->createUser($username, $securepass);
            $logger->debug("User passed all validations redirecting to login page.");
            header('Location:/mvctodolist/public/login');
            //return $this->render('templates/welcome.html.twig', ['pagetitle' => 'Welcome', 'username' => $username]);
        }
    }

    public function make_secure($password) {
        /** salt should be kept in a separate file * */
        $salt = 'jenkins';
        $securepass = hash_hmac('sha256', $password, $salt);
        return $securepass;
    }

    public function validUsername() {
        $logger = Logger::getInstance();
        $logger->debug('Validating user name.');
        if(!empty($_POST['username'])){
            $username = $_POST['username'];
            $regexForValidUser = '/([a-zA-Z0-9_-]){3,20}$/';
            if (preg_match($regexForValidUser, $username)) {
                $this->setUsername($username);
                $logger->debug("Validation passed for user");
                return TRUE;
            } else {
                $logger->debug("Valid failed for user");
                return FALSE;
            }
        }
        $logger->debug("Valid failed for user");
        return FALSE;
    }

    public function validPassword() {
        $logger = Logger::getInstance();
        $logger->debug('Validating password.');
        if(!empty($_POST['password'])){
            $regexForValidPassword = '/.{3,20}/';
            $password = $_POST['password'];
            if (preg_match($regexForValidPassword, $password)) {
                $this->setPassword($password);
                $logger->debug('Validation passed for password.');
                return TRUE;
            } else {
                $logger->debug('Validation failed for password.');
                return FALSE;
            } 
            
        }
        $logger->debug('Validation failed for password.');
        return FALSE;
    }
    
    private function setPassword($password){
        $this->password = $password;
    }
    
    private function getPassword() {
        return $this->password;
    }
    
    private function setUsername($username){
        $this->username = $username;
    }
    
    private function getUsername() {
        return $this->username;
    }

//    public function validEmail($email) {
//        $regexForValidEmail = '/^[\S]+@[\S]+\.[\S]+/';
//        if (!empty($email) && preg_match($regexForValidEmail, $email)) {
//            return TRUE;
//        }
//        return FALSE;
//    }

}

?>