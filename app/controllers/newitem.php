<?php

    class NewItem extends Controller{
    
        public function __construct(){
        }
        
        public function index(){
            if ($this->getServerRequest() == 'GET'){
                echo 'get';
                $this->get();
            } else if($this->getServerRequest() == 'POST'){
                echo 'hello';
                $this->post();
            }
        }
        
        public function get(){
           $this->render('templates/newpost.html', ['pagetitle'=>'New Todo']);
        }
        
        public function post() {
            
            $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            if($mysqli->connect_errno){
                echo "Failed to connect to db " . $mysqli->connect_error;
                die();
            }
                        
            if (isset($_POST['content'])) {
                $list = $_POST['content'];
            }
            
            $query = 'INSERT INTO ' . LIST_TABLE . "(list)VALUES('$list')";
            
            print_r($query);
            
            $mysqli->query($query);
            
            $mysqli->close();
            
            $root = $_SERVER['DOCUMENT_ROOT'];
           
            //echo $root.'/mvctodolist/public/home';
            header('Location:/mvctodolist/public/home');
            
        }
    }
?>
    