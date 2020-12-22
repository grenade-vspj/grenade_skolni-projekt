<?php
    require "conn.php";
    require "opravneni.php";
    require "functions.php";
    require "kontrola_prihlaseni.php";
    require "redaktor_private.php";

    $id_login = $_SESSION['id'];
    $_SESSION['cerstve_prihlaseni']=0;

    $zprava = isset($_SESSION['zprava']) ? $_SESSION['zprava'] : "";
    $kod_zpravy = isset($_SESSION['kod_zpravy']) ? $_SESSION['kod_zpravy'] : "";
    unset ($_SESSION['zprava']);
    unset ($_SESSION['kod_zpravy']);
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
                <th>Hodnocení 1</th>
                <th>Recenzent 2</th>
                <th>Hodnocení 2</th>
                <th>Číslo časopisu</th>
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
                        $je_hodnoceni1 = !empty($data['hodnoceni_recenzent1']);
                        $recenzent_2 = uzivatel_podle_id($conn, $data['id_recenzent2']);
                        $je_hodnoceni2 = !empty($data['hodnoceni_recenzent2']);
                        $je_hodnoceni = $je_hodnoceni1 && $je_hodnoceni2;
                        $je_zamitnuto = $data['id_stav'] == 6;
                        $je_prijato = $data['id_stav'] == 5;
                        $je_vraceno = $data['id_stav'] == 4;
                        $je_zverejneno = $data['id_stav'] == 7;

                        echo '<tr class="'. ($je_zverejneno ? table_barva_stavu_clanku($data['id_stav']) : '') .'">
                                <td class="' . table_barva_stavu_clanku($data['id_stav']) . '">' . $data['nazev_stav'] . '</td>
                                <td>' . $data['nazev'] . '</td>
                                <td data-toggle="tooltip" title="' . $autor['prihlas_jmeno'] . '">' . $autor['jmeno'] . ' ' . $autor['prijmeni'] . '</td>
                                <td><b>' . $data['termin_recenze'] . '</b></td>
                                <td data-toggle="tooltip" title="' . $recenzent_1['prihlas_jmeno'] . '">' . $recenzent_1['jmeno'] . ' ' . $recenzent_1['prijmeni'] . '</td>
                                <td>
                                    ' . ($je_hodnoceni1 ? '
                                    <div data-toggle="modal"  data-target="#modal1-' . $id . '">
                                        <a href="#" class="btn btn-primary btn-sm" data-toggle="tooltip" title="Náhled dostupného hodnocení">
                                            <i class="fas fa-search"></i>
                                            Dostupné
                                        </a>
                                    </div>
                                    ' : "") . '
                                </td>
                                <td data-toggle="tooltip" title="' . $recenzent_2['prihlas_jmeno'] . '">' . $recenzent_2['jmeno'] . ' ' . $recenzent_2['prijmeni'] . '</td>
                                <td>
                                    ' . ($je_hodnoceni2 ? '
                                    <div data-toggle="modal"  data-target="#modal2-' . $id . '">
                                        <a href="#" class="btn btn-primary btn-sm" data-toggle="tooltip" title="Náhled dostupného hodnocení">
                                            <i class="fas fa-search"></i>
                                            Dostupné
                                        </a>
                                    </div>
                                    ' : "") . '
                                </td>
                                <td><b>' . ' ' . '</b></td>
                                <td>
                                    <a target="_blank" href="' . $clanek['cesta'] . '" class="btn btn-secondary btn-sm" data-toggle="tooltip" title="Stáhnout nejnovější verzi článku">
                                        <i class="fas fa-download"></i>
                                    </a>
                                    <a href="redaktor_recenzni_rizeni.php?id_clanku=' . $id . '" class="btn btn-primary btn-sm" data-toggle="tooltip" title="Recenzní řízení">
                                        <i class="fas fa-forward"></i>
                                        Recenzní řízení
                                    </a>
                                    <a href="redaktor_akce.php?id_clanku=' . $id . '&akce=prijmout" class="btn btn-success btn-sm ' . ($je_prijato || !$je_hodnoceni || $je_zverejneno ? 'disabled' : '') . '" data-toggle="tooltip" title="Schválit článek" onclick="return confirm(`Opravdu chcete tento článek schválit?`);">
                                        <i class="fas fa-check"></i>
                                    </a>
                                    <a href="redaktor_akce.php?id_clanku=' . $id . '&akce=doplnit" class="btn btn-warning btn-sm ' . ($je_vraceno || !$je_hodnoceni || $je_zverejneno ? 'disabled' : '') . '" data-toggle="tooltip" title="Vrátit autorovi na doplnění" onclick="return confirm(`Opravdu chcete tento článek vrátit autorovi na doplnění?`);">
                                        <i class="fas fa-undo"></i>
                                    </a>
                                    <a href="redaktor_akce.php?id_clanku=' . $id . '&akce=zamitnout" class="btn btn-danger btn-sm ' . ($je_zamitnuto || $je_zverejneno ? 'disabled' : '') . '" data-toggle="tooltip" title="Zamítnout článek" onclick="return confirm(`Opravdu chcete tento článek zamítnout?`);">
                                        <i class="fas fa-ban"></i>
                                    </a>
                                    <a href="redaktor_akce.php?id_clanku=' . $id . '&akce=zverejnit" class="btn btn-info btn-sm ' . ($je_prijato ? '' : 'disabled') . '" data-toggle="tooltip" title="Zveřejnit článek v časopisu" onclick="return confirm(`Opravdu chcete tento článek zveřejnit do příslušného čísla časopisu?`);">
                                        <i class="fas fa-share-square"></i>
                                    </a>                                    
                                </td>
                            </tr>';
                        echo ' <!-- Modal 1 -->
                            <div class="modal fade" id="modal1-' . $id . '">
                              <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Hodnocení 1: '. $recenzent_1['jmeno'] . ' ' . $recenzent_1['prijmeni'] .'</h5>
                                        <button type="button" class="close" data-dismiss="modal">×</button>
                                    </div>
                                    <div class="modal-body">
                                      <p>' . $data['hodnoceni_recenzent1'] . '</p>
                                    </div>
                                    <div class="modal-footer">
                                      <button type="button" class="btn btn-danger" data-dismiss="modal">Zavřít</button>
                                    </div>  
                                </div>
                              </div>
                            </div>
                             <!-- Modal 2 -->
                            <div class="modal fade" id="modal2-' . $id . '">
                              <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Hodnocení 1: '. $recenzent_2['jmeno'] . ' ' . $recenzent_2['prijmeni'] .'</h5>
                                        <button type="button" class="close" data-dismiss="modal">×</button>
                                    </div>
                                    <div class="modal-body">
                                      <p>' . $data['hodnoceni_recenzent2'] . '</p>
                                    </div>
                                    <div class="modal-footer">
                                      <button type="button" class="btn btn-danger" data-dismiss="modal">Zavřít</button>
                                    </div>  
                                </div>
                              </div>
                            </div>';
                    }
                ?>
            </tbody>
        </table>

    </main>
    <?php include "footer.php" ?>

  </body>
</html>

<?php $conn -> close(); ?>
