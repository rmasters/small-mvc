<?php
namespace FW;

class Router
{
	protected static $instance;
	
	protected $controller = "index";
	protected $action = "index";
	protected $params = array();
	
	public static function getInstance() {
		if (self::$instance == null) {
			self::$instance = new self;
		}
		return self::$instance;
	}
	
	public function setController($controller) {
		$this->controller = $controller;
	}
	
	public function getController() {
		return $this->controller;
	}
	
	public function setAction($action) {
		$this->action = $action;
	}
	
	public function getAction() {
		return $this->action;
	}
	
	public function __get($paramName) {
		return $this->params[$paramName];
	}
	
	public function __isset($paramName) {
		return isset($this->params[$paramName]);
	}
	
	public function fromUri($uri) {
		// Explode the array into parts and clean it
		$uri = ltrim($uri, "/");
		$uri = rtrim($uri, "/");
		$parts = explode("/", $uri);
		foreach ($parts as $key => $value) {
			if (empty($value)) {
				unset($parts[$key]);
			}
		}
		
		switch (count($parts)) {
			case 0:
				$this->controller = "index";
				$this->action = "index";
				break;
			case 1:
				$this->controller = $parts[0];
				break;
			case 2:
				$this->controller = $parts[0];
				$this->action = $parts[1];
                break;
			default:				
				if (count($parts) % 2 == 0) {
					$this->controller = array_shift($parts);
                    $this->action = array_shift($parts);
				} else {
					$this->controller = array_shift($parts);
				}
				
				for ($i = 0; $i < count($parts); $i += 2) {
					$this->params[$parts[$i]] = $parts[$i+1]; 
				}
				break;
		}
		
		$this->controller = ucfirst($this->controller);
		$this->action = strtolower($this->action);
	}
}