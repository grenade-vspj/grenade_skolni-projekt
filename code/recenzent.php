<?php
require "conn.php";
require "opravneni.php";
require "functions.php";
require "kontrola_prihlaseni.php";
require "recenzent_private.php";

$id_login = $_SESSION['id'];
$_SESSION['cerstve_prihlaseni']=0;
?>

<!doctype html>
<html lang="en">
  <?php include "head.php" ?>
  <body>
    <?php include "top.php" ?>

    <main role="main" class="container">

        <div class="starter-template">
            <h1>LOGOS POLYTECHNIKOS</h1>

        </div>
        <h2 class="mt-4 mb-5">Recenzent</h2>

        <div class="row mb-3">
            <div class="col-md-4 themed-grid-col"><b>Název článku</b></div>
            <div class="col-md-3 themed-grid-col"><b>Termín hodnocení</b></div>
            <div class="col-md-2 themed-grid-col"><b>Ohodnoceno</b></div>
            <div class="col-md-3 themed-grid-col"><b></b></div>
        </div>
        <hr>

        <?php
        //vypsat
        $vypsani = $conn->query("SELECT * FROM `clanky` WHERE (`id_recenzent1` = '$id_login' OR `id_recenzent2` = '$id_login') AND `id_stav` = 3 ORDER BY `termin_recenze` DESC");
        while ($data = $vypsani->fetch_assoc()) {
            $id = $data['id_clanek'];
            $nazev = $data['nazev'];
            $termin = $data['termin_recenze'];
            $je_hodnoceni = false;
            if (($data['id_recenzent1']==$id_login && !empty($data['hodnoceni_recenzent1'])) || $data['id_recenzent2']==$id_login && !empty($data['hodnoceni_recenzent2'])) {
                $je_hodnoceni = true;
            }
            ?>
            <div class="row mb-3">
                <div class="col-md-4 themed-grid-col"><?php echo $nazev; ?></div>
                <div class="col-md-3 themed-grid-col"><?php echo $termin; ?></div>
                <div class="col-md-2 themed-grid-col"><?php echo $je_hodnoceni ? '<span class="text-info" style="font-size: 1.5rem;"><i class="fas fa-check-circle"></i></span>' : '' ?></div>
                <div class="col-md-3 themed-grid-col"><a href="./recenzent-clanek.php?id_clanku=<?php echo $id; ?>" class="btn btn-info">Přečíst a ohnodtotit článek</a></div>
            </div>
            <hr>
        <?php } ?>



    </main>

    <?php include "footer.php" ?>
  </body>
</html>

<?php $conn -> close(); ?>