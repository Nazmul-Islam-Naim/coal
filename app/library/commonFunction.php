<?php
	function dateFormateForDB($date){
		$date = date('Y-m-d', strtotime($date));
		return $date;
	}

	function dateTimeFormateForDB($date){
		$date = date('Y-m-d H:i:s', strtotime($date));
		return $date;
	}
?>