<?php

    require_once(dirname(__FILE__) . "/../src/JsonizeException.php");
    require_once(dirname(__FILE__) . "/../src/JsonizeErrorException.php");
    require_once(dirname(__FILE__) . "/../src/AbstractJsonize.php");
    require_once(dirname(__FILE__) . "/../src/StreamedJsonize.php");
    require_once(dirname(__FILE__) . "/../src/SocketJsonize.php");

	$jsonize = new Jsonize\SocketJsonize("localhost", 1234);
	$result = $jsonize->invokeSync(array(
			"task" => $argv[1],
			"payload" => array(
			    "foobar" => 1234
			)
	));
	var_dump($result[0]["result"]);
