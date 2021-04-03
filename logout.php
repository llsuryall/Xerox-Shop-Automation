<?php
	session_start();
	unset($_SESSION["userEmail"]);
	header("Location: login.php?success=logout");
?>
