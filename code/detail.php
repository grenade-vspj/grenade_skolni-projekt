<?php
 require 'conn.php';
 require "opravneni.php";
 require "functions.php";
 require "kontrola_prihlaseni.php";
 require "admin_private.php";

 //$query = "SELECT * FROM ma_prava     
//INNER JOIN logos_login
 //ON ma_prava.id_login = logos_login.id_login
//INNER JOIN prava
//ON ma_prava.id_prava= prava.id_prava";
 //$result = mysqli_query($conn, $query);    
 //$row = mysqli_fetch_array($result);

 $id=$_GET['detail'];
 if (empty($id)) {
    header("Location: sprava_uzivatelu.php");
    exit();
 }
 $query = "SELECT * FROM ucet WHERE id='$id'";
 $result = mysqli_query($conn, $query);    
 $row = mysqli_fetch_array($result);
 ?>


<!DOCTYPE html>  
 <html>
    <?php include "head.php" ?>
    <body>
        <?php include "top.php" ?>
        <main role="main" class="container">
            <h3 class="text-center">Změna údajů uživatele</h3><br/>

<form action="ucet.php" method="post"  enctype="multipart/form-data">  
    <div class="form-group">
    
    jmeno
<input type="text" name="jmeno" value="<?php echo $row[3]; ?>" class="form-control" placeholder="jméno">
 </div> 
prijmeni
 <div class="form-group">
<input type="text" name="prijmeni" value="<?php echo $row[4]; ?>" class="form-control" placeholder="příjmení">
 </div>

login
 <div class="form-group">
<input type="text" name="prihlasjmeno" value="<?php echo $row[1]; ?>" class="form-control" placeholder="login">
 </div>

heslo
 <div class="form-group">
<input type="text" name="heslo" value="<?php echo $row[2]; ?>" class="form-control" placeholder="heslo">
 </div>


<!--<//?php 

//$sql = "SELECT id_prava,typ_uctu FROM prava";
//$result = mysqli_query($conn, $sql);
?>
prava
<div class="form-group">
<select  name="prava" class="form-control"> 
<//?php while($row1 = mysqli_fetch_array($result)):;?>
<option value="<//?php echo $row1[0]; ?>"><//?php echo $row1[1];?>   </option>
<//?php endwhile;?>
</select>
</div>
-->

prava
<div class="form-group">
 <select name=prava   class="form-control">
     <?php
     $prava_hodnoty = array("admin", "ctenar", "autor", "recenzent", "redakcni_rada", "redaktor", "sef_redaktor");
     foreach ($prava_hodnoty as $pravo) {
         echo '<option value="'. $pravo .'" '. ($row[5] == $pravo ? 'selected' : '') .'>'. $pravo .'</option>';
     }
     ?>
</select>
</div>

změna hesla po přihlášení
<div class="form-group">
 <select name=zmenahesla   class="form-control">
     <?php
        $zmena_hodnoty = array("ANO", "NE");
        foreach ($zmena_hodnoty as $zmena) {
            echo '<option value="'. $zmena .'" '. ($row[6] == $zmena ? 'selected' : '') .'>'. $zmena .'</option>';
        }
     ?>
</select>
</div>

<div class="form-group">
    <input type="hidden" name="id" value="<?php echo $id ?>"/>
 <input type="submit" name="detail" class="btn btn-warning btn-block" value="uloz zmeny">
 </div>
 </form>

        </main>
        <?php include "footer.php" ?>
    </body>
    </html>

<?php $conn -> close(); ?>