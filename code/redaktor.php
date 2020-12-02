<?php 
    require "conn.php";
    require "opravneni.php";
    require "functions.php";
    require "redaktor_private.php";

    $id_login = $_SESSION['id'];
    $_SESSION['cerstve_prihlaseni']=0;
?>

<!doctype html>
<html lang="en">
  <?php include "head.php" ?>
  <body>
    <?php include "top.php" ?>
    <main role="main" class="container-fluid">
        <?php include "redaktor_header.php" ?>

        <h2 class="mt-4 mb-5">Redaktor</h2>
        <table class="table table-striped table-hover">
            <thead class="thead-dark">
            <tr>
                <th>Stav</th>
                <th>Název článku</th>
                <th>Autor</th>
                <th>Termín recenze</th>
                <th>Recenzent 1</th>
                <th>Recenzent 2</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
                <?php
                    //vypsat
                    $vypsani = $conn->query("SELECT clanky.*, stav.nazev AS nazev_stav FROM clanky INNER JOIN stav ON clanky.id_stav = stav.id ORDER BY id_clanek DESC");
                    while ($data = $vypsani->fetch_assoc()) {
                        $id = $data['id_clanek'];
                        $clanek = nejnovejsi_verze_clanku($conn, $id);
                        $autor = uzivatel_podle_id($conn, $data['id_autor']);
                        $recenzent_1 = uzivatel_podle_id($conn, $data['id_recenzent1']);
                        $recenzent_2 = uzivatel_podle_id($conn, $data['id_recenzent2']);

                        echo '<tr>
                                <td class="' . table_barva_stavu_clanku($data['id_stav']) . '">' . $data['nazev_stav'] . '</td>
                                <td>' . $data['nazev'] . '</td>
                                <td data-toggle="tooltip" title="' . $autor['prihlas_jmeno'] . '">' . $autor['jmeno'] . ' ' . $autor['prijmeni'] . '</td>
                                <td><strong>' . $data['termin_recenze'] . '</strong></td>
                                <td data-toggle="tooltip" title="' . $recenzent_1['prihlas_jmeno'] . '">' . $recenzent_1['jmeno'] . ' ' . $recenzent_1['prijmeni'] . '</td>
                                <td data-toggle="tooltip" title="' . $recenzent_2['prihlas_jmeno'] . '">' . $recenzent_2['jmeno'] . ' ' . $recenzent_2['prijmeni'] . '</td>
                                <td>
                                    <a target="_blank" href="' . $clanek['cesta'] . '" class="btn btn-secondary btn-sm" data-toggle="tooltip" title="Stáhnout nejnovější verzi článku">
                                        <i class="fas fa-download"></i>
                                    </a>
                                    <a href="redaktor_recenzni_rizeni.php?id_clanku=' . $id . '" class="btn btn-primary btn-sm" data-toggle="tooltip" title="Recenzní řízení">
                                        Recenzní řízení
                                    </a>
                                    <a href="#" class="btn btn-success btn-sm disabled" data-toggle="tooltip" title="Schválit článek" >
                                        <i class="fas fa-check"></i>
                                    </a>
                                    <a href="#" class="btn btn-warning btn-sm disabled" data-toggle="tooltip" title="Vrátit autorovi na doplnění">
                                        <i class="fas fa-undo"></i>
                                    </a>
                                    <a href="#" class="btn btn-danger btn-sm disabled" data-toggle="tooltip" title="Zamítnout článek">
                                        <i class="fas fa-ban"></i>
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
