<?php

require_once(dirname(__FILE__) . "/../vendor/autoload.php");

class JsonizeEchoFailTest extends PHPUnit_Framework_TestCase {

	/**
	 * @expectedException Jsonize\JsonizeErrorException
	 */
	public function testJsonizeEchoFail() {
		$jsonize = new Jsonize\InstanceJsonize("jsonize");
		//$jsonize = new Jsonize\SocketJsonize("localhost", 1234);
		$result = $jsonize->invokeSync(array(
				"task" => "echofail",
				"payload" => array(
						"foobar" => 1234
				)
		));
	}

}

