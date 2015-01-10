<?php

class Logger {

	private $addTimestamp = true;

	public function log($message, $metadata = array()) {
		$message = is_array($message) ? $message : array('message' => $message);
		$timestamp = $this->addTimestamp ? array('timestamp' => $_SERVER['REQUEST_TIME']) : null;

		$this->writeLog(array_merge($this->getUserInfo(), $timestamp, $message, $metadata));
	}

	private function getUserInfo() {
		$info = array(
			'ip'			=> $_SERVER['REMOTE_ADDR'],
			'host'			=> gethostbyaddr($_SERVER['REMOTE_ADDR'])
		);

		// add fingerprint
		if (isset($_POST['fingerprint'])) {
			$info['fingerprint'] = (int) $_POST['fingerprint'];
		}

		// add user agent
		if (isset($_POST['uagent'])) {
			$info['uagent'] = $_POST['uagent'];
		}

		return $info;
	}

	private function writeLog ($log) {
		file_put_contents('./log_'.date("j.n.Y").'.log', json_encode($log) . PHP_EOL, FILE_APPEND);
	}
}