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
    <h2 class="mt-4">Archiv</h2>
   
   



    <?php
    $query = "SELECT clanky.*, stav.nazev AS nazev_stav FROM clanky 
    INNER JOIN stav ON clanky.id_stav = stav.id ";
    $result = mysqli_query($conn, $query);     
    
    



      $vypsani = $conn->query("SELECT clanky.*, stav.nazev AS nazev_stav FROM clanky 
    INNER JOIN stav ON clanky.id_stav = stav.id ");
    while ($data = $vypsani->fetch_assoc()) {
      $id = $data['id_clanek'];
    $clanek = nejnovejsi_verze_clanku($conn, $id);
        }
    ?>

  
<div class="table-responsive" id="employee_table">  
                     <table class="table table-hover">  
                          <tr>  
                               <th><a class="column_sort" id="id" >ID</a></th>  
                               <th><a class="column_sort" id="autor" >autor</a></th>  
                               <th><a class="column_sort" id="nazev" >nazev článku</a></th>  
                               <th><a class="column_sort" id="stahnout" >stáhnout</a></th>  
                          </tr>  
                          <?php  
                          while($row = mysqli_fetch_array($result))  
                          {  
                          ?>  
                          <tr>  
                               <td><?php echo $row["id_clanek"]; ?></td>  
                               <td><?php echo $row["id_autor"]; ?></td>  
                               <td><?php echo $row["nazev"]; ?></td>  
                               <td>
                    <?php         
                                 
            echo '
            <a target="_blank" href="' . $clanek['cesta'] . '" class="btn btn-secondary btn-sm" data-toggle="tooltip" title="Stáhnout nejnovější verzi článku">
            <i class="fas fa-download"></i>
        </a>
        '
                            ?>
                               </td> 

                          </tr>  
                          <?php  
                          }  
                          ?>  
                     </table>  
                </div>  

 

</main>
    <?php include "footer.php" ?>
  </body>
</html>

<?php $conn -> close(); ?>