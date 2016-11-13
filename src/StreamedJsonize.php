<?php

namespace Jsonize;

abstract class StreamedJsonize extends AbstractJsonize {

	private $cache = "";
	protected $readStream = NULL;
	protected $writeStream = NULL;
	
	protected function receive() {
		$this->cache .= stream_get_contents($this->readStream);
		$i = strpos($this->cache, "\n");
		if ($i === FALSE)
			return NULL;
		$head = substr($this->cache, 0, $i);
		$this->cache = substr($this->cache, $i + 1);
		$result = json_decode($head, TRUE);
		if (!@$result)
			throw new JsonizeServerException();
		return $result;
	}
	
	protected function send($json) {
		fwrite($this->writeStream, json_encode($json) . "\n");
	}

}