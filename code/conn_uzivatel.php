<?php
include 'conn.php'; 


$name=$_POST['user'];
$pass=$_POST['password'];

//$s ="SELECT * FROM ma_prava         stara tabulka
//INNER JOIN logos_login
//ON ma_prava.id_login = logos_login.id_login
//INNER JOIN prava
//ON ma_prava.id_prava= prava.id_prava 
 //WHERE jmeno='$name' AND heslo='$pass'";
 
 $s ="SELECT * FROM ucet
 WHERE prihlas_jmeno='$name' AND heslo='$pass'";

$result=mysqli_query($conn,$s);
$num =mysqli_num_rows($result);


//prava
$row = mysqli_fetch_array($result);
$prava=$row[5];

//zmena_hesla             
//$row = mysqli_fetch_array($result);
$zmena=$row[6];
// id z tabulky ucet
$id=$row[0];



//zme


if ($num==1){   
  $_SESSION['id']=$id; 
  $_SESSION['username']=$name;   
  $_SESSION['prava']=$prava;  
  $_SESSION['zmena']=$zmena;

  $_SESSION['cerstve_prihlaseni']=1;

  header('location:index.php');
}else {
header('location:prihlas.php');
}


?>
