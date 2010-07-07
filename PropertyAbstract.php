<?php
namespace FW;

class PropertyAbstract {
    public function __set($name, $value) {
        $name = lcfirst($name);
        $method = "set" . $name;
        
        if (method_exists($this, $method)) {
            $this->$method($value);
        } elseif (property_exists($this, $name)) {
            $this->$name = $value;
        } else {
            throw new \Exception("Invalid property '$name'.");
        }
    }
    
    public function __get($name) {
        $name = lcfirst($name);
        $method = "get" . $name;
        
        if (method_exists($this, $method)) {
            return $this->$method();
        } elseif (property_exists($this, $name)) {
            return $this->$name;
        } else {
            throw new \Exception("Invalid property '$name'.");
        }
    }
    
    public function __call($method, $arguments) {
    	$prefix = substr($method, 0, 3);
    	if ($prefix == "get" || $prefix == "set") {
    		$property = lcfirst(substr($method, 3));
    		if ($prefix == "get") {
    			return $this->$property;
    		}
    		
    		if ($prefix == "set") {
    			$this->$property = $arguments[0];
    		}
    	} else {
    		parent::__call($method, $arguments);
    	}
    }
    
    public function __isset($name) {
        $name = lcfirst($name);
        return isset($this->$name);
    }
    
    public function __unset($name) {
        $name = lcfirst($name);
        unset($this->$name);
    }
}