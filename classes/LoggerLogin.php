<?php

require_once("php-login-minimal/classes/Login.php");

class LoggerLogin extends Login {

	private $logger = null;

	function __construct($logger) {
		$this->logger = $logger;

		$loggedIn = $this->isUserLoggedIn();

		// do it
		parent::__construct();

		// check for errors and log it
		if (!empty($this->errors)) {
			foreach ($this->errors as $error) {
				$this->logger->log($error, array(
					'user'		=> $_POST['user_name'],
					'password'	=> $_POST['user_password']
				));
			}
		}

		// status changed -> log it!
		if (!$loggedIn && $this->isUserLoggedIn()) {
			$this->logger->log('successfully logged in', array(
				'user' => $_SESSION['user_name']
			));
		}
	}

	public function doLogout() {
		// cache username
		$username = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : null;

		// do logout
		parent::doLogout();

		// log it
		if ($username) {
			$this->logger->log('successfully logged out', array(
				'user' => $username
			));
		}
	}

}