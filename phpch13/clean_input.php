<?php
	function clean(string $username, string $password) {
		if(!preg_match("/^[a-zA-Z0-9_]{3,20}$/", $username)) {
			return "Error: Username must match expected pattern.";
		}

		$password_pattern = '/^[a-zA-Z0-9]{8,}$/';
		if (!preg_match($password_pattern, $password)) {
			return "Error: Password must match expected pattern.";
		}

		return [$username, $password];
	}

?>
