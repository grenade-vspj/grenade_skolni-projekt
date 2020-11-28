<?php
session_start();
include 'conn.php'; 


$name=$_POST['user'];
$pass=$_POST['password'];

$s ="SELECT * FROM ma_prava
INNER JOIN logos_login
ON ma_prava.id_login = logos_login.id_login
INNER JOIN prava
ON ma_prava.id_prava= prava.id_prava 
 WHERE jmeno='$name' AND heslo='$pass'";

$result=mysqli_query($conn,$s);
$num =mysqli_num_rows($result);


//prava
$row = mysqli_fetch_array($result);
$prava=$row[10];

//zmena_hesla             
$row = mysqli_fetch_array($result);
$zmena_hesla=$row[8];


if ($num==1){    // pozor pokud dotaz vrati vice row stane to v pripade když je v dotazu stejne jmeno a heslo (v bežném připadě se to nestane )
  $_SESSION['username']=$name;   
  $_SESSION['prava']=$prava;  
  $_SESSION['zmena_hesla']=$zmena_hesla;     
  header('location:home.php');
}else {
header('location:prihlas.php');
}


?>
