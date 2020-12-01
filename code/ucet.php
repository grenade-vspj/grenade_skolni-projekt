<?php
session_start();
include 'conn.php';

if(isset($_POST['add'])){

  //  $sk_jmeno=$_POST['sk_jmeno'];
    //$sk_prijmeni=$_POST['sk_prijmeni'];
    //$login=$_POST['login'];
    //$heslo=$_POST['heslo'];
    //$prava=$_POST['prava'];   // id prava
    //$zmena_hesla=$_POST['zmena_hesla'];   


    $jmeno=$_POST['jmeno'];
    $prijmeni=$_POST['prijmeni']; 
    $login=$_POST['login'];
    $heslo=$_POST['heslo'];
    $prava=$_POST['prava'];
    $zmena_hesla=$_POST['zmena_hesla'];

   // $query="INSERT INTO logos_login(sk_jmeno,sk_prijmeni,jmeno,heslo,zmena_hesla)
    //VALUES(?,?,?,?,?)";
    //$stmt=$conn->prepare($query);
    //$stmt->bind_param("sssss",$sk_jmeno,$sk_prijmeni,$login,$heslo,$zmena_hesla);
    //$stmt->execute();


    $query="INSERT INTO ucet(jmeno,prijmeni,prihlas_jmeno,heslo,prava,zmena_hesla)
    VALUES(?,?,?,?,?,?)"; 
    $stmt=$conn->prepare($query);
    $stmt->bind_param("ssssss",$jmeno,$prijmeni,$login,$heslo,$prava,$zmena_hesla);
    $stmt->execute();


    // dotaz na id_login 
    //$id_login="SELECT id_login FROM logos_login
    //WHERE sk_jmeno like'%$sk_jmeno%' 
    //AND sk_prijmeni like'%$sk_prijmeni%'
    //AND jmeno like'%$login%'";
    
      //  $result = mysqli_query($conn,$id_login);
        //$row = mysqli_fetch_array($result);
        //$id=$row[0];

    // pridat prava pro dany ucet
    //$query="INSERT INTO ma_prava(id_login,id_prava)
    //VALUES(?,?)";
    //$stmt=$conn->prepare($query);
    //$stmt->bind_param("ss",$id,$prava);
    //$stmt->execute();


    header('location:sprava_uzivatelu.php');
    $_SESSION['response']="ULOŽENO";
    $_SESSION['res_type']="success";
}

if(isset($_GET['delete'])){
    $id=$_GET['delete'];
    
   

// dotaz na id_login 
//$id_login="SELECT * FROM ma_prava WHERE id=?";

  //  $result = mysqli_query($conn,$id_login);
    //$row = mysqli_fetch_array($result);
    //$id_ucet=$row[1]; //index prvku
    
    

    //smaze z tabulky logos_login     nefunguje nejde  $id_ucet pretypovat na inr
    //$query="DELETE FROM logos_login WHERE id_login='$id_ucet'"; 
    //$stmt=$conn->prepare($query);
    //$stmt->bind_param("i",$id_ucet);
    //$stmt->execute();

    //smaze z tabulky ma prava 
   // $query="DELETE FROM ma_prava WHERE id=?"; 
   // $stmt=$conn->prepare($query);
   // $stmt->bind_param("i",$id);
    //$stmt->execute();

    $query="DELETE FROM ucet WHERE id=?"; 
    $stmt=$conn->prepare($query);
    $stmt->bind_param("i",$id);
    $stmt->execute();


    header('location:sprava_uzivatelu.php');
    $_SESSION['response']="SMAZÁNO";
    $_SESSION['res_type']="danger";
}

if(isset($_POST['detail'])){    
    //$id=$_POST['detail'];
    $id=$_SESSION['id'];
    
    $jmeno=$_POST['jmeno'];
    $prijmeni=$_POST['prijmeni']; 
    $login=$_POST['prihlasjmeno'];
    $heslo=$_POST['heslo'];
    $prava=$_POST['prava'];
    $zmenahesla=$_POST['zmenahesla'];

    $sql="UPDATE ucet 
    SET jmeno='$jmeno',
    prijmeni='$prijmeni',
     prihlas_jmeno='$login',
     heslo='$heslo',
     prava='$prava',
     zmena_hesla='$zmenahesla'
     WHERE id='$id'";


    $stmt = $conn->prepare($sql);
    $stmt->execute();

   header('location:sprava_uzivatelu.php');
    $_SESSION['response']="UPRAVENO";
    $_SESSION['res_type']="danger";  

}

if(isset($_POST['prepis'])){
  $zmena=$_POST['heslo'];
  $id=$_SESSION['id'];
  $sql="UPDATE ucet SET heslo='$zmena',
  zmena_hesla='NE' WHERE id='$id'";

 // $stmt=$conn->prepare($query);
  //$stmt->bind_param("sss",$zmena,'NE',1);
  //$stmt->execute();

    $stmt = $conn->prepare($sql);
    $stmt->execute();
  
    $_SESSION['zmena']="NE";
  header('location:index.php');
}
?>
