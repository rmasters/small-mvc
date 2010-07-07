<?php
namespace FW;

class Response
{	
	public $code;
	
	public function getReason() {
		$messages = array(
		    100 => "Continue",
		    200 => "OK",
		    201 => "Created",
		    202 => "Accepted",
		    301 => "Moved permanently",
		    302 => "Found",
		    304 => "Not modified",
		    307 => "Temporary redirect",
		    401 => "Unauthorised",
		    403 => "Forbidden",
		    404 => "Not found",
		    500 => "Internal server error",
		    503 => "Service unavailable"
		);
		
		return $messages[$this->code];
	}
	
	
}