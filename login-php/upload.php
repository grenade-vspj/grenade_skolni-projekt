<?php
if (isset($_POST['submit'])) {
	$file = $_FILES['file'];

	$fileName = $_FILES['file']['name'];
	$fileTmpName =  $_FILES['file']['tmp_name'];
	$fileSize = $_FILES['file']['size'];
	$fileError = $_FILES['file']['error'];
	$fileType = $_FILES['file']['type'];

	$fileExt = explode('.', $fileName);
	$fileActualExt = strtolower(end($fileExt));

	$allowed = array('pdf', 'doc', 'docx');
	
	$created = FALSE;

	if (in_array($fileActualExt, $allowed)) {
		if ($fileError === 0) {
			if ($fileSize < 10485760) {
				//$fileDestination = 'clanky/'.$fileName;
				$fileDestination = 'clanky/'.$_POST['nazev'].'.'.$fileActualExt;
				if (move_uploaded_file($fileTmpName, $fileDestination)) {
					echo "uspesne nahran";
					$created = TRUE;
				} else {
					echo "nenahran";
				}			} else {
				echo "Soubor je prilis velky.";
			}
		} else {
			echo "Nelze upload.";
		}
	} else {
		echo "Nelze nahrát soubor tohoto typu. Povolene typy jsou pdf, doc, docx.";
	}

}
?>
<!DOCTYPE html>
<html>
<p>pepa</p>
</html>