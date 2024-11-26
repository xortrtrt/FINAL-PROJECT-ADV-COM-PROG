<?php

class Database {
    private $host = "localhost";
    private $username = "root";
    private $password = "";
    private $dbname = "skill_development_portal";
    private $conn;

    public function __construct() {
        $this->connect();
    }

    private function connect() {
        try {
            $this->conn = new PDO("mysql:host=$this->host;dbname=$this->dbname", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Enable exception mode for errors
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    public function runQuery($query, $params = []) {
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->execute($params); 
            return $stmt;
        } catch (PDOException $e) {
            die("Query failed: " . $e->getMessage()); 
        }
    }

    public function fetchSingle($query, $params = []) {
        try {
            $stmt = $this->runQuery($query, $params);
            return $stmt->fetch(PDO::FETCH_ASSOC); 
        } catch (PDOException $e) {
            die("Fetch single row failed: " . $e->getMessage()); 
        }
    }

    public function fetchResults($query, $params = []) {
        try {
            $stmt = $this->runQuery($query, $params);
            return $stmt->fetchAll(PDO::FETCH_ASSOC); 
        } catch (PDOException $e) {
            die("Fetch multiple rows failed: " . $e->getMessage()); 
        }
    }
}

?>
