<?php

// print_r($_FILES); echo '<br>';
// echo exec('whoami'); echo '<br>';
// echo '/home/team1/public_html/grenade/code/clanky - '.(is_writable('/home/team1/public_html/grenade/code/clanky') ? 'ANO' : 'NE'); echo '<br>';
// var_dump();

error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

require_once 'conn.php';
require_once 'kontrola_prihlaseni.php';
require_once 'autor_private.php';

$zprava = '';
$kod_zpravy = '';
$id_login = $_SESSION['id'];

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

	$kontaktniUdaje = $_POST['udaje'];
	$cisloClanku = $_POST['cislo'];
	$nazev = $_POST['nazev'];
	$created = FALSE;

	if (in_array($fileActualExt, $allowed)) {
		if ($fileError === 0) {
			if ($fileSize < 10485760) {
				$fileDestination = 'clanky/'.$nazev.'.'.$fileActualExt;

				if (file_exists($fileDestination)) {
                    $zprava = 'Soubor s tímto názvem již existuje.';
                    $kod_zpravy = 'danger';
				} else {
					if (move_uploaded_file($fileTmpName, $fileDestination)) {
                        $zprava = 'Soubor byl úspěšně nahrán.';
                        $kod_zpravy = 'success';
						$created = TRUE;
					} else {
                        $zprava = 'Soubor se nepodařilo nahrát.';
                        $kod_zpravy = 'danger';
					}
				}

			} else {
                $zprava = 'Soubor je příliš velký.';
                $kod_zpravy = 'danger';
			}
		} else {
            $zprava = 'Nelze uploadovat.';
            $kod_zpravy = 'danger';
		}
	} else {
        $zprava = 'Nelze nahrát soubor tohoto typu. Povolené typy jsou pdf, doc, docx.';
        $kod_zpravy = 'danger';
	}

	// Pokud se vytvořil soubor na serveru, vložit do databáze
	if ($created === TRUE) {
		$stmt = $conn->prepare("INSERT INTO clanky(id_autor, id_stav, nazev, cislo_clanku) VALUES(? , 1, ?, ?)");
		$stmt->bind_param('isi', $id_login, $nazev, $cisloClanku);
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
<html lang="en">
    <?php include "head.php" ?>
    <body>
        <?php include "top.php" ?>

        <main role="main" class="container-fluid">

            <div class="starter-template">

                <?php if(!empty($zprava)){ ?>
                    <div class="alert alert-<?php echo $kod_zpravy; ?> alert-dismissible text-center">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <b> <?php echo $zprava; ?> </b>
                    </div>
                <?php } $zprava = ''; $kod_zpravy = ''; ?>

                <a href="autor.php" class="btn btn-secondary">Zpět</a>
            </div>

        </main>

        <?php include "footer.php" ?>
    </body>
</html>

<?php $conn -> close(); ?>
