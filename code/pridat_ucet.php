<?php  
 
 include 'conn.php';
 ?>


<!DOCTYPE html>  
 <html>  
      <head>  
           <title>pridani noveho uzivatele</title>  
           <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.18/datatables.min.css" />
  <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.18/datatables.min.js"></script>
    </head>  
      
    <body>  

    <form action="ucet.php" method="post" enctype="multipart/form-data">  

    <div class="form-group">
<input type="text" name="jmeno"  class="form-control" placeholder="jméno">
 </div>

 <div class="form-group">
<input type="text" name="prijmeni"  class="form-control" placeholder="příjmení">
 </div>

 <div class="form-group">
<input type="text" name="login"  class="form-control" placeholder="login">
 </div>

 <div class="form-group">
<input type="text" name="heslo"  class="form-control" placeholder="heslo">
 </div>

<!--
<//?php 
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
 <select name=zmena_hesla   class="form-control">
  <option value="ANO">ANO</option>
  <option value="NE">NE</option>
</select>
</div>


<div class="form-group">
 <input type="submit" name="add" class="btn btn-primary btn-block" value="pridat">
 </div>
 </form>


    </body>
    </html>
