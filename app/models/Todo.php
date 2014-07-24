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
        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if ($mysqli->connect_errno) {
            echo 'Database failed to connect ' . $query->connect_error;
            die();
        }

        $query = 'DELETE FROM ' . LIST_TABLE . " WHERE id = '$value'";

        $mysqli->query($query);

        $mysqli->close();
    }

    public function update($value, $updatedContent) {

        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if ($mysqli->connect_errno) {
            echo 'Database failed to connect ' . $query->connect_error;
            die();
        }

        $query = 'UPDATE ' . LIST_TABLE . " Set list = '$updatedContent' Where id = '$value'";

        if ($res = $mysqli->query($query)) {
            $mysqli->query($query);
        } else {
            "Record $value does not exist";
        }

        $mysqli->close();
    }

    public function getEditPage($value) {
        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if ($mysqli->connect_errno) {
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
            } else {
                $error = "Record $value does not exist";
                header("Location:/mvctodolist/public/home/error");
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