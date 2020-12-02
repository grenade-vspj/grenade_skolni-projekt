<nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
  <a class="navbar-brand" href="#"><img src="obr/logo.jpg" class="nav-logo"></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarsExampleDefault">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="./index.php">Časopis<span class="sr-only">(current)</span></a>
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
      <?php
        if (ma_opravneni_redaktora()) {
          echo '<li class="nav-item">
                    <a class="nav-link" href="./redaktor.php">Redaktor</a>
                </li>';
      }?>
      

    </ul>
    <form class="form-inline my-2 my-lg-0">
        <input class="form-control mr-sm-2" type="text" placeholder="Vyhledat" aria-label="Search">
        <button class="btn btn-secondary my-2 my-sm-0" type="submit"> Vyhledat </button>
        <?php
        if( $_SESSION['username']=="")
            echo '<a href="prihlas.php" class="btn btn-info ml-2">Přihlášení</a>';
        else
            echo '<a href="logout.php" class="btn btn-warning ml-2">Odhlášení</a>';
        ?>
    </form>

  </div>
</nav>