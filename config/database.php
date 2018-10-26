<?php

class Database {

    private $serverName   = "localhost";
    private $userName     = "root";
    private $password     = "";
    private $databaseName = "DanceBug";
    public $conn;

    public function getConnection() {

        $this->conn = new mysqli($this->serverName, $this->userName, $this->password, $this->databaseName);

        if (mysqli_connect_errno()) {
            echo "Connect failed:".mysqli_connect_error();
            exit();
        }

        return $this->conn;
    }
}
