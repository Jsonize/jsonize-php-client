<?php

namespace Jsonize;

class JsonizeErrorException extends Exception {
	
	private $error;
	private $json;
	
	public function __construct($error, $json) {
		$this->error = $error;
		$this->json = $json;
        parent::__construct();
    }
    
    public function error() {
    	return $this->error;
    }
    
    public function json() {
    	return $this->json;
    }

}
