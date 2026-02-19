<?php 
	$dbconnection = new mysqli("localhost", "ashton", "password", "phpapp");
	if($dbconnection->connect_error) die("Database connection failed: " . $dbconnection->connect_error);
	phpinfo();
?>
