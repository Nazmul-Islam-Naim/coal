<?php
	function dateFormateForDB($date){
		$date = date('Y-m-d', strtotime($date));
		return $date;
	}

	function monthss($months){
		$months = array(1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August', 9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December');

		return $months;
	}
?>