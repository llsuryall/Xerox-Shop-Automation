<?php
	include_once 'PHP_Include_Scripts/connect.php';
	include_once 'PHP_Include_Scripts/functions.php';
	if(isset($_POST["submit"])){
		$email_id=$_POST["email_id"];
		$passwordhash=$_POST["passwordhash"];
		if(login($conn,$email_id,$passwordhash)){
			echo "<h2> User Logged in successfully! Go back to index page -> <a href=\"index.php\">Home</a></h1><br/></h2>";
		}else{
			echo "<h2> Invalid username or password. Go back to login page -> <a href=\"index.html\">Login</a></h1><br/>";		
		}
	}else{
		echo "Unknown Error!";
	}
?>
