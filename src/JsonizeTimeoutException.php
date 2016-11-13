<?php

namespace Jsonize;

class JsonizeTimeoutException extends JsonizeException {
	
	private $timeout;
	private $json;
	
	public function __construct($timeout, $json) {
		$this->timeout = $timeout;
		$this->json = $json;
        parent::__construct("Timeout" . " : " . json_encode($this->json()));
    }
    
    public function timeout() {
    	return $this->timeout;
    }
    
    public function json() {
    	return $this->json;
    }

}
