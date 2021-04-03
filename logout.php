<?php
	session_start();
	unset($_SESSION["userEmail"]);
	echo "Logged out successfully!";
?>
