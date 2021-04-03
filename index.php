<?php session_start();?>
<!DOCTYPE html>
<html>
<head>
	<title>Login or Signup</title>
</head>
<body>
	<?php
		if(isset($_POST["delfile"])){
			$pdf = file_get_contents($_POST["delfile"]);
			$number = preg_match_all("/\/Page\W/", $pdf, $dummy);
			$myfile = fopen("Files/".$_SESSION["userEmail"]."/count.txt", "r");
			$scount=intval(fgets($myfile));
			fclose($myfile);
			$myfile = fopen("Files/".$_SESSION["userEmail"]."/count.txt", "w");
			$scount=$scount-intval($number);
			fwrite($myfile, strval($scount));
			fclose($myfile);
			$myfile = fopen("Files/".$_SESSION["userEmail"]."/price.txt", "w");
			fwrite($myfile,strval($scount*2));
			fclose($myfile);
			unlink(strval($_POST["delfile"]));
		}
		function wrapper($filename){
			$user=$_SESSION["userEmail"];
			$html=<<<SOM
				<div align="center" class="container">
					<form action="index.php" method="post">
						$filename
						<input type="hidden" name="delfile" value="Files/$user/$filename"/>	
						<input type="submit" value="delete"/>
					</form>
				</div>
			SOM;
			return $html;
		}
		if(!isset($_SESSION["userEmail"])){
			header("Location: login.php");
		}else{
			echo $_SESSION["userEmail"]." <a href=\"logout.php\">Logout</a>";
			$myfile = fopen('Files/'.$_SESSION["userEmail"]."/"."price.txt", "r");
			$price=strval(fgets($myfile));
			fclose($myfile);
			$myfile = fopen('Files/'.$_SESSION["userEmail"]."/"."count.txt", "r");
			$scount=fgets($myfile);
			fclose($myfile);
			$input = <<<INP
				<br/><br/>
				<form align="center" action="addfiles.php" method="post" enctype="multipart/form-data">
					<input id="files" name="files[]" accept="application/pdf" type="file" onchange="change_count(this);" required multiple/>
					<input id="count" name="count" type="hidden" value="0"/>
					<input name="submit" type="submit" value="Upload"/>
				</form>
				<form align="center" action="deleteall.php" method="post">
					<input onclick="print(this);" type="button" value="Print"/>
					<input id="ver_code" type="hidden" name="ver_code" maxlength="6" size="6" value="000000"/>
					<input id="sub_but" name="submit" type="hidden" value="Verify"/>
				</form><br/>
				<form align="center" action="payment.php"><input type="submit" value="Pay Rs. $price"/></form>
				<br/><br/>
				<div align="center">Total no of pages - $scount<br/>
				Total price - $price Rs.
				</div>
			INP;
			echo $input;
			$mydir = 'Files/'.$_SESSION["userEmail"]."/";
			$myfiles = array_diff(scandir($mydir), array('.', '..',"count.txt","price.txt"));
			echo "<br/>";
			foreach($myfiles as $filename){
				echo wrapper($filename).'<br/>';
			}
		}
	?>
	<script>
		const count_el=document.getElementById("count");
		const ver_code=document.getElementById("ver_code");
		const sub_but=document.getElementById("sub_but");
		function change_count(input){
			let sum=0;
			for(let i=0;i<input.files.length;i++){
				let reader = new FileReader();
				reader.readAsBinaryString(input.files[i]);
				reader.onloadend = function(){
					let count = reader.result.match(/\/Type[\s]*\/Page[^s]/g).length;
					sum=sum+parseInt(count);
					count_el.value=sum;
				}
			}
		}
		function print(pri){
			pri.setAttribute("type","hidden");
			ver_code.setAttribute("type","text");
			sub_but.setAttribute("type","submit");
		}
	</script>
</body>
</html>
