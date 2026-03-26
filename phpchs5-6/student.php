<?php

	class student {
		private $id=0, $fname='', $lname='', $courses=array();

		function __construct($i, $f, $l, $c) {
			$this->setId($i);
			$this->setFName($f);
			$this->setLName($l);
			$this->setCourses($c);
		}

		function setId($i) { $this->id = $i; }
		function getId() { return $this->id; }

                function setFName($f) { $this->fname = $f; }
                function getFName() { return $this->fname; }

                function setLName($l) { $this->lname = $l; }
                function getLName() { return $this->lname; }

                function setCourses($c) { $this->courses = $c; }
                function getCourses() { return $this->courses; }
	}

?>
