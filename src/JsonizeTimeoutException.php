<?php

namespace Jsonize;

class JsonizeTimeoutException extends \Exception {
	
	private $timeout;
	private $json;
	
	public function __construct($timeout, $json) {
		$this->timeout = $timeout;
		$this->json = $json;
        parent::__construct(json_encode($this->error()) . " : " . json_encode($this->json()));
    }
    
    public function timeout() {
    	return $this->timeout;
    }
    
    public function json() {
    	return $this->json;
    }

}
