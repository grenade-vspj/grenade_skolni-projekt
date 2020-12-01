<?php
require_once('conn.php');

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

	$nazev = $_POST['nazev'];
	$created = FALSE;

	if (in_array($fileActualExt, $allowed)) {
		if ($fileError === 0) {
			if ($fileSize < 10485760) {
				$fileDestination = 'clanky/'.$nazev.'.'.$fileActualExt;

				if (file_exists($fileDestination)) {
					echo 'Soubor s timto nazvem jiz existuje.';
				} else {
					if (move_uploaded_file($fileTmpName, $fileDestination)) {
						echo "Soubor byl uspesne nahran.";
						$created = TRUE;
					} else {
						echo "Soubor se nepodarilo nahrat.";
					}
				}

			} else {
				echo "Soubor je prilis velky.";
			}
		} else {
			echo "Nelze upload.";
		}
	} else {
		echo "Nelze nahrát soubor tohoto typu. Povolene typy jsou pdf, doc, docx.";
	}

	// Pokud se vytvořil soubor na serveru, vložit do databáze
	if ($created === TRUE) {
		$stmt = $conn->prepare("INSERT INTO clanky(id_stav, nazev) VALUES(1, ?)");
		$stmt->bind_param('s', $nazev);
		$stmt->execute();
		$id = $stmt->insert_id;

		if ($id !== null) {
			$stmt = $conn->prepare("INSERT INTO verze(id_clanek, cesta) VALUES(?, ?)");
			$stmt->bind_param('is', $id, $fileDestination);
			$stmt->execute();
		}
		$stmt->close();
	}
		
}
?>
<!DOCTYPE html>
<html>
<p>pepa</p>
</html>
