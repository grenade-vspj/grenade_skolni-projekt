<?php
    require_once 'conn.php';
    require_once 'kontrola_prihlaseni.php';
    require_once 'autor_private.php';

    $id_login = $_SESSION['id'];

    $stmt = $conn->query("SELECT * FROM ucet WHERE id = '$id_login'");
    $data = $stmt->fetch_assoc();
    $prihlas_jmeno = $data['prihlas_jmeno'];
?>

<!DOCTYPE html>
<html lang="en">
    <?php include "head.php" ?>
    <body>
        <?php include "top.php" ?>
        <main role="main" class="container-fluid">

<div align="center">
	<br>
	<h2>Nahrání článku do systému</h2>
	<br>
	<form action="upload.php" method="POST" enctype="multipart/form-data">
		<label for="autor"><span style="color:red">*</span><strong> Autor:</strong></label>
		<input type="text" class="form-control" name="autor" value="<?php echo $prihlas_jmeno; ?>" style="width:200px;" readonly>
		<br>
		<label for="udaje"><strong>Kontaktní údaje:</strong></label>
		<input type="text" class="form-control" name="udaje" style="width:300px">
		<br>
		<label for="nazev"><span style="color:red">*</span><strong> Název článku:</strong></label>
		<input type="text" class="form-control" id="nazev" name="nazev" style="width:300px" required>
		<br>
		<label for="file"><span style="color:red">*</span><strong> Cesta k souboru:</strong></label>
		<br>
		<input type="file" name="file" required></button>
		<br><br>
		<label for="cislo"><span style="color:red">*</span><strong> Číslo časopisu:</strong></label>
		<input type="number" id="cislo" class="form-control" style="width:80px" name="cislo" min="1" max="100" required>
		<br>
		<button type="submit" id="submit" name="submit" class="btn btn-primary">Nahrát</button>
		<br>
	</form>


</div>

        </main>
        <?php include "footer.php" ?>

    </body>
</html>

<?php $conn -> close(); ?>
