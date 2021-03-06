<?php

namespace Jsonize;

class InstanceJsonize extends StreamedJsonize {

	private $process;
	private $errorStream;

	public function __construct($path, $params = "") {
		$this->process = proc_open(
			$path . " --instance " . $params,
			array(
				 0 => array("pipe", "r"),
   				 1 => array("pipe", "w"),
   				 2 => array("pipe", "w") 
			),
			$pipes
		);
		if (!is_resource($this->process))
			throw new JsonizeErrorException($path . " --instance " . $params, 1);
		stream_set_blocking($pipes[0], false);
		stream_set_blocking($pipes[1], false);
		stream_set_blocking($pipes[2], false);
		$this->writeStream = $pipes[0];
		$this->readStream = $pipes[1];
		$this->errorStream = $pipes[2];
	}
	
	public function destroy() {
		if (!$this->process)
			return;
		fclose($this->readStream);
		fclose($this->writeStream);
		fclose($this->errorStream);
		proc_close($this->process);
		$this->process = NULL;
	}

}