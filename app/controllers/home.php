<?php

class Home extends Controller {

    public function __construct() {
        
    }

    public function index() {
            $this->get();
    }

    public function get() {
        $logger = Logger::getInstance();
        $logger->debug('Retrieving all todos.');
        $todos = $this->model('Todo');

        $listOfTodos = $todos->getAll();

        $this->render('templates/todos.html', ['todos' => $listOfTodos, 'pagetitle' => 'Todos']);
    }

    public function edit($value) {
        $logger = Logger::getInstance();
        if ($this->getServerRequest() == 'POST') {
            $logger->debug('Editing post');
            return $this->editPost($value);
        }

        $todo = $this->model('Todo');
        $item = $todo->getEditPage($value);

        $this->render('templates/edit.html', ['content' => $item['item'], 'pagetitle' => 'Edit Todo']);
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
    