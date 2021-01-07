<?php
require "conn.php";
require "opravneni.php";
require "functions.php";
require "kontrola_prihlaseni.php";
require "recenzent_private.php";

$id = $_GET["id_clanku"];

if (empty($id)) {
    header("Location: recenzent.php");
    exit();
}

$zprava = '';
$kod_zpravy = '';

if(!empty($_POST["akce"]) AND $_POST["akce"] = 'hodnoceni'){
    $hodnoceni_clanku = mysqli_real_escape_string($conn, htmlspecialchars($_POST["hodnoceni"]));
    $id_recenzenta = $_POST["id_recenzenta"];
    
    $vypsani = $conn->query("SELECT * FROM `clanky` WHERE `id_clanek` = '$id'");
        while ($data = $vypsani->fetch_assoc()) {
            $recenzent1 = $data['id_recenzent1'];
            $recenzent2 = $data['id_recenzent2']; 
        }
        
    if($id_recenzenta == $recenzent1){
      if($conn->query("UPDATE `clanky` SET `hodnoceni_recenzent1` = '$hodnoceni_clanku' WHERE `id_clanek` = '$id'")) {
          $zprava = 'Hodnocení úspěšně uloženo.';
          $kod_zpravy = 'success';
      } else {
          $zprava = 'Chyba - něco se nepovedlo!';
          $kod_zpravy = 'danger';
      }
    }

    if($id_recenzenta == $recenzent2){
      if($conn->query("UPDATE `clanky` SET `hodnoceni_recenzent2` = '$hodnoceni_clanku' WHERE `id_clanek` = '$id'")) {
          $zprava = 'Hodnocení úspěšně uloženo.';
          $kod_zpravy = 'success';
      } else {
          $zprava = 'Chyba - něco se nepovedlo!';
          $kod_zpravy = 'danger';
      }
    }
    
}

$id_login = $_SESSION['id'];
?>

<!doctype html>
<html lang="en">
  <?php include "head.php" ?>
  <body>
    <?php include "top.php" ?>

    <main role="main" class="container">

      <div class="starter-template">

          <?php if(!empty($zprava)){ ?>
              <div class="alert alert-<?php echo $kod_zpravy; ?> alert-dismissible text-center">
                  <button type="button" class="close" data-dismiss="alert">&times;</button>
                  <b> <?php echo $zprava; ?> </b>
              </div>
          <?php } $zprava = ''; $kod_zpravy = ''; ?>


      </div>
        <h2 class="mb-3" style="margin-top: 100px;">Detail článku</h2>

            <?php
            //vypsat
            $vypsani = $conn->query("SELECT * FROM `clanky` WHERE `id_clanek` = '$id'");
            while ($data = $vypsani->fetch_assoc()) {
                $id = $data['id_clanek'];
                $nazev = $data['nazev'];
                $recenzent1 = $data['id_recenzent1'];
                $recenzent2 = $data['id_recenzent2'];

                if($id_login == $recenzent1){$hodnoceni = $data['hodnoceni_recenzent1'];}
                elseif($id_login == $recenzent2){$hodnoceni = $data['hodnoceni_recenzent2'];}
                else{$hodnoceni = "";}
            }

            //vypsat
            $clanek = $conn->query("SELECT * FROM `verze` WHERE `id_clanek` = '$id' ORDER BY `id_verze` ASC");
            while ($data = $clanek->fetch_assoc()) {
                $cesta = $data['cesta'];
            }

            ?>
            <div class="row mb-5">
              <div class="col-md-12 themed-grid-col"><a target="_blank" href="./<?php echo $cesta; ?>" target="_blank" class="btn btn-info">Stáhnout článek pro prečtení</a></div>
            </div>

          <h2 class="mt-4 mb-3">Hodnocení článku</h2>
          <form action='./recenzent-clanek.php?id_clanku=<?php echo $id; ?>' class='g-bg-dark-v1 g-px-50 g-pt-50 g-pb-100' method='post'>
                <input type="hidden" name="id_recenzenta" value="<?php echo $id_login; ?>">
                <input type="hidden" name="akce" value="hodnoceni">
                <?php // if($recenzent1 == $id_login){echo "<input type='hidden' name='hodnoce_recenzent1' value="">";} ?>
                <textarea type='text' name='hodnoceni' rows='4' cols='50'><?php echo $hodnoceni; ?></textarea>
                <br>
                <button class='btn btn-info' type='submit'>Odeslat hodnocení</button>
                <a href="recenzent.php" class="btn btn-secondary">Zpět</a>
         </form>

    </main>

    <?php include "footer.php" ?>
  </body>
</html>

<?php $conn -> close(); ?>
