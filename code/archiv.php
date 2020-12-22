<?php
require "conn.php";
require "opravneni.php";
require "functions.php";
require "kontrola_prihlaseni.php";

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
                <th></th>
            </tr>
            </thead>
            <tbody>
                <?php
                    //vypsat
                    $vypsani = $conn->query("SELECT clanky.*, stav.nazev AS nazev_stav FROM clanky
                    INNER JOIN stav ON clanky.id_stav = stav.id 
                  
                    ORDER BY id_clanek DESC");
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

                        echo '
                                <td>' . $data['nazev'] . '</td>
                                <td data-toggle="tooltip" title="' . $autor['prihlas_jmeno'] . '">' . $autor['jmeno'] . ' ' . $autor['prijmeni'] . '</td>
                                <td><b>' . $data['cislo_casopisu'] . '</b></td>
                               
                                
                               
                               
                                <td><b>' . ' ' . '</b></td>
                                <td>
                                    <a target="_blank" href="' . $clanek['cesta'] . '" class="btn btn-secondary btn-sm" data-toggle="tooltip" title="Stáhnout nejnovější verzi článku">
                                        <i class="fas fa-download"></i>
                                    </a>
                                   
                                                     
                                </td>
                            </tr>';
                        echo ' <!-- Modal 1 -->
                            <div class="modal fade" id="modal1-' . $id . '">
                              <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                <div class="modal-content">
                                  -
                                    
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