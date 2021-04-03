<?php
	include_once 'PHP_Include_Scripts/connect.php';
	include_once 'PHP_Include_Scripts/functions.php';
	if(isset($_POST["submit"])){
		$email_id=$_POST["email_id"];
		$username=$_POST["username"];
		$passwordhash=$_POST["passwordhash"];
	}
	if($res=validate($conn,$username,$email_id,$passwordhash)){
		$success=createUser($conn,$username,$email_id,$passwordhash);
		if($success){
			echo "<h2> User creation successful. Go to login page -> <a href=\"index.html\">Login</a></h1><br/>";
		}else{
			echo "<h2> User creation failed. Go back to signup page -> <a href=\"signup.html\">Signup</a></h1><br/>";
		}
	}else{
		echo "<h2> Username/Email Id already exists. Go back to signup page -> <a href=\"signup.html\">Signup</a> </h2> <br/>";
	}
?>
