<?php
 require 'conn.php';
 require "opravneni.php";
 require "functions.php";
 require "kontrola_prihlaseni.php";

 $id=$_SESSION['id'];

 $query = "SELECT * FROM ucet
 WHERE  id='$id'";
 $result = mysqli_query($conn, $query); 
 ?>

 
<!DOCTYPE html>  
 <html>
    <?php include "head.php" ?>
    <body>
        <?php include "top.php" ?>
        <main role="main" class="container">
            <h3 class="text-center">Změna hesla pro uživatele</h3><br/>

id uctu: <?php echo $_SESSION['id'];?>
 <br>
přihlášen jako: <?php echo $_SESSION['username'];?>

<form action="ucet.php" method="post"  enctype="multipart/form-data">  
   

<div class="form-group">
<input type="text" name="heslo"  class="form-control" placeholder="nové heslo">
</div>

 <div class="form-group">
 <input type="submit" name="prepis" class="btn btn-warning btn-block" value="uloz zmeny">
 </div>
 

 </form>

    </main>
    <?php include "footer.php" ?>
</body> 
</html>
<?php $conn -> close(); ?>