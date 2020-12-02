<?php
 include 'conn.php';

 //$query = "SELECT * FROM ma_prava     
//INNER JOIN logos_login
 //ON ma_prava.id_login = logos_login.id_login
//INNER JOIN prava
//ON ma_prava.id_prava= prava.id_prava";
 //$result = mysqli_query($conn, $query);    
 //$row = mysqli_fetch_array($result);

 $id=$_SESSION['id'];
 $query = "SELECT * FROM ucet WHERE id='$id'";
 $result = mysqli_query($conn, $query);    
 $row = mysqli_fetch_array($result);
 ?>


<!DOCTYPE html>  
 <html>  
      <head>  
           <title>zmena udaju</title>  
           <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.18/datatables.min.css" />
  <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.18/datatables.min.js"></script>
    </head>  
      
    <body>  


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
  <option value="admin">admin</option>
  <option value="ctenar">ctenar</option>
  <option value="autor">autor</option>
  <option value="recenzent">recenzent</option>
  <option value="redakcni_rada">redakcni_rada</option>
  <option value="redaktor">redaktor</option>
  <option value="sef_redaktor">sef_redaktor</option>
</select>
</div>

změna hesla po přilaseni
<div class="form-group">
 <select name=zmenahesla   class="form-control">
  <option value="ANO">NE</option>
  <option value="NE">ANO</option>
</select>
</div>

<div class="form-group">
 <input type="submit" name="detail" class="btn btn-warning btn-block" value="uloz zmeny">
 </div>
 </form>
    


    </body>
    </html>
