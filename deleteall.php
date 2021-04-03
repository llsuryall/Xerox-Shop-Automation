<?php
	session_start();
	$myfile = fopen("otp.txt", "r");
	$som=fgets($myfile);
	fclose($myfile);
	if(intval($_POST["ver_code"])==intval($som)){
		$folder_path = 'Files/'.$_SESSION["userName"];
		$files = glob($folder_path.'*/*'); 
		foreach($files as $file) {
			if(is_file($file)){
			        unlink($file); 
			}
		}
		$myfile = fopen("otp.txt", "w");
		fwrite($myfile,strval((int) substr(number_format(time() * rand(), 0, '', ''), 0, 6)));
		fclose($myfile);
		$myfile = fopen("Files/".$_SESSION["userEmail"]."/count.txt", "w");
		fwrite($myfile, "0");
		fclose($myfile);
		$myfile = fopen("Files/".$_SESSION["userEmail"]."/price.txt", "w");
		fwrite($myfile, "0");
		fclose($myfile);
		header("Location: index.php?print=success");
	}else{
		header("Location: index.php?error=invalidOTP");
	}
?>
