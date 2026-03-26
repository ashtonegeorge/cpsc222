<?php 
	require_once('./student.php');
	require_once('./getLetterGrade.php');

	$students = array(
		new student(1001, "Ashton", "George", array("CPSC222" => 75, "BUSA322" => 100, "CPSC401" => 89)),
		new student(1002, "Kevin", "Slonka", array("CPSC222" => 98, "CPSC111" => 76, "CPSC333" => 82)),
		new student(1007, "Bojack", "Horseman", array("CPSC222" => 85, "CPSC345" => 65, "CPSC333" => 53)),
	);
?>

<!DOCTYPE html>
<html lang="en">
        <head>
                <title>CPSC222 - Ashton George</title>
                <meta charset="utf-8" />
                <meta name="viewport" content = "width=device-width" />
        </head>

        <body>
        	<h1>PHP Chapters 5 & 6, Ashton George</h1>
		<?php
			for($i=0; $i<count($students); $i++) {
				echo "<table>\n";

				echo "<tr>\n";
                                echo "<th class='highlight'>Name</th>\n";
                                echo "<td>" . $students[$i]->getLName() . ", " . $students[$i]->getFName() . "</td>\n";
				echo "</tr>\n";

                                echo "<tr>\n";
                                echo "<th class='highlight'>Student ID</th>\n";
                                echo "<td>" . $students[$i]->getId() . "</td>\n";
                                echo "</tr>\n";

                                echo "<tr>\n";
                                echo "<th class='highlight'>Grades</th>\n";
				echo "<td>\n" . "<ul>\n";
                                foreach($students[$i]->getCourses() as $code => $grade) {
					echo "<li>" . $code . " - " . $grade . " " . getLetterGrade($grade) . "</li>\n";
				}
				echo "</ul>\n" . "</td>\n";
                                echo "</tr>\n";

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
}

th {
        background-color: #DDDDDD;
}

ul {
	padding: 5px 5px 5px 20px;
	margin: 0;
}

.highlight {
	background-color: #0030DD;
	color: white;
	font-weight: bold;
}

</style>
