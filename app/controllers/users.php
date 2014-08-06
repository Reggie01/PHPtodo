<?php

class Users extends Controller {

    public function __construct() {
        $logger = Logger::getInstance();
        session_start();
        if(isset($_SESSION['username'])){
            $logger->debug($_SESSION['username']);
            $logger->debug($_SESSION['user_id']);    
        }
        
    }

    public function index() {
        $logger = Logger::getInstance();
        $logger->debug('Getting server Request for users page');
        $isSessionSet = isset($_SESSION['username']);
        $logger->debug($isSessionSet);
        if(!$isSessionSet){
            return header('Location:mvctodolist/public');
        }
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
        $loggedIn = isset($_SESSION['username']);
        $todos = $this->getAllTodos($_SESSION['user_id']);
        
        $logger->debug('Rendering logged in page.');
        $this->render('/templates/todos.html', ['pagetitle' => 'Welcome', 'username' => $_SESSION['username'], 'todos' => $todos, 'loggedIn' => $loggedIn]);
    }
    
    private function getAllTodos($user_id) {
        $todo = $this->model('Todo');
        $todosList = $todo->getAll($user_id);
        return $todosList;
    }

}
