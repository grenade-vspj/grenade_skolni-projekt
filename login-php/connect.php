<?php
session_start();
$servername = "localhost";
$username = "matias02";
$password = "*Mat1462";
$dbname = "matias02";
$con = mysqli_connect($servername, $username, $password, $dbname);
 mysqli_set_charset($con, "utf8");

$name=$_POST['user'];
$pass=$_POST['password'];


$s = "SELECT * FROM logos_login WHERE jmeno='$name' && heslo='$pass'";
$result=mysqli_query($con,$s);
$num =mysqli_num_rows($result);

if ($num==1) {
  $_SESSION['username']=$name;
  header('location:home.php');
}
else  {
header('location:index.php');
}

?>
