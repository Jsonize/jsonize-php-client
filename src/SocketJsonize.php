<?php

namespace Jsonize;

class SocketJsonize extends StreamedJsonize {

	private $socket;

	public function __construct($host, $port, $options = array()) {
		parent::__construct($options);
		$this->socket = fsockopen($host, $port);
		$this->readStream = $this->socket;
		$this->writeStream = $this->socket;
		stream_set_blocking($this->socket, false);
	}
	
	protected function destroy() {
		if (!$this->socket)
			return;
		fclose($this->socket);
		$this->socket = NULL;
	}
	
}