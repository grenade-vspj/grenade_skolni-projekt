<?php 
include "conn.php"; 
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
    <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
  <a class="navbar-brand" href="#"><img src="logo.jpg"></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarsExampleDefault">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="#">Časopis<span class="sr-only">(current)</span></a>
      </li>
	  <li class="nav-item">
        <a class="nav-link" href="#">Aktuality</a>
      </li>	  
	  <li class="nav-item">
        <a class="nav-link" href="#">Příští čísla</a>
      </li>	 	  
      <li class="nav-item">
        <a class="nav-link" href="#">VŠPJ</a>
      </li>
	  <li class="nav-item">
        <a class="nav-link" href="#">Sponzoři</a>
      </li>
	  <li class="nav-item">
        <a class="nav-link" href="#">Administrace</a>
      </li>
      

    </ul>
    <form class="form-inline my-2 my-lg-0">
      <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
      <button class="btn btn-secondary my-2 my-sm-0" type="submit"> Search </button>
	  <button class="btn btn-info" type="submit">Login</button>
    </form>
  </div>
</nav>



<main role="main" class="container">

  <div class="starter-template">
    <h1>LOGOS POLYTECHNIKOS</h1>
    
  </div>
    <h2 class="mt-4">Vydané články</h2>

    <div class="row mb-3">

    <?php 
    //Vypsání článků
    $vysledek = $mysqli->query("SELECT * FROM `clanky`");
    while ($data = $vysledek->fetch_assoc()) {
        $idClanku = $data['id_clanku'];
        $idAutor = $data['id_autor'];
        $nazev = $data['nazev'];
    ?>
    <div class="col-md-8 themed-grid-col lichy"><?php echo $nazev; ?></div>
    <div class="col-md-4 themed-grid-col lichy"><button type="button" class="btn btn-info">Otevřít</button></div>
    <?php } ?>

    </div>
  </div>

</main><!-- /.container -->

