<?php

class Home extends Controller {

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

        $todos = $this->model('Todo');

        $listOfTodos = $todos->getAll();

        $this->render('templates/todos.html', ['todos' => $listOfTodos, 'pagetitle' => 'Todos']);
    }

    public function edit($value) {
        echo $this->getServerRequest();

        if ($this->getServerRequest() == 'POST') {
            return $this->editPost($value);
        }

        $todo = $this->model('Todo');
        $item = $todo->getEditPage($value);

        $this->render('templates/edit.html', ['content' => $item['item'], 'pagetitle' => 'Edit Todo']);
    }

    public function editPost($value) {

        if (!empty($_POST['content'])) {
            $updatedContent = $_POST['content'];
        } else {

            return $this->render('templates/edit.html', ['pagetitle' => 'Edit Todo', 'error' => 'Don\'t forget to edit content']);
        }

        $todo = $this->model('Todo');
        $todo->update($value, $updatedContent);

        header('Location:/mvctodolist/public');
    }

    public function delete($value) {

        $todo = $this->model('Todo');
        $todo->delete($value);

        header('Location:/mvctodolist/public');
    }

    public function error() {

        $this->render('templates/error.html', ['pagetitle' => 'ERROR']);
    }

}

?>
    