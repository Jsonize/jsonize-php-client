<?php

namespace Jsonize;

class SocketJsonize extends StreamedJsonize {

	private $socket;

	public function __construct($host, $port) {
		$this->socket = fsockopen($host, $port);
		$this->readStream = $this->socket;
		$this->writeStream = $this->socket;
		stream_set_blocking($this->socket, false);
	}
	
	public function __destruct() {
		fclose($this->socket);
	}

}