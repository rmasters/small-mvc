<?php
namespace FW;

class Db
{
    protected $conn;
    
    public function __construct(array $connInfo) {
        $this->connect($connInfo);
    }
    
    public function connect(array $data) {
        if (!isset($data["host"], $data["user"], $data["password"], $data["dbname"])) {
        	throw new Exception("Missing one of 'host', 'user', 'password', 'dbname'.");
        }
        
        $this->conn = new \MySQLi($data["host"], $data["user"], $data["password"], $data["dbname"]);
        if ($this->conn->connect_error) {
        	throw new \Exception("Connection error: ({$this->conn->connect_errno}) {$this->conn->connect_error}");
        }
    }
    
    public function query($sql) {
    	return $this->conn->query($sql);
    }
    
    public function escape_string($str) {
    	return $this->conn->escape_string($str);
    }
}