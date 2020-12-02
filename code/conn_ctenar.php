<?php
include 'conn.php'; 


$name=$_POST['ctenar'];

//$s ="SELECT * FROM ma_prava
//INNER JOIN logos_login
//ON ma_prava.id = logos_login.id_login
//INNER JOIN prava
//ON ma_prava.id= prava.id_prava 
 //WHERE jmeno='$name'";
 $s ="SELECT * FROM ucet
 WHERE jmeno='$name'";

$result=mysqli_query($conn,$s);
$num =mysqli_num_rows($result);

//prava
$row = mysqli_fetch_array($result);
$prava=$row[5];

if ($num==1){
  $_SESSION['username']=$name;   
  $_SESSION['prava']=$prava;  
  header('location:index.php');
}else {
header('location:prihlas.php');
}


?>
