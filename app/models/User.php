<?php

class User {

    public function __construct() {
        
    }
    public function userExists($username) {
        $logger = Logger::getInstance();
        $user_exist = False;
        $mysqli = new mysqli(DB_HOST, DB_USER, DB_NAME, DB_PASS);
        if($mysqli->connect_errno) {
            $logger->debug("Could not connect to database.");
            echo 'Could not connect to database';
            die();
        }
        
        $query = 'SELECT * FROM ' . USER_TABLE . 'WHERE username = ' . $username;
        
        if ($res = $mysqli->query($query)) {
            
            if($res->num_rows > 0){
                $user_exist = True;
                $logger->debug("User already exists.");
            }
            $res->free();
        } 
        
        $mysqli->close();
        return $user_exist;
        
    }
    
    public function createUser($username, $password) {
        
        $logger = Logger::getInstance();
        
        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if ($mysqli->connect_errno) {
            $logger->error('Database connection error');
            echo "Database connection error " . $mysqli->connect_error;
            die();
        }
        
        /*
         * add check to see if user name exists
         */
        $this->userExists($username);
        
        $query = 'INSERT INTO ' . USER_TABLE . " (username, password)VALUES('$username', '$password')";
        //echo $query;
        if ($res = $mysqli->query($query)) {
            if($res) {
                $logger->info("Registered user $username");
            }
        }

        $mysqli->close();
        $logger->info("Closing db.");
    }
    
    public function make_secure($password) {
        /** salt should be kept in a separate file * */
        $salt = 'jenkins';
        $securepass = hash_hmac('sha256', $password, $salt);
        return $securepass;
    }
    
    public function verifyUser($username, $password){
        $logger = Logger::getInstance();
        $logger->debug("Connecting to database.");
        $verification = False;
        
        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if ($mysqli->connect_errno) {
            $logger->error('Database connection error');
            echo "Database connection error " . $mysqli->connect_error;
            die();
        }
        $password = $this->make_secure($password);
        
        $query = "SELECT Username, password FROM user WHERE Username = '$username' AND password = '$password'";
        $logger->debug('Building query..');
        $logger->debug($query);
        if ($res = $mysqli->query($query)){
            
            if ($res->num_rows > 0) {
                $logger->debug("A match was found.");
                $verification = True;
            }
            $res->free();
        } 
        
        $mysqli->close();
        $logger->debug("Closing database."); 
        return $verification;
    }    

}

?>