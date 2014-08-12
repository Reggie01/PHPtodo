<?php

class App {

    protected $controller = 'home';
    protected $method = 'index';
    protected $params = [];

    public function __construct() {

        $url = $this->parseUrl();
        $logger = Logger::getInstance();
        $logger->debug('Starting app.');
        
        $file = $_SERVER['DOCUMENT_ROOT'] . "/mvctodolist/app/controllers/" . $url[0] . '.php';

        if (file_exists($file)) {
            $this->controller = $url[0];
            unset($url[0]);
        }
        
        $this->CreateController();
                       
        if (isset($url[1])) {

            if (method_exists($this->controller, $url[1])) {
                $this->method = $url[1];
                unset($url[1]);
            }
        }

        $this->params = $url ? array_values($url) : [];

        call_user_func_array([$this->controller, $this->method], $this->params);
    }
    
    private function createController() {
        $logger = Logger::getInstance();
        $logger->debug('Creating controller.');
        $logger->debug('Controller name: ' . $this->controller);
        $controller = $this->controller;
        require_once $_SERVER['DOCUMENT_ROOT'] . '/mvctodolist/app/controllers/' . $this->controller . '.php';
        $this->controller = new $this->controller;
        if($this->isLoginOrSignupController($controller)) {
            
            $validation = $this->createValidationObject();
            $controller = $this->controller;
            $controller->setValidation($validation);
        } 
        
    }
    
    private function isLoginOrSignupController($controller) {
        $logger = Logger::getInstance();
        $logger->debug("Checking if controller is login or signup.");
        if ($controller == 'login' || $controller == 'signup') {
            $logger->debug('Controller is : ' . $controller);
            return True;  
        }
    }
    
    private function createValidationObject() {
        $logger = Logger::getInstance();
        $logger->debug('Attempting to create Validation object.');
        $file = $_SERVER['DOCUMENT_ROOT'] . "/mvctodolist/app/models/Validation.php";
        if (file_exists($file)) {
            require_once($file);
            $validation = new Validation();
            return $validation;
        } else {
            $logger->debug('Validation object not created.');
        }
    }

    /*
     * @return array
     */
    public function parseUrl() {

        if (isset($_GET['url'])) {
            $url = explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));

            return $url;
        }
    }

}

?>
