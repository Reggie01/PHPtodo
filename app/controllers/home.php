<?php

class Home extends Controller {

    public function __construct() {
        $logger = Logger::getInstance();
        session_start();
        if(isset($_SERVER['username'])){
            $logger->debug($_SESSION['username']);
            $logger->debug($_SESSION['user_id']);
        }
    }

    public function index() {
        $isLoggedIn = isset($_SESSION['username']);
        $this->get($isLoggedIn);
    }
    
    private function get($isLoggedIn) {
        $logger = Logger::getInstance();
        $logger->debug('Retrieving all todos.');
        $isLoggedIn ? $this->getLoggedIn($isLoggedIn) : $this->getLoggedOut();
        
    }
    
    private function getLoggedIn($isLoggedIn){
        $logger = Logger::getInstance();
        $logger->debug('User logged in.');
        $todos = $this->model('Todo');
        $listOfTodos = $todos->getAll($_SESSION['user_id']);
        $username = $_SESSION['username'];
        return $this->render('templates/todos.html', ['todos' => $listOfTodos, 'pagetitle' => 'Todos', 'loggedIn' => $isLoggedIn, 'username' => $username]);
    }
    
    private function getLoggedOut() {
        $logger = Logger::getInstance();
        $logger->debug('User not logged in.');
        $todos = $this->model('Todo');
        $listOfTodos = $todos->getAll();
        return $this->render('templates/todos.html', ['todos' => $listOfTodos, 'pagetitle' => 'Todos']);
    }
    
    public function edit($value) {
        $logger = Logger::getInstance();
        $isLoggedIn = isset($_SESSION['username']);
        if ($this->getServerRequest() == 'POST') {
            $logger->debug('Editing post');
            return $this->editPost($value);
        }

        $todo = $this->model('Todo');
        $item = $todo->getTodoForEdit($value);

        $this->render('templates/edit.html', ['content' => $item['item'], 'pagetitle' => 'Edit Todo', 'loggedIn' => $isLoggedIn]);
    }

    private function editPost($value) {
        $logger = Logger::getInstance();
        if (!empty($_POST['content'])) {
            $updatedContent = $_POST['content'];
        } else {
            $logger->debug('Post content was removed by user.');
            return $this->render('templates/edit.html', ['pagetitle' => 'Edit Todo', 'error' => 'Don\'t forget to edit content']);
        }

        $todo = $this->model('Todo');
        $todo->update($value, $updatedContent);

        header('Location:/mvctodolist/public');
    }

    public function delete($value) {
        $logger = Logger::getInstance();
        $todo = $this->model('Todo');
        $logger->debug('User attempting to delete todo: ' . $value);
        $todo->delete($value);

        header('Location:/mvctodolist/public');
    }

    public function error() {

        $this->render('templates/error.html', ['pagetitle' => 'ERROR']);
    }

}

?>
    