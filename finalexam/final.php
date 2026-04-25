<?php
	session_start();
	$error = "";
	$passwd_file = "/etc/passwd";
	$group_file = "/etc/group";
	$syslog_file = "/var/log/syslog";
	$users = [];

	if (($handle = fopen('auth.db', 'r')) !== false) {
    		while (($data = fgetcsv($handle, 0, "\t")) !== false) {
        		list($username, $passwordHash) = $data;
		        $users[$username] = $passwordHash;
    		}
    		fclose($handle);
	}

        if ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_POST['logout']) && isset($_POST['username'])) {
		if($users[$_POST["username"]] === hash('sha256', $_POST["password"])) {
			$_SESSION['authenticated'] = true;
			$_SESSION['username'] = $_POST["username"];
		} else {
			$error = "Invalid login..."; // opt not to log why login is invalid for zero-trust
		}
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
		<h1>CPSC222 Final Exa<a href='?coolUser=1' class='cool-header'>m</a></h1>
                <?php
			if ($error !== "") echo "<p>" . $error . "</p>";
			if($_GET['coolUser'] == 1) {
				echo "<h2>You found the hidden page!</h2>\n";
				echo "<img src='https://scontent-xxc1-1.xx.fbcdn.net/v/t39.30808-6/672687280_1326230092902291_1112343425415429471_n.jpg?stp=cp6_dst-jpg_s590x590_tt6&_nc_cat=108&ccb=1-7&_nc_sid=13d280&_nc_ohc=ht06g13JUtwQ7kNvwGjkzPx&_nc_oc=AdobXBt_2HK09yZw0t-aU-wKxgmCLsh--_2VrJ-cf04o_QYgbM4-Vh_O52MDT3lggtk&_nc_zt=23&_nc_ht=scontent-xxc1-1.xx&_nc_gid=djeQCkEHzFNuA6nyddRRRQ&_nc_ss=7b289&oh=00_Af3u_KY6mFbbjqIq0w4uVUdjCzUMWepQprYTDbcItzS4GA&oe=69F21DAF' width=400 height=550 />\n";
				echo "<p>Its hard to believe my academic journey is about to come to a close for the first time ever. I have a lot of ambitions to actualize, the first being to get my motorcycle permit and start riding the bike I already own. I am super excited to begin my career in tech with a position on the cutting edge, AI and CRM Automation. I know regardless of who I meet or where I go, I`ll be learning and trying my best to keep up with the super smart people around me. I`ll look back on my time at Saint Francis very fondly, thank you for all of the knowledge and wisdom you share.";
			} else if (isset($_SESSION['authenticated'])) {
				echo "<div class='welcome'>\n";
                                echo "<h2>Welcome, " . htmlspecialchars($_SESSION['username']) . "!</h2>";
                                echo "<a href='final_logout.php' class='logout'>(Log out)</a>";
				echo "</div>\n";
				if($_GET["page"] != 0) echo "<a href='?page=0'>&lt; Back to Dashboard</a>\n<br/>\n";
				switch ($_GET["page"]) {
					case (0 || NULL):
						echo "<p>Dashboard:</p>\n";
						echo "<ul>\n";
						echo "<li>\n<a href='?page=1'>User list</a>\n</li>\n";
                                                echo "<li>\n<a href='?page=2'>Group list</a>\n</li>\n";
                                                echo "<li>\n<a href='?page=3'>Syslog</a>\n</li>\n";
						echo "</ul>\n";
						break;
					case 1:
						echo "<h2>User List</h2>\n";
						echo "<table>\n";
						echo "<tr>\n";
						echo "<th>Username</th>\n";
                                                echo "<th>Password</th>\n";
                                                echo "<th>UID</th>\n";
                                                echo "<th>GID</th>\n";
                                                echo "<th>Display Name</th>\n";
                                                echo "<th>Home Directory</th>\n";
                                                echo "<th>Default Shell</th>\n";
                                                echo "</tr>\n";
						if(is_readable($passwd_file)) {
							$users = file($passwd_file);
							foreach($users as $user) {
								$user_info = explode(':', $user);
								echo "<tr>\n";
								echo "<td>". htmlspecialchars($user_info[0]) . "</td>\n";
                                                                echo "<td>". htmlspecialchars($user_info[1]) . "</td>\n";
                                                                echo "<td>". htmlspecialchars($user_info[2]) . "</td>\n";
                                                                echo "<td>". htmlspecialchars($user_info[3]) . "</td>\n";
                                                                echo "<td>". htmlspecialchars($user_info[4]) . "</td>\n";
                                                                echo "<td>". htmlspecialchars($user_info[5]) . "</td>\n";
                                                                echo "<td>". htmlspecialchars($user_info[6]) . "</td>\n";
								echo "</tr>\n";
							}
						}
                                                echo "</table>\n";
						break;
					case 2:
                                        	echo "<h2>Group List</h2>\n";
                                                echo "<table>\n";
                                                echo "<tr>\n";
                                                echo "<th>Group Name</th>\n";
                                                echo "<th>Password</th>\n";
                                                echo "<th>GID</th>\n";
                                                echo "<th>Members</th>\n";
                                                echo "</tr>\n";
                                                if(is_readable($group_file)) {
                                                        $groups = file($group_file);
                                                        foreach($groups as $group) {
                                                                $group_info = explode(':', $group);
                                                                echo "<tr>\n";
                                                                echo "<td>". htmlspecialchars($group_info[0]) . "</td>\n";
                                                                echo "<td>". htmlspecialchars($group_info[1]) . "</td>\n";
                                                                echo "<td>". htmlspecialchars($group_info[2]) . "</td>\n";
                                                                echo "<td>". htmlspecialchars($group_info[3]) . "</td>\n";
                                                                echo "</tr>\n";
                                                        }
                                                }
                                                echo "</table>\n";
						break;
					case 3:
                                                echo "<h2>Syslog</h2>\n";
                                                echo "<table>\n";
                                                echo "<tr>\n";
                                                echo "<th>Date</th>\n";
                                                echo "<th>Hostname</th>\n";
                                                echo "<th>Application[PID]</th>\n";
                                                echo "<th>Message</th>\n";
                                                echo "</tr>\n";
						$logs = array_slice(file($syslog_file), -50);
						$pattern = '/^(\S+)\s+(\S+)\s+(\S+\[\d+\]):\s+(.*)$/';
						foreach($logs as $log) {
							if (preg_match($pattern, $log, $log_info)) {
								$date = new DateTime($log_info[1]);
	                                                        echo "<tr>\n";
        	                                                echo "<td>". $date->format('M d, Y H:i:s') . "</td>\n";
                	                                        echo "<td>". htmlspecialchars($log_info[2]) . "</td>\n";
                        	                                echo "<td>". htmlspecialchars($log_info[3]) . "</td>\n";
                                	                        echo "<td>". htmlspecialchars($log_info[4]) . "</td>\n";
                                        	                echo "</tr>\n";
							}
                                                }
						echo "</table>\n";
						break;
					default:
						echo "<p>Invalid page</p>\n";
						break;
				}
			} else {
				echo "<form method='POST' action=''>\n";
				echo "<div>\n";
                                echo "<label for='username'>Username:</label>\n";
                                echo "<input type='text' name='username' required class='container'>\n";
				echo "</div>\n";
                                echo "<div>\n";
                                echo "<label for='password'>Password:</label>\n";
                                echo "<input type='password' name='password' required class='container'>\n";
                                echo "</div>\n";
				echo "<button type='submit'>Login</button>\n";
				echo "</form>\n";
			}
                        echo "<div class='divider'></div>\n";
                        echo "<p>" . date("Y-m-d H:i:s"). "</p>\n";
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

.welcome {
	display: flex;
	gap: 8px;
}

.logout {
	height:50%;
	margin: auto 0;
	padding: 2;
}

.divider {
	height: 2px;
	width: 100vw;
	background-color: black;
	margin: 12px 0px;
}

table {
	border: 1px solid blue;
}

th, td {
	padding: 5px;
	border: 0.5px solid black;
}

th {
        background-color: #DDDDDD;
}

.highlight {
	background-color: #000044;
	color: white;
}

.cool-header {
	color: black;
	text-decoration: none;
}

</style>
