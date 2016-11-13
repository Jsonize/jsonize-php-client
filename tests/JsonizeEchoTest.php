<?php

require_once(dirname(__FILE__) . "/../vendor/autoload.php");

class JsonizeEchoTest extends PHPUnit_Framework_TestCase {

	public function testJsonizeEcho() {
		$jsonize = new Jsonize\InstanceJsonize("jsonize", "", array("once" => TRUE));
		//$jsonize = new Jsonize\SocketJsonize("localhost", 1234);
		$result = $jsonize->invokeSync(array(
				"task" => "echo",
				"payload" => array(
						"foobar" => 1234
				)
		));
		$this->assertEquals($result[0]["result"]["foobar"], 1234);
	}
	
}

