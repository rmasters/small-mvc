<?php
namespace FW\Db;

class Table
{
    protected static $db;
    protected $tableName;
    
    public static function setDbAdapter(\FW\Db $conn) {
    	self::$db = $conn;
    }
    
    public function insert(array $data) {
        if ($this->tableName == null) {
            throw new \Exception("Table name must be declared.");
        }
        
        foreach ($data as $key => $value) {
            $data[$key] = $this->db->escape_string($value);
        }
        
        $columns = implode(", ", array_keys($data));
        $values = implode(", ", array_values($data));
        $query = "INSERT INTO {$this->tableName} ($columns) VALUES ($values)";
        
        $result = $this->db->query($query);
        
        if (!$result) {
            throw new \Exception("Insert failed.");
        }
    }
    
    public function update(array $data) {
        if ($this->tableName == null) {
            throw new \Exception("Table name must be declared.");
        }
        
        foreach ($data as $key => $value) {
            $data[$key] = self::$db->escape_string($value);
        }
        
        $sets = "";
        foreach ($data as $col => $value) {
            $sets .= "$col = $value, ";
        }
        $sets = rtrim(", ", $sets);
        
        $query = "UPDATE {$this->tableName} SET $sets WHERE id = {$data["id"]}";
        
        $result = self::$db->query($query);
        
        if (!$result) {
            throw new \Exception("Update failed.");
        }
    }
    
    public function delete($id) {
        if ($this->tableName == null) {
            throw new \Exception("Table name must be declared.");
        }
        
        $query = "DELETE FROM {$this->tableName} WHERE id = " . self::$db->escape_string($id) . " LIMIT 1";
        
        $result = self::$db->query($query);
        
        if (!$result) {
            throw new \Exception("Delete failed.");
        }
    }
    
    public function find($id) {
        if ($this->tableName == null) {
            throw new \Exception("Table name must be declared.");
        }
        
        $query = "SELECT * FROM {$this->tableName} WHERE id = " . self::$db->escape_string($id) . " LIMIT 1";
        $result = self::$db->query($query);
        
        if (!$result) {
            throw new \Exception("Find failed.");
        }
        
        if ($result->num_rows == 0) {
        	return false;
        }
        
        return $result->fetch_assoc();
    }
    
    public function fetchAll() {
        if ($this->tableName == null) {
            throw new \Exception("Table name must be declared.");
        }
        
        $query = "SELECT * FROM {$this->tableName}";
        $result = self::$db->query($query);
        
        $results = array();
        
        for ($i = 0; $i < $result->num_rows; $i++) {
        	$results[] = $result->fetch_assoc();
        }
        
        if (!$result) {
            throw new \Exception("Fetch all failed.");
        }
        
        return $results;
    }
}