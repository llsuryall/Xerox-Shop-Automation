<?php session_start();?>
<!DOCTYPE html>
<html>
<head>
	<title>Login or Signup</title>
</head>
<body>
	<?php
		$not_loggedin=<<<NOT_LOGGEDIN
			Not logged in.
			<h1 align="center">
				<a href="index.html">Login</a>
				<br/>
				or
				<br/>
				<a href="signup.html">Signup</a>
			</h1>
		NOT_LOGGEDIN;
		if(!isset($_SESSION["userEmail"])){
			echo $not_loggedin;
		}else{
			echo $_SESSION["userEmail"]." <a href=\"logout.php\">Logout</a>";
		}
	?>
</body>
</html>
