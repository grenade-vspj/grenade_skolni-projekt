<?php
    require_once 'conn.php';
    require_once 'kontrola_prihlaseni.php';
    require_once 'autor_private.php';

    $id_login = $_SESSION['id'];
?>

<!doctype html>
<html lang="en">
    <?php include "head.php" ?>
    <body>
        <?php include "top.php" ?>
        <main role="main" class="container-fluid">

<div>

	<input type="text" name="udaje" placeholder="Kontaktní údaje">
	<br><br>

	<form action="upload.php" method="POST" enctype="multipart/form-data">
		<input type="text" name="nazev" placeholder="Název článku" required>
		<br><br>
		<input type="file" name="file" placeholder="Cesta k článku" required>
		<button type="submit" name="submit">Nahrát</button>
	</form>


</div>

        </main>
        <?php include "footer.php" ?>

    </body>
</html>

<?php $conn -> close(); ?>