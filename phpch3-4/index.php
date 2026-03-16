<?php 
	$employees = array(
		array(
			"Employee Name" => "Kevin Slonka",
			"Hours Worked" => 40.0,
			"Pay Rate" => 54.5,
		),
                array(
                        "Employee Name" => "Ashton George",
                        "Hours Worked" => 40.0,
                        "Pay Rate" => 28.5,
                ),
                array(
                        "Employee Name" => "Sydney Ferguson",
                        "Hours Worked" => 32.0,
                        "Pay Rate" => 15.25,
                ),
                array(
                        "Employee Name" => "Cameron Calhoun",
                        "Hours Worked" => 40.0,
                        "Pay Rate" => 30.0,
                ),
	);

        $stateRate = 0.055; // flat rate

        /* function getFedTaxRate
        * weeklyPay: weekly gross pay (hours worked * pay rate)
        */
        function getFedTaxRate($weeklyPay) 
        {
                $annualPay = $weeklyPay * 52;
                return match (true) { // use match instead of switch for readability
                        $annualPay >= 626351 => 0.37,
                        $annualPay >= 250526 => 0.35,
                        $annualPay >= 197301 => 0.32,
                        $annualPay >= 103351 => 0.24,
                        $annualPay >= 48476  => 0.22,
                        $annualPay >= 11926  => 0.12,
                        default => 0.10,
                };
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
        	<h1>PHP Chs 3-4, Ashton George</h1>
		<table>
			<tr>
				<th>Employee Name</th>
				<th>Hours Worked</th>
                                <th>Pay Rate</th>
                                <th>Gross Pay</th>
                                <th>Federal Withholding</th>
                                <th>State Witholding</th>
                                <th>Total Deduction</th>
                                <th class='highlight'>Tax Bracket</th>
                                <th class='highlight'>Net Pay</th>
			</tr>
			<?php
				foreach($employees as $employee)
				{
					$grossPay = $employee["Hours Worked"] * $employee["Pay Rate"];
					$fedRate = getFedTaxRate($grossPay);
                                        $fedWitholding = $grossPay * $fedRate;
					$stateWitholding = $grossPay * $stateRate;
					$totalDeduction = $fedWitholding + $stateWitholding;
					$netPay = $grossPay - $totalDeduction;

					echo "<tr>";
					echo "<td>" . $employee["Employee Name"] . "</td>";
                                        echo "<td>" . $employee["Hours Worked"] . "</td>";
                                        echo "<td>$" . number_format($employee["Pay Rate"], 2, '.', ',')  . "</td>";
                                        echo "<td>$" . number_format($grossPay, 2, '.', ',') . "</td>";
                                        echo "<td>$" . number_format($fedWitholding, 2, '.', ',') . "</td>";
                                        echo "<td>$" . number_format($stateWitholding, 2, '.', ',') . "</td>";
                                        echo "<td>$" . number_format($totalDeduction, 2, '.', ',') . "</td>";
                                        echo "<td class='highlight'>" . number_format($fedRate*100, 0) . "%</td>";
                                        echo "<td class='highlight'>$" . number_format($netPay, 2, '.', ',') . "</td>";
					echo "</tr>";
				}
			?>
		</table>
	</body>
</html>

<style>

* {
	font-family: Arial, Helvetica, sans-serif;
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

</style>
