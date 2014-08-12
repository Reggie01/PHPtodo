<?php

class Todo {

    public $id = '';
    public $item = '';

    public function __construct() {
        
    }

    public function getAll($userid = '') {
        $logger = Logger::getInstance();
        $logger->debug($userid);
        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if ($mysqli->connect_errno) {
            $logger->debug('Failed to connect to database.');
            echo "Failed to connect to database " . $mysqli->connect_error;
            die();
        }
        if (empty($userid)){
            $userid = 0;
            $query = 'SELECT * FROM ' . LIST_TABLE . ' WHERE user_id = ' . $userid;
        } else {
            $query = 'SELECT * FROM ' . LIST_TABLE . ' WHERE user_id = ' . $userid;
        }
        
        $lists = [];
        if ($res = $mysqli->query($query)) {
            while ($row = $res->fetch_assoc()) {

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

    public function delete($value) {
        $logger = Logger::getInstance();
        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if ($mysqli->connect_errno) {
            $logger->debug('Database failed to connect.');
            echo 'Database failed to connect ' . $query->connect_error;
            die();
        }

        $query = 'DELETE FROM ' . LIST_TABLE . " WHERE id = '$value'";

        if ($res = $mysqli->query($query)) {
            /* need to change to prepared statement */   
        }
        
        $mysqli->close();
    }

    public function update($value, $updatedContent) {
        $logger = Logger::getInstance();
        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if ($mysqli->connect_errno) {
            $logger->debug('Database failed to connect.');
            echo 'Database failed to connect ' . $query->connect_error;
            die();
        }

        $query = 'UPDATE ' . LIST_TABLE . " Set list = '$updatedContent' Where id = '$value'";

        if ($res = $mysqli->query($query)) {
            $logger->debug('Update to todo in database complete.');
        } else {
            $logger->debug("Update to todo failed value: $value does not exist");
        }

        $mysqli->close();
        $logger->debug('Closing database...');
    }

    public function getTodoForEdit($value) {
        $logger = Logger::getInstance();

        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if ($mysqli->connect_errno) {
            $logger->debug("Databse failed to connect " . $mysqli->connect_error);
            echo "Databse failed to connect " . $mysqli->connect_error;
            die();
        }

        $query = 'SELECT * FROM ' . LIST_TABLE . ' WHERE id = ' . $value;
        if ($res = $mysqli->query($query)) {
            if ($res->num_rows > 0) {
                $row = $res->fetch_assoc();
                $item = array(
                    'item' => $row['list']
                );
                $logger->debug('Retrieved record for edit page.');
            } else {
                $error = "Record $value does not exist";
                $logger->debug($error);
                $logger->debug('Redirect to error page.');
                $mysqli->close();
                return header("Location:/mvctodolist/public/home/error");
            }
        } else {

            $error = "Record $value does not exist";
            $this->render('templates/edit.html', ['error_content' => $error]);
        }

        $res->free();

        $mysqli->close();

        return $item;
    }

    public function createTodo($todo) {
        
        $logger = Logger::getInstance();
        $user_id = 0;
        if (isset($_SESSION['user_id'])) {
            $user_id = $_SESSION['user_id'];
            $logger->debug('User: ' . $user_id . ' attempting to create log.');
        }
        
        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if ($mysqli->connect_errno) {
            $logger->debug('Failed to connect to db.');
            echo "Failed to connect to db " . $mysqli->connect_error;
            die();
        }
        
        if($user_id){
            $query = 'INSERT INTO ' . LIST_TABLE . "(list, user_id)VALUES('$todo','$user_id')";
        } else {
            $query = 'INSERT INTO ' . LIST_TABLE . "(list, user_id)VALUES('$todo','$user_id')";
        }
        
        
        if(!$mysqli->query($query)){
            $logger->debug('Query failed to run.');
            $logger->debug('Query statement was: ' . $query);
        };

        $mysqli->close();
    }

}

?>