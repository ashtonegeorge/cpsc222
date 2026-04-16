<?php
	require 'clean_input.php';
	session_start();
	$error = "";
	$valid_username = "admin";
	$valid_password = "password";

        if ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_POST['logout']) && isset($_POST['username'])) {
		session_destroy();

		$ret_val = clean($_POST['username'], $_POST['password']);
		if(is_array($ret_val)) [$u, $p] = $ret_val;

		if($u === $valid_username && $p === $valid_password) {
			$_SESSION['authenticated'] = true;
			$_SESSION['username'] = $u;
		} else {
			$error = "Invalid login..."; // opt not to log why login is invalid for zero-trust
		}
        } elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['logout'])) {
		session_unset();
		session_destroy();
		header("Location: " . $_SERVER['PHP_SELF']);
	}
?>

<!DOCTYPE html>
<html lang="en">
        <head>
                <title>CPSC222 - Ashton George</title>
                <meta charset="utf-8" />
                <meta name="viewport" content = "width=device-width" />
        </head>

        <body>
                <?php
			if ($error !== "") echo "<p>" . $error . "</p>";
			if (isset($_SESSION['authenticated'])) {
				echo "<h1>Hello, " . htmlspecialchars($_SESSION['username']) . "</h1>"; 
                                echo "<form method='POST' action=''>";
				echo "<button action='logout'>Logout</button>"; // opted to use button for consistent UX, to handle session logic
				echo "</form>";
			} else {
				echo "<form method='POST' action=''>";
				echo "<div>";
                                echo "<label for='username'>Username:</label>";
                                echo "<input type='text' name='username' required class='container'>";
				echo "</div>";
                                echo "<div>";
                                echo "<label for='password'>Password:</label>";
                                echo "<input type='password' name='password' required class='container'>";
                                echo "</div>";
				echo "<button type='submit'>Login</button>";
				echo "</form>";
			}
		?>
	</body>
</html>

<style>

* {
	font-family: Arial, Helvetica, sans-serif;
}

.container {
	padding: 5px;
	margin: 2px;
}

</style>
