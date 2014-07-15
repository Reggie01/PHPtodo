<?php

    class Todo {
        public $id = '';
        public $item = '';
        
        public function __construct(){}
        
        public function getAll() {
            $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            if ($mysqli->connect_errno){
                echo "Failed to connect to database ".$mysqli->connect_error;
                die();
            }
            
            $query = 'SELECT * FROM '.LIST_TABLE;
            $lists = [];
            if ($res = $mysqli->query($query)) {
                while($row = $res->fetch_assoc()){
                    
                    $list = array(
                        'id' => $row['id'],
                        'item' => $row['list']
                    );
                    $lists[] = $list;
                }
                $res->free();
            }
                                    
           $mysqli->close();
           
           return $lists;
        }
    
    }

?>