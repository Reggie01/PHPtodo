<?php

class NewItem extends Controller {

    public function __construct() {
        $logger = Logger::getInstance();
        session_start();
        if(isset($_SERVER['username'])){
            $logger->debug($_SESSION['username']);
            $logger->debug($_SESSION['user_id']);
        }
    }

    public function index() {
        if ($this->getServerRequest() == 'GET') {

            $this->get();
        } else if ($this->getServerRequest() == 'POST') {
            
            $this->post();
        }
    }

    public function get() {
        $logger = Logger::getInstance();
        $isLoggedIn = isset($_SESSION['username']);
        $logger->debug($isLoggedIn);
        $this->render('templates/newtodo.html', ['pagetitle' => 'Create Todo', 'base' => 'templates/loggedInBase.html.twig', 'loggedIn' => $isLoggedIn]);
    }

    public function post() {
        $logger = Logger::getInstance();
        $isLoggedIn = isset($_SESSION['username']);
        $logger->debug('Is user logged in: ' . $isLoggedIn);
        if (!empty($_POST['content'])) {
            $newTodo = $_POST['content'];
        } else {
            return $this->render('templates/newtodo.html', ['pagetitle' => 'New Todo', 'error' => 'Please fill out form', 'loggedIn' => $isLoggedIn]);
        }

        $todo = $this->model('Todo');
        
        $todo->createTodo($newTodo);
        assert('true', !empty($_POST['content']));
        header('Location:/mvctodolist/public/home');
    }

}

?>
    