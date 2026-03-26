<?php
	function getLetterGrade($p) {
		if($p >= 90) return 'A';
		elseif($p >= 80) return 'B';
                elseif($p >= 70) return 'C';
                elseif($p >= 60) return 'D';
                return 'F';
	}
?>
