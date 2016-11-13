<?php

require_once(dirname(__FILE__) . "/../vendor/autoload.php");

class JsonizeTimeoutTest extends PHPUnit_Framework_TestCase {

	/**
	 * @expectedException Jsonize\JsonizeTimeoutException
	 */
	public function testJsonizeTimeout() {
		$jsonize = new Jsonize\InstanceJsonize("jsonize");
		//$jsonize = new Jsonize\SocketJsonize("localhost", 1234);
		$result = $jsonize->invokeSync(array(
				"task" => "echotimeout",
				"payload" => array(
						"delay" => 1000
				)
		), 500);
	}
	
}

