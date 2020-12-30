<?php
    require "conn.php";
    require "opravneni.php";
    require "functions.php";
    require "kontrola_prihlaseni.php";
    require "redaktor_private.php";

    if (isset($_GET["stahni_zip"]) && !empty($_GET["stahni_zip"])) {
        $zip_cislo = $_GET["stahni_zip"];
        $id_stavy = array();
        if (isset($_GET["id_stav"])) {
            if ($_GET["id_stav"] <= 0) {
                $id_stavy = array(1, 2, 3, 4, 5, 6, 7);
            } else {
                $id_stavy = array($_GET["id_stav"]);
            }
        } else {
            $id_stavy = array(7, 5);
        }
        stahni_zip(cesty_k_clankum_redaktor($conn, $zip_cislo, $id_stavy), nazev_zipu_casopisu($zip_cislo));
    }

    $isTabClanky = !isset($_REQUEST["tab"]) || empty($_REQUEST["tab"]) || $_REQUEST["tab"] == 'clanky-content';
    $isTabCisla = isset($_REQUEST["tab"]) && $_REQUEST["tab"] == 'cisla-content';

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

        <h2 class="mb-n4 text-center">Redaktor</h2>
        <ul class="nav nav-tabs" id="tabs-redaktor" role="tablist">
            <li class="nav-item">
                <a class="nav-link <?= ($isTabClanky ? 'active' : '') ?>" id="clanky-tab" data-toggle="tab" href="#clanky-content" role="tab" aria-controls="clanky-content" aria-selected="true">Články</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= ($isTabCisla ? 'active' : '') ?>" id="cisla-tab" data-toggle="tab" href="#cisla-content" role="tab" aria-controls="cisla-content" aria-selected="false">Čísla časopisu</a>
            </li>
        </ul>

        <div class="tab-content pt-3 pb-2 pl-2 pr-2" id="tabs-redaktor-content" style="box-shadow: 0px 10px 5px -5px lightgrey; border-bottom: 1px solid #dee2e6; border-left: 1px solid #dee2e6; border-right: 1px solid #dee2e6;">
            <div class="tab-pane fade show <?= ($isTabClanky ? 'active' : '') ?>" id="clanky-content" role="tabpanel" aria-labelledby="clanky-tab">
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
                        <th>
                            <form action="redaktor.php" method="get" class="input-group">
                                <select class="form-control form-control-sm" data-toggle="tooltip" title="Zvolte číslo časopisu ke stažení" style="max-width: 70px; min-width: 50px;" name="stahni_zip">
                                    <?php

                                    $cisla_query = $conn->query("SELECT DISTINCT(cislo_casopisu) AS cisla FROM clanky WHERE id_stav in(7, 5) ORDER BY cisla DESC");
                                    $pocet = $cisla_query->num_rows;
                                    while ($cislo = $cisla_query->fetch_assoc()) {
                                        echo '<option value="' . $cislo['cisla'] . '">'. $cislo['cisla'] .'</option>';
                                    }
                                    ?>
                                </select>
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-info btn-sm" data-toggle="tooltip" title="Stáhnout všechny zveřejněné nebo přijaté články z čísla časopisu" <?php echo ($pocet > 0 ? '' : 'disabled') ?>>
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
                            $vypsani = $conn->query("SELECT clanky.*, stav.nazev AS nazev_stav FROM clanky INNER JOIN stav ON clanky.id_stav = stav.id ORDER BY cislo_casopisu DESC, id_clanek DESC");
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
                                        <td>
                                            <b>' . $data['cislo_casopisu'] . '</b>
                                            '. ($je_zverejneno ? '' : '
                                            <span data-toggle="modal"  data-target="#modal3-' . $id . '">
                                                <a href="#" class="text-warning ml-2" data-toggle="tooltip" title="Změnit číslo časopisu"><i class="fas fa-pencil-alt"></i></a>
                                            </span>
                                            ') .'
                                        </td>
                                        <td>
                                            <a target="_blank" href="' . $clanek['cesta'] . '" class="btn btn-secondary btn-sm" data-toggle="tooltip" title="Stáhnout nejnovější verzi článku">
                                                <i class="fas fa-download"></i>
                                            </a>
                                            <a href="redaktor_recenzni_rizeni.php?id_clanku=' . $id . '" class="btn btn-primary btn-sm" data-toggle="tooltip" title="Recenzní řízení">
                                                <i class="fas fa-forward"></i>
                                                Recenzní řízení
                                            </a>
                                            <a href="redaktor_akce.php?id_clanku=' . $id . '&akce=prijmout" class="btn btn-success btn-sm ' . ($je_prijato || !$je_hodnoceni || $je_zverejneno ? 'disabled' : '') . ' '. ($je_zverejneno ? 'invisible' : '') .'" data-toggle="tooltip" title="Schválit článek" onclick="return confirm(`Opravdu chcete tento článek schválit?`);">
                                                <i class="fas fa-check"></i>
                                            </a>
                                            <a href="redaktor_akce.php?id_clanku=' . $id . '&akce=doplnit" class="btn btn-warning btn-sm ' . ($je_vraceno || !$je_hodnoceni || $je_zverejneno ? 'disabled' : '') . ' '. ($je_zverejneno ? 'invisible' : '') .'" data-toggle="tooltip" title="Vrátit autorovi na doplnění" onclick="return confirm(`Opravdu chcete tento článek vrátit autorovi na doplnění?`);">
                                                <i class="fas fa-undo"></i>
                                            </a>
                                            <a href="redaktor_akce.php?id_clanku=' . $id . '&akce=zamitnout" class="btn btn-danger btn-sm ' . ($je_zamitnuto || $je_zverejneno ? 'disabled' : '') . ' '. ($je_zverejneno ? 'invisible' : '') .'" data-toggle="tooltip" title="Zamítnout článek" onclick="return confirm(`Opravdu chcete tento článek zamítnout?`);">
                                                <i class="fas fa-ban"></i>
                                            </a>
                                    <!--    <a href="redaktor_akce.php?id_clanku=' . $id . '&akce=zverejnit" class="btn btn-info btn-sm ' . ($je_prijato ? '' : 'disabled') . '" data-toggle="tooltip" title="Zveřejnit článek v časopisu" onclick="return confirm(`Opravdu chcete tento článek zveřejnit do příslušného čísla časopisu?`);">
                                                <i class="fas fa-share-square"></i>
                                            </a>    -->                                
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
                                    </div>
                                    <!-- Modal 3 -->
                                    <div class="modal fade" id="modal3-' . $id . '">
                                      <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Změnit článku [ '. $data['nazev'] .' ] číslo časopisu: '. $data['cislo_casopisu'] .'</h5>
                                                <button type="button" class="close" data-dismiss="modal">×</button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="redaktor_akce.php" method="get">
                                                    <input type="hidden" name="id_clanku" value="'. $id .'"/>
                                                    <input type="hidden" name="akce" value="zmenit"/>
                                                    <div class="form-group">
                                                        <label for="nove_cislo_casopisu">Nové číslo časopisu</label>
                                                        <input type="number" class="form-control" id="nove_cislo_casopisu" name="nove_cislo_casopisu" min="1" max="100" required>
                                                    </div>
                                                    <button type="submit" class="btn btn-warning">Změnit</button>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Zavřít</button>
                                            </div>  
                                        </div>
                                      </div>
                                    </div>';

                            }
                        ?>
                    </tbody>
                </table>
            </div>

            <div class="tab-pane fade <?= ($isTabCisla ? 'show active' : '') ?>" id="cisla-content" role="tabpanel" aria-labelledby="cisla-tab">
                <table class="table table-striped table-hover">
                    <thead class="thead-dark">
                    <tr>
                        <th>Stav</th>
                        <th>Číslo časopisu</th>
                        <th>Zveřejněných článků</th>
                        <th>Přijatých článků</th>
                        <th>Zamítnutých článků</th>
                        <th>Všech článků</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    //vypsat
                    $cisla_query = $conn->query("SELECT DISTINCT(cislo_casopisu) AS cisla FROM clanky ORDER BY cisla DESC");
                    $pocet = $cisla_query->num_rows;
                    while ($cislo = $cisla_query->fetch_assoc()) {
                        $cislo_c = $cislo['cisla'];
                        $clanky = clanky_podle_cisla_casopisu($conn, $cislo_c);
                        $je_zverejneno = je_cislo_zverejneno($clanky);
                        $je_pripraveno = je_cislo_pripraveno($clanky);
                        $zverejnenych = pocet_clanku(7, $clanky);
                        $prijatych = pocet_clanku(5, $clanky);
                        $zamitnutych = pocet_clanku(6, $clanky);
                        $celkem = count($clanky);
                        $barva = ($je_zverejneno ? 'info' : ($je_pripraveno ? 'success' : 'warning'));
                        echo '<tr class="table-'. ($je_zverejneno ? $barva : '') .'">
                                <td class="table-'. $barva .'">'. ($je_zverejneno ? 'Zveřejněno' : ($je_pripraveno ? 'Připraveno' : 'Nekompletní')) .'</td>                                
                                <td><b>' . $cislo_c . '</b></td>
                                <td>                                    
                                    <form action="redaktor.php" method="get">
                                        <span>'. $zverejnenych .'&nbsp;</span>
                                        <input type="hidden" name="stahni_zip" value="' . $cislo_c . '"/>
                                        <input type="hidden" name="tab" value="cisla-content"/>
                                        <input type="hidden" name="id_stav" value="7"/>
                                        <button type="submit" class="btn btn-secondary btn-sm" data-toggle="tooltip" title="Stáhnout všechny zveřejněné články z čísla časopisu" '. ($zverejnenych > 0 ? '' : 'disabled') .'>
                                            <i class="fas fa-download"></i>
                                        </button>
                                    </form>
                                </td>
                                <td>                                    
                                    <form action="redaktor.php" method="get">
                                        <span>'. $prijatych .'&nbsp;</span>
                                        <input type="hidden" name="stahni_zip" value="' . $cislo_c . '"/>
                                        <input type="hidden" name="tab" value="cisla-content"/>
                                        <input type="hidden" name="id_stav" value="5"/>
                                        <button type="submit" class="btn btn-secondary btn-sm" data-toggle="tooltip" title="Stáhnout přijaté články" '. ($prijatych > 0 ? '' : 'disabled') .'>
                                            <i class="fas fa-download"></i>
                                        </button>
                                    </form>
                                </td>
                                <td>                                    
                                    <form action="redaktor.php" method="get">
                                        <span>'. $zamitnutych .'&nbsp;</span>
                                        <input type="hidden" name="stahni_zip" value="' . $cislo_c . '"/>
                                        <input type="hidden" name="tab" value="cisla-content"/>
                                        <input type="hidden" name="id_stav" value="6"/>
                                        <button type="submit" class="btn btn-secondary btn-sm" data-toggle="tooltip" title="Stáhnout zamítnuté články" '. ($zamitnutych > 0 ? '' : 'disabled') .'>
                                            <i class="fas fa-download"></i>
                                        </button>
                                    </form>
                                </td>
                                <td>                                    
                                    <form action="redaktor.php" method="get">
                                        <span>'. $celkem .'&nbsp;</span>
                                        <input type="hidden" name="stahni_zip" value="' . $cislo_c . '"/>
                                        <input type="hidden" name="tab" value="cisla-content"/>
                                        <input type="hidden" name="id_stav" value="0"/>
                                        <button type="submit" class="btn btn-secondary btn-sm" data-toggle="tooltip" title="Stáhnout všechny články související s číslem časopisu" '. ($celkem > 0 ? '' : 'disabled') .'>
                                            <i class="fas fa-download"></i>
                                        </button>
                                    </form>
                                </td>
                                <td>
                                    '. ($je_zverejneno ? '
                                        <a href="redaktor_sablona.php?cislo_casopisu=' . $cislo_c . '" 
                                            class="btn btn-primary btn-sm" 
                                            data-toggle="tooltip" 
                                            title="Tisková šablona pro vydavatele" 
                                        ">
                                            <i class="fas fa-newspaper"></i>&nbsp;Tisková šablona
                                        </a>
                                    ' : ' 
                                        <a href="redaktor_akce.php?cislo_casopisu=' . $cislo_c . '&akce=zverejnit&tab=cisla-content" 
                                            class="btn btn-info btn-sm '. ($prijatych > 0 ? '' : 'disabled') .'" 
                                            data-toggle="tooltip" 
                                            title="Zveřejnit všechny přijaté články v čísle časopisu" 
                                            onclick="return confirm(`'. ($je_pripraveno ? 'Opravdu chcete číslo časopisu zveřejnit?' : 'Některé články ve vybraném čísle ještě nejsou přijaté, opravdu chcete toto číslo časopisu zveřejnit? Články, které nejsou přijaté, nebudou moci být zveřejněny.') .'`);
                                        ">
                                            <i class="fas fa-share-square"></i>&nbsp;Zveřejnit
                                        </a>
                                    ') .'
                                </td>
                            </tr>';
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>

    </main>
    <?php include "footer.php" ?>

  </body>
</html>

<?php $conn -> close(); ?>
