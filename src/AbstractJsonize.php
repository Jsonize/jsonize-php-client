<?php

namespace Jsonize;

abstract class AbstractJsonize {
	
	public abstract function destroy();
	
	private $once = FALSE;
	
	public function __construct($options = array()) {
		if (isset($options["once"]))
			$this->once = $options["once"];
	}
	
	// Reads a single JSON or returns NULL
	protected abstract function receive();
	
	// Writes a single JSON
	protected abstract function send($json);
	
	private $lastTransactionId = 0;
	private $openTransactions = array();
	
	public function invoke($json, $callbacks = array()) {
		$this->lastTransactionId++;
		$id = "id" . $this->lastTransactionId;
		$this->openTransactions[$id] = array(
			"callbacks" => $callbacks
		);
		$this->send(array(
			"type" => "invoke",
			"transaction" => $id,
			"payload" => $json
		));
		return $id;
	}
	
	public function terminate($transactionId) {
		unset($this->openTransactions[$transactionId]);
		$this->send(array(
			"type" => "terminate",
			"transaction" => $transactionId
		));
	}
	
	public function serverError($e) {
		if ($this->once)
			$this->destroy();
		foreach ($this->openTransactions as $transactionId => $transaction)
			$this->receiveError($transactionId, $transaction, $e);
	}
	
	public function receiveNext() {
		try {
			$result = $this->receive();
		} catch (JsonizeServerException $e) {
			$this->serverError($e);
			return FALSE;
		}
		if (!@$result)
			return FALSE;
		$transactionId = $result["transaction"];
		$transaction = $this->openTransactions[$transactionId];
		if (!@$transaction)
			return TRUE;
		$type = $result["type"];
		$payload = $result["payload"];
		if ($type === "event")
			$this->receiveEvent($transactionId, $transaction, $payload);
		else if ($type === "error")
			$this->receiveError($transactionId, $transaction, $payload);
		else if ($type === "success")
			$this->receiveSuccess($transactionId, $transaction, $payload);
		return TRUE;
	}
	
	private function receiveEvent($transactionId, $transaction, $payload) {
		if (@$transaction["callbacks"]["event"])
			$transaction["callbacks"]["event"]($payload);
	}
	
	private function receiveError($transactionId, $transaction, $payload) {
		if (@$transaction["callbacks"]["error"])
			$transaction["callbacks"]["error"]($payload);
		unset($this->openTransactions[$transactionId]);
		if ($this->once)
			$this->destroy();
	}
	
	private function receiveSuccess($transactionId, $transaction, $payload) {
		if (@$transaction["callbacks"]["success"])
			$transaction["callbacks"]["success"]($payload);
		unset($this->openTransactions[$transactionId]);
		if ($this->once)
			$this->destroy();
	}
	
	public function receiveAll() {
		while ($this->receiveNext())
			usleep(100);
	}
	
	public function wait($transactionId, $timeout = NULL) {
		$endtime = $timeout === NULL ? NULL : (microtime(TRUE) * 1000 + $timeout);
		while (@$this->openTransactions[$transactionId]) {
			if ($endtime !== NULL && $endtime < microtime(TRUE) * 1000)
				return FALSE;
			$this->receiveNext();
			usleep(100);
		}
		return TRUE;
	}
	
	public function invokeSync($json, $timeout = NULL, $event = NULL) {
		$success = NULL;
		$error = NULL;
		$transactionId = $this->invoke($json, array(
			"success" => function ($result) use (&$success) {
				$success = $result;
			},
			"error" => function ($result) use (&$error) {
				$error = $result;
			},
			"event" => $event
		));
		$this->wait($transactionId, $timeout);
		if (@$success)
			return $success;
		if (@$error && is_object($error) && $error instanceof JsonizeException)
			throw $error;
		if (@$error)
			throw new JsonizeErrorException($error, $json);
		$this->terminate($transactionId);
		throw new JsonizeTimeoutException($timeout, $json);
	}

}