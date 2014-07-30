<?php

class SignUp extends Controller {

    public function __construct() {
        
    }

    public function index() {
        $logger = Logger::getInstance();
        $logger->debug('Request for signup page.');
        $request = $this->getServerRequest();
        if ($request == 'GET') {
            $errors = [];
            $logger->debug("GET request.  Rendering signup page.");
            $logger->debug((__DIR__));
            $this->render('templates/signup.html', ['pagetitle' => 'Sign Up']);
        } else if ($request == 'POST') {
            $this->post();
        }
    }

    public function post() {
        $logger = Logger::getInstance();
        $errors = array();
        $have_error = FALSE;

        $username = $_POST['username'];
        $password = $_POST['password'];
        $password_verification = $_POST['verify'];

        if (file_exists('../app/models/Validation.php')) {
            require_once('../app/models/Validation.php');
            $validation = new Validation();
        } else {
            $logger->debug('Validation object not instantiated. Validation does\'nt exist');
        }

        if (!$validation->validUsername($username)) {
            $errors['error_username'] = 'Username not valid';
            $have_error = TRUE;
        }
        
        if (!$validation->validPassword($password)) {
            $errors['error_password'] = 'Password not valid';
            $have_error = TRUE;
        }

        $logger->debug('Verifying password and username.');
        if (!$validation->verifyPassword($password, $password_verification)) {
            $errors['error_verify'] = 'Passwords don\'t match';
            $have_error = TRUE;
        }

//        if (!$this->validEmail($email)) {
//            $errors['error_email'] = 'Email not valid';
//            $have_error = TRUE;
//        }

        if ($have_error) {
            $logger->debug("Rendering sign up page again user errors.");
            return $this->render('templates/signup.html', ['error' => $errors, 'username' => $username]);
        } else {
            $todo = $this->model('User');
            $securepass = $this->make_secure($password);
            $todo->createUser($username, $securepass);
            /*
             * Need to add check if createUser Success
             */
            $logger->debug("User passed all validations redirecting to login page.");
            header('Location:/mvctodolist/public/login');
        }
    }

    public function make_secure($password) {
        /** salt should be kept in a separate file * */
        $salt = 'jenkins';
        $securepass = hash_hmac('sha256', $password, $salt);
        return $securepass;
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