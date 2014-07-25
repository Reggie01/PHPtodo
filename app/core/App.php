<?php

class App {

    protected $controller = 'home';
    protected $method = 'index';
    protected $params = [];

    public function __construct() {

        $url = $this->parseUrl();
        $logger = Logger::getInstance();
        $logger->info('Is the url empty.');
        if(isset($url)) {
            foreach($url as $item){
                $logger->info('Items in url: ');
                $logger->info($item);
            }
        }
        $logger->info('End of items in url');
        
        $file = $_SERVER['DOCUMENT_ROOT'] . "/mvctodolist/app/controllers/" . $url[0] . '.php';

        if (file_exists($file)) {
            $this->controller = $url[0];
            unset($url[0]);
        }

        require_once $_SERVER['DOCUMENT_ROOT'] . '/mvctodolist/app/controllers/' . $this->controller . '.php';

        $this->controller = new $this->controller;

        if (isset($url[1])) {

            if (method_exists($this->controller, $url[1])) {
                $this->method = $url[1];
                unset($url[1]);
            }
        }

        $this->params = $url ? array_values($url) : [];

        call_user_func_array([$this->controller, $this->method], $this->params);
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
