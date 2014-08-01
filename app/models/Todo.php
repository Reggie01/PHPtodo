<?php

class Todo {

    public $id = '';
    public $item = '';

    public function __construct() {
        
    }

    public function getAll() {
        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if ($mysqli->connect_errno) {
            echo "Failed to connect to database " . $mysqli->connect_error;
            die();
        }

        $query = 'SELECT * FROM ' . LIST_TABLE;
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

    public function getEditPage($value) {
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
                    'id' => $row['id'],
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

        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if ($mysqli->connect_errno) {
            echo "Failed to connect to db " . $mysqli->connect_error;
            die();
        }

        $query = 'INSERT INTO ' . LIST_TABLE . "(list)VALUES('$todo')";

        $mysqli->query($query);

        $mysqli->close();
    }

}

?>