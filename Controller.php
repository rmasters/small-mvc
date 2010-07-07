<?php
namespace FW;

class Controller extends PropertyAbstract
{
	protected $layout;
	protected $request;
	protected $router;
	protected $view;
	
	public function init() {}
	public function preDispatch() {}
    public function postDispatch() {}
    
	public function dispatch() {
		$this->preDispatch();
		
		$action = $this->router->getAction() . "Action";
		$this->$action();
		
		$this->postDispatch();
		return $this->view;
	}
}