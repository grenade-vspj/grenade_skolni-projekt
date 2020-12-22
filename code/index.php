<?php
require "conn.php";
require "opravneni.php";
require "functions.php";

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
  <?php include "head.php" ?>
  <body>

 <!--nucéné příhlášeni -->
 <?php if( $_SESSION['username']=="") {
     header("Location: prihlas.php");
     die();
 } ?>
<!--  -->

    <?php include "top.php" ?>

<p hidden> id uctu: <?php echo isset($_SESSION['id']) ? $_SESSION['id'] : ''; ?>     </p>
 <br>
přihlášen jako: <?php echo $_SESSION['username'];?>
 <br>
 prava: <?php echo $_SESSION['prava'];?>
 <br>
 <p hidden> zmena hesla: <?php isset($_SESSION['zmena']) ? $_SESSION['zmena'] : ''; ?> </p>


<!--opro změnu hesla po přihlšení -->
 <?php if( isset($_SESSION['zmena']) && $_SESSION['zmena']=="ANO") {
     header("Location: zmena.php");
     die();
 } ?>
<!--  -->

 <!-- redirect pro redaktora -->
  <?php if($_SESSION['prava']=="redaktor" && $_SESSION['cerstve_prihlaseni']==1) {
     header("Location: redaktor.php");
     die();
  } ?>

 <!-- redirect pro recenzenta -->
  <?php if($_SESSION['prava']=="recenzent" && $_SESSION['cerstve_prihlaseni']==1) {
     header("Location: recenzent.php");
     die();
  } ?>

<main role="main" class="container">

  <div class="starter-template">
    <h1>LOGOS POLYTECHNIKOS</h1>
    
  </div>
    <h2 class="mt-4">Vydané články</h2>
  
  <div class="row mb-3">
    <div class="col-md-8 themed-grid-col lichy">článek 1/2020</div>
    <div class="col-md-4 themed-grid-col lichy"><button type="button" class="btn btn-info">Otevřít</button></div>
    <div class="col-md-8 themed-grid-col">článek 2/2020</div>
    <div class="col-md-4 themed-grid-col"><button type="button" class="btn btn-info">Otevřít</button></div>    
	<div class="col-md-8 themed-grid-col lichy">článek 3/2020</div>
    <div class="col-md-4 themed-grid-col lichy"><button type="button" class="btn btn-info">Otevřít</button></div>
    <div class="col-md-8 themed-grid-col">článek 4/2020</div>
    <div class="col-md-4 themed-grid-col"><button type="button" class="btn btn-info">Otevřít</button></div>    
	<div class="col-md-8 themed-grid-col lichy">.článek 5/2020</div>
    <div class="col-md-4 themed-grid-col lichy"><button type="button" class="btn btn-info">Otevřít</button></div>
    <div class="col-md-8 themed-grid-col">článek 6/2020</div>
    <div class="col-md-4 themed-grid-col"><button type="button" class="btn btn-info">Otevřít</button></div>
	<div class="col-md-8 themed-grid-col lichy">.článek 5/2020</div>
    <div class="col-md-4 themed-grid-col lichy"><button type="button" class="btn btn-info">Otevřít</button></div>
    <div class="col-md-8 themed-grid-col">článek 6/2020</div>
    <div class="col-md-4 themed-grid-col"><button type="button" class="btn btn-info">Otevřít</button></div>
	<div class="col-md-8 themed-grid-col lichy">.článek 5/2020</div>
    <div class="col-md-4 themed-grid-col lichy"><button type="button" class="btn btn-info">Otevřít</button></div>
    <div class="col-md-8 themed-grid-col">článek 6/2020</div>
    <div class="col-md-4 themed-grid-col"><button type="button" class="btn btn-info">Otevřít</button></div>

  </div>

</main>

    <?php include "footer.php" ?>
  </body>
</html>

<?php $conn -> close(); ?>