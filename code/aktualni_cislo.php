<?php
require "conn.php";
require "opravneni.php";
require "functions.php";
//require "redaktor_private.php";
include "head.php";



$uri = $_SERVER['REQUEST_URI'];
$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
if (strpos($url, 'index.php')) {
    $url = str_replace('index.php', '', $url);
}
if (substr($url, -1) !== '/') {
    $url = $url.'/';
}

?>

<!doctype html>
<html lang="en">
  <head>
 
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Grenade">
    <meta name="generator" content="">
    <title>LOGOS POLYTECHNIKOS</title>
    <link rel="shortcut icon" href="obr/favicon.ico" type="image/x-icon">

    

    <!-- Bootstrap core CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
	 
    </style>
    <!-- Custom styles for this template -->
    <link href="styles.css" rel="stylesheet">
  </head>
  <body>

 <!--nucéné příhlášeni -->
 <?php if( $_SESSION['username']=="") {
   echo '<script>
            window.location.href="' . $url .'prihlas.php";
        </script>';
 } ?>
<!--  -->

    <?php include "top.php" ?>

<p hidden> id uctu: <?php echo $_SESSION['id'];?>     </p> 
 <br>
přihlášen jako: <?php echo $_SESSION['username'];?>
 <br>
 prava: <?php echo $_SESSION['prava'];?>
 <br>
 <p hidden> zmena hesla: <?php echo $_SESSION['zmena'];?> </p> 
 <br>
 <a href="logout.php">ODHLÁSIT</a>


<!--opro změnu hesla po přihlšení -->
 <?php if( $_SESSION['zmena']=="ANO") {
     echo '<script>
            window.location.href="' . $url .'zmena.php";
          </script>';
 } ?>
<!--  -->

 <!-- redirect pro redaktora
  <?php if($_SESSION['prava']=="redaktor" && $_SESSION['cerstve_prihlaseni']==1) {
     header("Location: redaktor.php");
     die();
  }
 ?>

 <!-- redirect pro recenzenta
  <?php if($_SESSION['prava']=="recenzent"){
     header("Location: recenzent.php");
     die(); }
 ?>
 
 <br>
<!-- pouze pro admina,sprava uctu-->
 <?php if( $_SESSION['username']=="admin"){ ?>
 <a href="sprava_uzivatelu.php"> <button class="btn btn-info" type="submit">admin sprava</button>  </a>
 <?php } ?>
<!-- -->

<main role="main" class="container">

  <div class="starter-template">
    <h1>LOGOS POLYTECHNIKOS</h1>
    
  </div>
    <h2 class="mt-4">Aktuální číslo</h2>
   
    <?php
    // dotaz na nejnovější článek najdeho po nejvyšího id_clanek
    // SELECT clanky.*, stav.nazev AS nazev_stav FROM clanky 
    //INNER JOIN stav ON clanky.id_stav = stav.id  
    //ORDER BY id_clanek DESC LIMIT 0, 1

    $query = "SELECT clanky.*, stav.nazev AS nazev_stav FROM clanky 
    INNER JOIN stav ON clanky.id_stav = stav.id 
    ORDER BY id_clanek DESC LIMIT 0, 1";
    $result = mysqli_query($conn, $query);     
    
    



      $vypsani = $conn->query("SELECT clanky.*, stav.nazev AS nazev_stav FROM clanky 
    INNER JOIN stav ON clanky.id_stav = stav.id 
    ORDER BY id_clanek DESC LIMIT 0, 1");
    while ($data = $vypsani->fetch_assoc()) {
      $id = $data['id_clanek'];
    $clanek = nejnovejsi_verze_clanku($conn, $id);
        }
    ?>






  <!--priat seesion respo -->
  <div class="table-responsive" id="employee_table">  
                     <table class="table table-hover">  
                          <tr>  
                               <th><a class="column_sort" id="id" >ID</a></th>  
                               <th><a class="column_sort" id="autor" >autor</a></th>  
                               <th><a class="column_sort" id="nazev" >nazev</a></th>  
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









  
 

</main><!-- /.container -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
      <script>window.jQuery || document.write('<script src="../assets/js/vendor/jquery.slim.min.js"><\/script>')</script><script src="../assets/dist/js/bootstrap.bundle.min.js"></script>
<footer class="footer mt-auto py-3">
  <div class="container">
    <span class="text-muted">Created by @teamGrenade</span>
  </div>
</footer>
  </body>
</html>

<?php $conn -> close(); ?>