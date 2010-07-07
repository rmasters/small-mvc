<?php
namespace FW;

class Model
{
    public function __construct(array $options = null) {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }
    
    public function __set($name, $value) {
        $name = lcfirst($name);
        $method = 'set' . ucfirst($name);
        
        if (method_exists($this, $method)) {
            $this->$method($value);
        } elseif (property_exists($this, $name)) {
            $this->$name = $value;
        } else {
            throw new \Exception("Cannot set invalid property '$name'");
        }
        
        return $this;
    }
 
    public function __get($name) {
        $name = lcfirst($name);
        $method = 'get' . ucfirst($name);
        
        if (method_exists($this, $method)) {
            return $this->$method();
        } elseif (property_exists($this, $name)) {
            return $this->$name;
        } else {
            throw new \Exception("Cannot get invalid property '$name'");
        }
    }
 
    public function setOptions(array $options) {
        foreach ($options as $key => $value) {
        	$this->__set($key, $value);
        }
    }
    
    protected function formatId($id) {
        $id = (int) $id;
        if ($id < 1) {
            throw new \Exception("ID must be numerical, and greater than 0.");
        }
        
        return $id;
    }
    
    protected function formatTimestamp($ts) {
        if (!is_int($ts)) {
            $ts = strtotime($ts);
        }
        
        return date("Y-m-d H:i:s", $ts);
    }
    
    public function toArray() {
        return get_object_vars($this);
    }
}