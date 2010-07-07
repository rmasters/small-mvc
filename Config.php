<?php
namespace FW;

class Config
{
	protected $options = array();
	
	public function __set($name, $value) {
		$this->options[$name] = $value;
	}
	
	public function __get($name) {
		return $this->options[$name];
	}
	
	public function __isset($name) {
		return isset($this->options[$name]);
	}
	
	public function __unset($name) {
		unset($this->options[$name]);
	}
	
	public function toArray() {
		return $this->options;
	}
}