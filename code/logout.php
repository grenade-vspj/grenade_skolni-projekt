<?php
	// session_destroy();
	$requiredSessionVar = array('vstup','expire');
	foreach($_SESSION as $key => $value) {
		if(!in_array($key, $requiredSessionVar)) {
			unset($_SESSION[$key]);
		}
	}
	header("Location: prihlas.php");
?>
