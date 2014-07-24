<?php

class Controller {
    
    public function __construct() {
        
    }

    public function model($model) {
        require_once '../app/models/' . $model . '.php';
        return new $model();
    }

    public function getServerRequest() {
        $request = $_SERVER['REQUEST_METHOD'];
        return $request;
    }
    

    public function render($view, $data = []) {
        $filename = '../vendor/autoload.php';

        if (file_exists($filename)) {
            require_once '../vendor/autoload.php';
        } else {
            echo "$filename does not exist";
        }

        $loader = new Twig_Loader_Filesystem('../app/views/');
        $twig = new Twig_Environment($loader, array('autoescape' => true));

        echo $twig->render($view, $data);
    }

}

?>
