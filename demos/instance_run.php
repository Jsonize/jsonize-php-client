<?php

    require_once(dirname(__FILE__) . "/../src/AbstractJsonize.php");
    require_once(dirname(__FILE__) . "/../src/StreamedJsonize.php");
    require_once(dirname(__FILE__) . "/../src/InstanceJsonize.php");

	$jsonize = new Jsonize\InstanceJsonize(dirname(__FILE__) . "/../../JsonizeServer/bin/jsonize");
	// $jsonize = new Jsonize\SocketJsonize("localhost", 1234);
	$result = $jsonize->invokeSync(array(
			"task" => $argv[1],
			"payload" => array(
			    "foobar" => 1234
			)
	));
	var_dump($result[0]["result"]);
