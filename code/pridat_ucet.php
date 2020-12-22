<?php
 require 'conn.php';
 require "opravneni.php";
 require "functions.php";
 require "kontrola_prihlaseni.php";
 require "admin_private.php";
 ?>


<!DOCTYPE html>  
 <html>
    <?php include "head.php" ?>
    <body>
        <?php include "top.php" ?>
        <main role="main" class="container">
            <h3 class="text-center">Přidat nového uživatele</h3><br/>

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
Práva
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

Změna hesla po přihlášení
<div class="form-group">
 <select name=zmena_hesla   class="form-control">
  <option value="ANO">ANO</option>
  <option value="NE">NE</option>
</select>
</div>


<div class="form-group">
 <input type="submit" name="add" class="btn btn-primary btn-block" value="Přidat">
 </div>
 </form>
        </main>
        <?php include "footer.php" ?>
    </body>
    </html>

<?php $conn -> close(); ?>