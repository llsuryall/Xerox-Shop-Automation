<?php
	session_start();
	if(isset($_POST['submit'])){
		$countfiles = count($_FILES['files']['name']);
		$extra=0;
		for($i=0;$i<$countfiles;$i++){
			$filename = $_FILES['files']['name'][$i];
			if(!file_exists('Files/'.$_SESSION["userEmail"]."/".$filename)){
				move_uploaded_file($_FILES['files']['tmp_name'][$i],'Files/'.$_SESSION["userEmail"]."/".$filename);
			}else{
				$pdf = file_get_contents('Files/'.$_SESSION["userEmail"]."/".$filename);
				$number = preg_match_all("/\/Page\W/", $pdf, $dummy);
				$extra=$extra+$number;
			}
		}
		$myfile = fopen("Files/".$_SESSION["userEmail"]."/count.txt", "r");
		$scount=intval(fgets($myfile));
		fclose($myfile);
		$myfile = fopen("Files/".$_SESSION["userEmail"]."/count.txt", "w");
		$scount=$scount-$extra+intval($_POST["count"]);
		fwrite($myfile, strval($scount));
		fclose($myfile);
		$myfile = fopen("Files/".$_SESSION["userEmail"]."/price.txt", "w");
		fwrite($myfile,strval($scount*2));
		fclose($myfile);
		header("Location: index.php");
	}
?>
