<?php
include 'conn.php';
?>



<!DOCTYPE html>
<html lang="cs">
<head>
    <META CHARSET="UTF-8">
<title>Přihlášení</title>
<link rel="stylesheet" type="text/css" href="./styl_login.css">

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.18/datatables.min.css" />
  <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.18/datatables.min.js"></script>



</head>

<body>

<div class="loginbox">
<img src="./obr/hlava.png" class="logo">
<h1>PŘIHLÁŠENÍ</h1>
<form action="conn_uzivatel.php" method="post">
<p>JMÉNO</p>
<input type="text" name="user" class="form-control" placeholder="zadej jméno" required>
<p>HESLO</p>
<input type="password" name="password" class="form-control" placeholder="zadej heslo" required>
<input type="submit" name="ucet" value="vstoupit jako člen redakce" class="btn btn-danger btn-block">
</form>

<!-- ctenar-->
<form action="conn_ctenar.php" method="post">
<button type="submit" name="ctenar" value="ctenar" class="btn btn-success btn-block">vstoupit jako čtenář </button>
</form>


</div>

</body>


</html>

<?php $conn -> close(); ?>
