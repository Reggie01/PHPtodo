<?php

class SignUp extends Controller {

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
        $errors = array();
        $have_error = FALSE;

        $username = $_POST['username'];
        $password = $_POST['password'];
        $verify = $_POST['verify'];


        if (!$this->validUsername($username)) {
            $errors['error_username'] = 'Username not valid';
            $have_error = TRUE;
        }

        if (!$this->validPassword($password)) {
            $errors['error_password'] = 'Password not valid';
            $have_error = TRUE;
        } elseif ($password != $verify) {
            $errors['error_verify'] = 'Passwords don\'t match';
            $have_error = TRUE;
        }

//        if (!$this->validEmail($email)) {
//            $errors['error_email'] = 'Email not valid';
//            $have_error = TRUE;
//        }

        if ($have_error) {
            return $this->render('templates/signup.html', ['error' => $errors, 'username' => $username ]);
        } else {
            $todo = $this->model('User');
            $securepass = $this->make_secure($password);
            $todo->createUser($username, $securepass);
            return $this->render('templates/welcome.html.twig', ['pagetitle' => 'Welcome', 'username' => $username]);
        }
    }

    public function make_secure($password) {
        /** salt should be kept in a separate file * */
        $salt = 'jenkins';
        $securepass = hash_hmac('sha256', $password, $salt);
        return $securepass;
    }

    public function validUsername($username) {
        $regexForValidUser = '/([a-zA-Z0-9_-]){3,20}$/';
        if (!empty($username) && preg_match($regexForValidUser, $username)) {
            return TRUE;
        }
        return FALSE;
    }

    public function validPassword($password) {
        $regexForValidPassword = '/.{3,20}/';
        if (!empty($password) && preg_match($regexForValidPassword, $password)) {
            return TRUE;
        }
        return FALSE;
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