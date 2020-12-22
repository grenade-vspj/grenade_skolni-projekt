<?php
    require_once "opravneni.php";
    require_once "functions.php";
?>

<nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
  <a class="navbar-brand" href="#"><img src="obr/logo.jpg" class="nav-logo"></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarsExampleDefault">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item <?php echo aktivni_zalozka('index.php'); ?>">
        <a class="nav-link" href="./index.php">Časopis</a>
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
      <li class="nav-item <?php echo aktivni_zalozka('aktualni_cislo.php'); ?>">
        <a class="nav-link" href="aktualni_cislo.php">Aktualní číslo</a>
      </li>
      <li class="nav-item <?php echo aktivni_zalozka('archiv.php'); ?>">
        <a class="nav-link" href="archiv.php">Archiv</a>
      </li>
      <?php
        if (ma_opravneni_autora()) {
            echo '<li class="nav-item '. aktivni_zalozka('autor.php') .'">
                    <a class="nav-link" href="./autor.php">Autor</a>
                </li>';
        }
        if (ma_opravneni_recenzenta()) {
            echo '<li class="nav-item '. aktivni_zalozka('recenzent.php') .'">
                    <a class="nav-link" href="./recenzent.php">Recenzent</a>
                </li>';
        }
        if (ma_opravneni_redaktora()) {
            echo '<li class="nav-item '. aktivni_zalozka('redaktor.php') .'">
                    <a class="nav-link" href="./redaktor.php">Redaktor</a>
                </li>';
        }
        if (ma_opravneni_admina()) {
            echo '<li class="nav-item '. aktivni_zalozka('sprava_uzivatelu.php') .'">
                    <a class="nav-link" href="./sprava_uzivatelu.php">Administrace</a>
                </li>';
        }
      ?>
      

    </ul>

    <form class="form-inline my-2 my-lg-0">
        <div class="navbar-text mr-3">
            <span hidden>ID účtu: <?php echo isset($_SESSION['id']) ? $_SESSION['id'] : ''; ?></span>
            <span class="mr-1">Uživatel: <?php echo isset($_SESSION['username']) ? $_SESSION['username'] : ''; ?></span>
            <span class="mr-1">/</span>
            <span>Oprávnění: <?php echo isset($_SESSION['prava']) ? $_SESSION['prava'] : ''; ?></span>
        </div>

        <input class="form-control mr-sm-2" type="text" placeholder="Vyhledat" aria-label="Search">
        <button class="btn btn-secondary my-2 my-sm-0 mr-3" type="submit"> Vyhledat </button>

        <?php
        if(je_uzivatel_prihlasen())
            echo '<a href="logout.php" class="btn btn-warning"><i class="fas fa-sign-out-alt"></i> Odhlášení</a>';
        else
            echo '<a href="prihlas.php" class="btn btn-info"><i class="fas fa-sign-in-alt"></i> Přihlášení</a>';
        ?>
    </form>

  </div>
</nav>