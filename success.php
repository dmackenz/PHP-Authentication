<?php
	// start session
	if (session_status() == PHP_SESSION_NONE) {
		session_start();
	}

	// check if logged in
	if (isset($_SESSION['login'])) {
		echo "successfully logged in.";
	}

	// else redirect
?>