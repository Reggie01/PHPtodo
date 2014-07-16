<?php

class User {

    public function __construct(){}
    
    public function createUser($username, $password) {
        
        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if($mysqli->connect_errno) {
            echo "Database connection error " . $mysqli->connect_error;
        }
        
        $query = 'INSERT INTO ' . U_TABLE . " (id, list)VALUES('$username', 'password')";
        
        if($res = $mysqli->query($query)){
            print_r($res);
        }
        
        $res->free();
        
        $mysqli->close();
    }
    
    

}

?>