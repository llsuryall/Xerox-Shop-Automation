<?php
	session_start();
	if(isset($_POST['submit'])){
		$countfiles = count($_FILES['files']['name']);
		for($i=0;$i<$countfiles;$i++){
			$filename = $_FILES['files']['name'][$i];
			move_uploaded_file($_FILES['files']['tmp_name'][$i],'Files/'.$_SESSION["userEmail"]."/".$filename);
		}
		$myfile = fopen("Files/".$_SESSION["userEmail"]."/count.txt", "r");
		$scount=intval(fgets($myfile));
		fclose($myfile);
		$myfile = fopen("Files/".$_SESSION["userEmail"]."/count.txt", "w");
		$scount=$scount+intval($_POST["count"]);
		fwrite($myfile, strval($scount));
		fclose($myfile);
		$myfile = fopen("Files/".$_SESSION["userEmail"]."/price.txt", "w");
		fwrite($myfile,strval($scount*2));
		fclose($myfile);
		header("Location: index.php");
	}
?>
