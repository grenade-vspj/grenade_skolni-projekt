<?php
session_start();
if(!isset($_SESSION['username'])){
header('location:index.php');
include 'action.php';
}
?>

<!DOCTYPE html>
<html lang="cs">
<head>
<title>HOME PAGE</title>
  <link rel="stylesheet" type="text/css" href="./css/styl_home.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.18/datatables.min.css" />
  <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.18/datatables.min.js">
  </script>
</head>
<body>


<nav class="navbar navbar-expand-md bg-dark navbar-dark">
  <a class="navbar-brand" href="#">MENU</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="collapsibleNavbar">
    <ul class="navbar-nav ">
      <li class="nav-item">
        <a class="nav-link" href="#">JEDNA</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">DVA</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">TRI</a>
      </li>
    </ul>
  </div>
  <form class="form-inline" action="/action_page.php">
    <input class="form-control mr-sm-2" type="text" placeholder="název">
    <button class="btn btn-primary" type="submit">hledej</button>
  </form>
</nav>

přihlášen jako: <?php echo $_SESSION['username'];?>
<br>
<a href="logout.php">ODHLÁSIT</a>






</body>
</html>
