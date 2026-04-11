<?php 
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $m =  $_POST['month'];
                $d =  $_POST['day'];
                $y =  $_POST['year'];
                $hr =  $_POST['hour'];
                $min = $_POST['min'];
                $mer =  $_POST['meridiem'];

		$fullHour = $hr;
                if ($mer === 'pm' && $fullHour != 12) {
                        $fullHour += 12;
                } elseif ($mer === 'am' && $fullHour == 12) {
                        $fullHour = 0;
                }

                $birthday = new DateTime();
                $birthday->setDate($y, $m, $d);
                $birthday->setTime($fullHour, $min, 0);
        }


	if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET['year'])) {
    		$m = filter_input(INPUT_GET, 'month', FILTER_VALIDATE_INT, ["options" => ["min_range" => 1, "max_range" => 12]]);
    		$d = filter_input(INPUT_GET, 'day', FILTER_VALIDATE_INT, ["options" => ["min_range" => 1, "max_range" => 31]]);
    		$yr = filter_input(INPUT_GET, 'year', FILTER_VALIDATE_INT, ["options" => ["min_range" => 1900, "max_range" => 2100]]);
    		$hr = filter_input(INPUT_GET, 'hour', FILTER_VALIDATE_INT, ["options" => ["min_range" => 1, "max_range" => 12]]);
    		$min = filter_input(INPUT_GET, 'min', FILTER_VALIDATE_INT, ["options" => ["min_range" => 1, "max_range" => 60]]);
    		$meridiem = strtolower(filter_input(INPUT_GET, 'meridiem', FILTER_SANITIZE_STRING));

		if (!$m || !$d || !$yr || !$hr || !$min || !in_array($meridiem, ['am', 'pm'])) {
		        die("Invalid input.");
    		}

	    	$fullHour = $hr;
    		if ($meridiem === 'pm' && $fullHour != 12) {
        		$fullHour += 12;
    		} elseif ($meridiem === 'am' && $fullHour == 12) {
        		$fullHour = 0;
    		}

    		$dateString = sprintf('%04d-%02d-%02d %02d:%02d:00', $yr, $m, $d, $fullHour, $min);
    		$birthday = DateTime::createFromFormat('Y-m-d H:i:s', $dateString);

	    	if (!$birthday) {
        		die("Invalid date.");
	    	}

                $birthday = new DateTime();
		$birthday->setDate($yr, $m, $d);
		$birthday->setTime($fullHour, $min, 0);
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
        	<h1>Birthday Formatter</h1>
                <?php
		        if(isset($m) && $_SERVER["REQUEST_METHOD"] == "GET") {
                                echo "<p>" . $birthday->format('Y-m-d H:i:s') . "</p>\n";
                        } elseif(isset($m)) { 
				echo "<p>" . $birthday->format('l F jS, Y - g:ia'), "</p>\n";
                                echo "<a href='?year=$y&month=$m&day=$d&hour=$hr&min=$min&meridiem=$mer'>";
                                echo "Show date in ISO format";
                                echo "</a>";
                        } else {
        			echo "<table>\n";
                                echo "<tr>\n";
                                echo "<th>Month</th>\n";
                                echo "<th>Day</th>\n";
                                echo "<th>Year</th>\n";
                                echo "<th>Hour</th>\n";
                                echo "<th>Minute</th>\n";
                                echo "<th>AM/PM</th>\n";
                                echo "</tr>\n";

                                echo "<form method='POST' action='" . htmlspecialchars($_SERVER['PHP_SELF']) . "'>";
                                echo "<tr>\n";

                                echo "<td>\n";
        			echo "<select name='month'>\n";
                                echo "<option value=1>January</option>\n";
                                echo "<option value=2>February</option>\n";
                                echo "<option value=3>March</option>\n";
                                echo "<option value=4>April</option>\n";
                                echo "<option value=5>May</option>\n";
                                echo "<option value=6>June</option>\n";
                                echo "<option value=7>July</option>\n";
                                echo "<option value=8>August</option>\n";
                                echo "<option value=9>September</option>\n";
                                echo "<option value=10>October</option>\n";
                                echo "<option value=11>November</option>\n";
                                echo "<option value=12>December</option>\n";
	        		echo "</select>\n";
                                echo "</td>\n";

                                echo "<td>\n";
                                echo "<select name='day'>\n";
	        		for($i = 1; $i<=31; $i++) {
		        		echo "<option value=$i>$i</option>\n";
			        }
        			echo "</select>\n";
                                echo "</td>\n";

	        		echo "<td>\n";
        			echo "<select name='year'>\n";

	        		$currentYear = date("Y");

		        	for ($year = $currentYear; $year >= 1970; $year--) {
    			        	echo "<option value=$year>$year</option>\n";
			        }

			        echo "</select>\n";
			        echo "</td>\n";

                                echo "<td>\n";
                                echo "<select name='hour'>\n";
                                for($i = 1; $i<=12; $i++) {
                                        echo "<option value=$i>$i</option>\n";
                                }
                                echo "</select>\n";
                                echo "</td>\n";

                                echo "<td>\n";
                                echo "<select name='min'>\n";
                                for($i = 1; $i<=60; $i++) {
                                        echo "<option value='$i'>$i</option>\n";
                                }
                                echo "</select>\n";
                                echo "</td>\n";

                                echo "<td>\n";
                                echo "<select name='meridiem'>\n";
                                echo "<option value='am'>AM</option>\n";
                                echo "<option value='pm'>PM</option>\n";
                                echo "</td>\n";

                                echo "</tr>\n";

                                echo "<tr>\n";
                                echo "<td colspan='6'>\n";
                                echo "<input type='submit' value='Format Date'>";
                                echo "</td>\n";
                                echo "</tr>\n";

                                echo "</form>";
                                echo "</table>\n";
                        }
		?>
	</body>
</html>

<style>

* {
	font-family: Arial, Helvetica, sans-serif;
}

table {
	border: 1px solid blue;
	margin: 10px;
}

th, td {
	padding: 5px;
	border: 0.5px solid black;
        text-align: center;
}

th {
        background-color: #DDDDDD;
}

ul {
	padding: 5px 5px 5px 20px;
	margin: 0;
}

</style>
