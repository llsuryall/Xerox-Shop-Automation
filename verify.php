<?php
	include_once "PHP_Include_Scripts/functions.php";
	$myfile = fopen("ver_codes/".$_POST["email"], "r");
	$som=fgets($myfile);
	fclose($myfile);
	if($_POST["code"]==$som){
		echo "true";
	}else{
		echo "false";
	}
?>
