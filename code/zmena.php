<?php  
  session_start();
 include 'conn.php';  
 $id=$_SESSION['id'];

 $query = "SELECT * FROM ucet
 WHERE  id='$id'";
 $result = mysqli_query($conn, $query); 
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


<h1>zmena heslo pro uzivatele </h1>
id uctu: <?php echo $_SESSION['id'];?>
 <br>
přihlášen jako: <?php echo $_SESSION['username'];?>

<div class="form-group">
<input type="text" name="heslo"  class="form-control" placeholder="nové heslo">
 </div>

 
</body> 
</html> 