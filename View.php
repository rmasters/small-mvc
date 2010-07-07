<?php
namespace FW;

class View
{
    protected $path;
	protected $properties;
	
	public function __construct($path) {
		$this->path = $path;
	}
	
	public function __set($name, $value) {
		$this->properties[$name] = $value;
	}
	
	public function __get($name) {
		return $this->properties[$name];
	}
	
	public function __isset($name) {
		return isset($this->properties[$name]);
	}
	
	public function __unset($name) {
		unset($this->properties[$name]);
	}
	
	public function build() {
		require $this->path;
	}
	
	public function __toString() {
		ob_flush();
		
		$this->build();
		$viewContents = ob_get_contents();
		ob_clean();
		return $viewContents;
	}
}