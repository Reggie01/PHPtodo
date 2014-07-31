<?php

class Users extends Controller {

    public function __construct() {
        $logger = Logger::getInstance();
        session_start();
        $logger->debug($_SESSION['username']);
    }

    public function index() {
        $logger = Logger::getInstance();
        $logger->debug('Getting server Request for users page');
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
        $logger->debug('Rendering logged in page.');
        return $this->render('/templates/loggedIn.html.twig', ['pagetitle' => 'Welcome', 'username' => $_SESSION['username']]);
    }

}
