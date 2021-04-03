<?php
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\Exception;
	require 'PHPMailer/src/Exception.php';
	require 'PHPMailer/src/PHPMailer.php';
	require 'PHPMailer/src/SMTP.php';
	$code="";
	function email_id_exists($conn,$email_id){
		$query="SELECT userEmail FROM xerox_shop WHERE userEmail = ?;";
		$stmt=mysqli_stmt_init($conn);
		if(!mysqli_stmt_prepare($stmt,$query)){
			echo mysqli_stmt_error($stmt);
			return true;
		}else{
			mysqli_stmt_bind_param($stmt,"s",$email_id);
			mysqli_stmt_execute($stmt);
			$res=mysqli_stmt_get_result($stmt);
			if(mysqli_num_rows($res)==0){
				return false;
			}else{
				return true;
			}
		}
	}
	function login($conn,$email_id,$passwordhash){
		$query="SELECT userEmail,userPwd FROM xerox_shop WHERE userEmail = ?;";
		$stmt=mysqli_stmt_init($conn);
		if(!mysqli_stmt_prepare($stmt,$query)){
			echo mysqli_stmt_error($stmt);
			return false;
		}else{
			mysqli_stmt_bind_param($stmt,"s",$email_id);
			mysqli_stmt_execute($stmt);
			$res=mysqli_stmt_get_result($stmt);
			$row = $res->fetch_assoc();
			if($row){
				if($row["userPwd"]==$passwordhash){
					session_start();
					$_SESSION["userEmail"]=$row["userEmail"];
					return true;
				}else{
					return false;
				}
			}else{
				return false;
			}
		}
	}
/*	function phone_no_exists($conn,$phone_no){
		$query="SELECT userPhoneNo FROM xerox_shop WHERE userPhoneNo = ?;";
		$stmt=mysqli_stmt_init($conn);
		if(!mysqli_stmt_prepare($stmt,$query)){	
			return true;
		}else{
			mysqli_stmt_bind_param($stmt,"s",$phone_no);
			mysqli_stmt_execute($stmt);
			$res=mysqli_stmt_get_result($stmt);
			$row=mysqli_fetch_assoc($resultData);
			mysqli_stmt_close($stmt);
			if(mysqli_num_rows($res)==0){
				return false;
			}else{
				return true;
			}
		}
	}
*/
	function username_exists($conn,$username){
		$query="SELECT userName FROM xerox_shop WHERE userName = ?;";
		$stmt=mysqli_stmt_init($conn);
		if(!mysqli_stmt_prepare($stmt,$query)){	
			return true;
		}else{
			mysqli_stmt_bind_param($stmt,"s",$username);
			mysqli_stmt_execute($stmt);
			$res=mysqli_stmt_get_result($stmt);
			mysqli_stmt_close($stmt);
			if(mysqli_num_rows($res)==0){
				return false;
			}else{
				return true;
			}
		}
	}
	function createUser($conn,$username,$email_id,$passwordhash){
		$query="INSERT INTO xerox_shop VALUES (NULL,?,?,?);";
		$stmt=mysqli_stmt_init($conn);
		if(!mysqli_stmt_prepare($stmt,$query)){	
			return false;
		}else{
			mysqli_stmt_bind_param($stmt,"sss",$username,$email_id,$passwordhash);
			mysqli_stmt_execute($stmt);
			$res=mysqli_stmt_get_result($stmt);
			mysqli_stmt_close($stmt);
			mkdir("Files/".$email_id);
			return true;
		}
	}
	function validate($conn,$username,$email_id,$passwordhash){
		if(email_id_exists($conn,$email_id) || username_exists($conn,$username)){
			return false;
		}else{
			return true;
		}
	}
	function sendmail($recipient,$name){
		global $code;
		$mail = new PHPMailer();
		$mail->isSMTP();
		$mail->Host = 'smtp.gmail.com';
		$mail->Port = 587;
		$mail->SMTPAuth = true;
		$mail->Username = '00xeroxshop00@gmail.com';
		$mail->Password = '5ury@5xer0xp@55w0rd';
		$mail->setFrom('00xerox_shop00@gmail.com', 'Xerox Shop');
		$mail->addAddress($recipient, $name);
		$mail->Subject = 'Xerox Shop Verification Code';
		$mail->Body = getHTMLMessage();
		$mail->IsHTML(true);
		$myfile = fopen("ver_codes/".$_POST["email"], "w");
		fwrite($myfile, strval($code));
		fclose($myfile);
		if (!$mail->send()) {
		    echo 'Mailer Error: ' . $mail->ErrorInfo;
		} else {
		    echo 'Mail sent!';
		}
	}
	function getVerificationCode(){
		return (int) substr(number_format(time() * rand(), 0, '', ''), 0, 6);
	}
	function getHTMLMessage(){
		global $code;
		$code=getVerificationCode(); 
		$htmlMessage=<<<MSG
			<!DOCTYPE html>
			<html>
				<body>
					<h1>Your verification code is $code</h1>
					<p>Use this code to verify your account.</p>
				</body>
			</html>
		MSG;
		return $htmlMessage;
	}
?>
