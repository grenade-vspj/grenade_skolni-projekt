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
    <h2 class="mt-4">Výběr článků z aktuálního čísla časopisu</h2>
   

        <table class="table table-striped table-hover">
            <?php
                $cislo = null;
                $cislo_query = $conn->query("SELECT MAX(cislo_casopisu) AS max_cislo FROM clanky WHERE id_stav = 7");
                if ($cislo_query->num_rows > 0) {
                    $cislo = ($cislo_query->fetch_assoc())['max_cislo'];
                }
            ?>

            <thead class="thead-dark">
            <tr>
              
                <th>Název článku</th>
                <th>Autor</th>
          
                <th>Číslo časopisu</th>
                <th>
                    <a href="aktualni_cislo.php?stahni_zip=<?= $cislo ?>" class="btn btn-info btn-sm" data-toggle="tooltip" title="Stáhnout všechny články z čísla časopisu">
                        <i class="fas fa-download"></i>
                    </a>
                </th>
            </tr>
            </thead>
            <tbody>
                <?php
                    $vypsani = $conn->query("SELECT clanky.*, stav.nazev AS nazev_stav FROM clanky
                    INNER JOIN stav ON clanky.id_stav = stav.id 
                    WHERE cislo_casopisu = ". $cislo ." AND id_stav = 7
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