<?php
require "conn.php";
require "kontrola_prihlaseni.php";
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
    <?php include "top.php" ?>

<main role="main" class="container">

  <div class="starter-template">
    <h1>LOGOS POLYTECHNIKOS</h1>
    
  </div>
    <h2 class="mt-4">Vydané články</h2>
  
  <div class="row mb-3">

      <h5>Termíny uzávěrek pro sběr příspěvků:<br /><br /></h5>
      <ul>
          <li>1/2020 - ošetřovatelství, porodní asistence a další zdravotnické obory (31. 12. 2019)</li>
          <li>2/2020 - ošetřovatelství, porodní asistence a další zdravotnické obory, sociologie, sport, psychologie, sociální práce (30. 4. 2020)</li>
          <li>3/2020 - ekonomika, management, marketing, statistika, operační výzkum, finanční matematika, pojišťovniství, cestovní ruch, regionální rozvoj, veřejná správa (31. 8. 2020)</li>
      </ul>
      <p>Pokud rozsah doručených příspěvků překročí kapacitu příslušného vydání, bude přijímání příspěvků ukončeno před uvedeným termínem.</p>
      
  </div>

</main>

    <?php include "footer.php" ?>
  </body>
</html>

<?php $conn -> close(); ?>