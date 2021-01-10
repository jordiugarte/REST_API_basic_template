<?php

class connection {

    private $server;
    private $user;
    private $password;
    private $database;
    private $port;
    private $connection;

    function __construct() {
        $data = $this->getDataConfig();
        foreach ($data as $key => $value) {
            $this->server = $value["server"];
            $this->user = $value["user"];
            $this->password = $value["password"];
            $this->database = $value["database"];
            $this->port = $value["port"];
        }

        $this->connection = new mysqli($this->server, $this->user, $this->password, $this->database, $this->port);

        if ($this->connection->connect_errno) {
            echo "Connection fail";
            die();
        }
    }

    private function getDataConfig() {
        $dir = dirname(__FILE__);
        $jsonData = file_get_contents($dir . "/config");
        return json_decode($jsonData, true);
    }

    public function getData($query) {
        $results = $this->connection->query($query);
        $resultArray = array();
        foreach ($results as $key) {
            $resultArray[] = $key;
        }
        return $resultArray;
    }

    public function nonQuery($query) {
        $results = $this->connection->query($query);
        return $this->connection->affected_rows;
    }

    public function nonQueryId($query) {
        $results = $this->connection->query($query);
        $rows = $this->connection->affected_rows;

        if ($rows >= 1) {
            return $this->connection->insert_id;
        } else {
            return 0;
        }
    }
}

?>