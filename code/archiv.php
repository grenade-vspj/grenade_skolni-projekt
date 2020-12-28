<?php
require "conn.php";
require "opravneni.php";
require "functions.php";
require "kontrola_prihlaseni.php";

if (isset($_GET["stahni_zip"]) && !empty($_GET["stahni_zip"])) {
    $zip_cislo = $_GET["stahni_zip"];
    stahni_zip(cesty_k_clankum($conn, $zip_cislo), nazev_zipu_casopisu($zip_cislo));
}
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
    <h2 class="mt-4">Archiv všech článků</h2>
   
   
    <table class="table table-striped table-hover">
            <thead class="thead-dark">
            <tr>
             
                <th>Název článku</th>
                <th>Autor</th>
  
                <th>Číslo časopisu</th>
                <th>
                    <form action="archiv.php" method="get" class="input-group">
                      <select class="form-control form-control-sm" data-toggle="tooltip" title="Zvolte číslo časopisu ke stažení" style="max-width: 70px; min-width: 50px;" name="stahni_zip">
                          <?php

                          $cisla_query = $conn->query("SELECT DISTINCT(cislo_casopisu) AS cisla FROM clanky WHERE id_stav = 7 ORDER BY cisla DESC");
                          $pocet = $cisla_query->num_rows;
                          while ($cislo = $cisla_query->fetch_assoc()) {
                              echo '<option value="' . $cislo['cisla'] . '">'. $cislo['cisla'] .'</option>';
                          }
                          ?>
                      </select>
                      <div class="input-group-append">
                        <button type="submit" class="btn btn-info btn-sm" data-toggle="tooltip" title="Stáhnout všechny články z čísla časopisu" <?php echo ($pocet > 0 ? '' : 'disabled') ?>>
                            <i class="fas fa-download"></i>
                        </button>
                      </div>
                    </form>
                </th>
            </tr>
            </thead>
            <tbody>
                <?php
                    //vypsat
                    $vypsani = $conn->query("SELECT clanky.*, stav.nazev AS nazev_stav FROM clanky
                        INNER JOIN stav ON clanky.id_stav = stav.id 
                    WHERE  id_stav = 7
                    ORDER BY cislo_casopisu DESC, id_clanek DESC");
                    while ($data = $vypsani->fetch_assoc()) {
                        $id = $data['id_clanek'];
                        $clanek = nejnovejsi_verze_clanku($conn, $id);
                        $autor = uzivatel_podle_id($conn, $data['id_autor']);

                        echo '
                                <td>' . $data['nazev'] . '</td>
                                <td data-toggle="tooltip" title="' . $autor['prihlas_jmeno'] . '">' . $autor['jmeno'] . ' ' . $autor['prijmeni'] . '</td>
                                <td><b>' . $data['cislo_casopisu'] . '</b></td>
                                <td>
                                    <a target="_blank" href="' . $clanek['cesta'] . '" class="btn btn-secondary btn-sm" data-toggle="tooltip" title="Stáhnout článek">
                                        <i class="fas fa-download"></i>
                                    </a>
                                   
                                                     
                                </td>
                            </tr>';
                    }
                ?>
            </tbody>
        </table>



 

</main>
    <?php include "footer.php" ?>
  </body>
</html>

<?php $conn -> close(); ?>