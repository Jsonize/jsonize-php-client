# jsonize-php-client

This is the Jsonize Php Client.


## Getting Started


```javascript
	composer install jsonize/jsonize-php-client
```



## Basic Usage


```php

	$jsonize = new Jsonize\InstanceJsonize("jsonize");
	// $jsonize = new Jsonize\SocketJsonize("localhost", 1234);
	$result = $jsonize->invokeSync(array(
			"task" => "echo",
			"payload" => array(
					"foobar" => 1234
			)
	));
	var_dump($result[0]["result"]);
```

## Contributors

- Ziggeo
- Oliver Friedmann


## License

Apache-2.0

