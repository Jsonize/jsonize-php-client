<?php

require_once(dirname(__FILE__) . "/../vendor/autoload.php");

class JsonizeServerErrorTest extends PHPUnit_Framework_TestCase {
	
	/**
	 * @expectedException Jsonize\JsonizeServerException
	 */
	public function testJsonizeServerFailure() {
		$jsonize = new Jsonize\InstanceJsonize("echo test");
		$result = $jsonize->invokeSync(array(
				"task" => "totalfail",
				"payload" => array(
				)
		));
	}
	
}

