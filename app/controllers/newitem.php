<?php

class NewItem extends Controller {

    public function __construct() {
        
    }

    public function index() {
        if ($this->getServerRequest() == 'GET') {
            
            $this->get();
        } else if ($this->getServerRequest() == 'POST') {
            
            $this->post();
        }
    }

    public function get() {
        $this->render('templates/newtodo.html', ['pagetitle' => 'Create Todo']);
    }

    public function post() {

        if (!empty($_POST['content'])) {
            $newTodo = $_POST['content'];
        } else {
            return $this->render('templates/newtodo.html', ['pagetitle' => 'New Todo', 'error' => 'Please fill out form']);
        }

        $todo = $this->model('Todo');
        $todo->createTodo($newTodo);

        header('Location:/mvctodolist/public/home');
    }

}

?>
    