<?php

namespace Jsonize;

class JsonizeErrorException extends JsonizeException {
	
	private $error;
	private $json;
	
	public function __construct($error, $json) {
		$this->error = $error;
		$this->json = $json;
        parent::__construct(json_encode($this->error()) . " : " . json_encode($this->json()));
    }
    
    public function error() {
    	return $this->error;
    }
    
    public function json() {
    	return $this->json;
    }

}
