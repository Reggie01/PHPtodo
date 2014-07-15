<?php

    class Home extends Controller{
    
        public function __construct(){
        }
        
        public function index(){
            if ($this->getServerRequest() == 'GET'){
                $this->get();
            } else if($this->getServerRequest() == 'POST'){
                $this->post();
            }
        }
        
        public function get(){
            
           $todos = $this->model('Todo');
           
           $listOfTodos = $todos->getAll();
                      
           $this->render('templates/todos.html', ['todos'=>$listOfTodos, 'pagetitle'=>'Todos']);
        }
        
        public function post() {
        
        }
        
        public function edit($value){
            echo $this->getServerRequest();
            
            if($this->getServerRequest() == 'POST') {
                $this->editPost($value);
            }
            
            $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            if ($mysqli->connect_errno){
                echo "Databse failed to connect " . $mysqli->connect_error;
                die();
            }
            
            $query = 'SELECT * FROM ' . LIST_TABLE . ' WHERE id = ' . $value;
            if ($res = $mysqli->query($query)) {
                if ($res->num_rows > 0){
                    $row = $res->fetch_assoc();
                    $item = $this->model('Todo');
                    $item->id = $row['id'];
                    $item->item = $row['list']; 
                }
                else{
                    $error = "Record $value does not exist";
                    header("Location:/mvctodolist/public/home/error");                    
                }
                
            } else {
                echo hello;
                $error = "Record $value does not exist";
                $this->render('templates/edit.html', ['error_content'=>$error]);
            }
            
            $res->free();
            
            $mysqli->close();
            
            $this->render('templates/edit.html', ['content'=>$item->item, 'pagetitle'=>'Edit Todo']);
                        
        }
        
        public function editPost($value){
            
            if(isset($_POST['content'])){
                $updatedContent = $_POST['content'];
            }
            
            $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            if ($mysqli->connect_errno){
                echo 'Database failed to connect ' . $query->connect_error;
                die();
            }
            
            $query = 'UPDATE '. LIST_TABLE . " Set list = '$updatedContent' Where id = '$value'"; 
            
            if ($res = $mysqli->query($query)) {
                $mysqli->query($query);
                
            } else{
                 "Record $value does not exist";
            }
            
            $mysqli->close();
            
            header('Location:/mvctodolist/public');
            
        }
        
        public function delete($value){
            $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            if($mysqli->connect_errno){
                echo 'Database failed to connect ' . $query->connect_error;
                die();
            }
            
            $query = 'DELETE FROM ' . LIST_TABLE . " WHERE id = '$value'";
            
            echo $query;
            
            $mysqli->query($query);
            
            $mysqli->close();
            
            header('Location:/mvctodolist/public');
        }
        
        public function error(){
        
            $this->render('templates/error.html');
        }
        
    }
?>
    