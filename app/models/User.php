<?php

class User {

    public function __construct() {
        
    }

    public function createUser($username, $password) {
        
        $logger = Logger::getInstance();
        
        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if ($mysqli->connect_errno) {
            $logger->error('Database connection error');
            echo "Database connection error " . $mysqli->connect_error;
        }

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
        $logger->debug("Checking database if username and password correct");
        $verifcation = FALSE;
        
        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if ($mysqli->connect_errno) {
            $logger->error('Database connection error');
            echo "Database connection error " . $mysqli->connect_error;
        }
        $password = $this->make_secure($password);
        
        $query = "SELECT Username, password FROM user WHERE Username = '$username' AND password = '$password'";
        $logger->debug('Building query..');
        $logger->debug($query);
        if ($res = $mysqli->query($query)){
            
            while($row = $res->fetch_assoc()) {
                
                $logger->debug($row['Username']);
            }
            $res->free();
        } else {
            $verification = FALSE;
        }
        
        $mysqli->close();
        $logger->debug("Closing database.");
        return $verifcation;
    }    

}

?>