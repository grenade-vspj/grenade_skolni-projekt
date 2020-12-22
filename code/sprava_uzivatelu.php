<?php
 require 'conn.php';
 require "opravneni.php";
 require "functions.php";
 require "kontrola_prihlaseni.php";
 require "admin_private.php";

 //$query = "SELECT * FROM ma_prava     
// INNER JOIN logos_login
 //ON ma_prava.id_login = logos_login.id_login
//INNER JOIN prava
//ON ma_prava.id_prava= prava.id_prava 
 //ORDER BY ma_prava.id";
 $query = "SELECT * FROM ucet
 ORDER BY id";
 $result = mysqli_query($conn, $query);      

 ?>  

<!DOCTYPE html>  
 <html>
  <?php include "head.php" ?>
  <body>
    <?php include "top.php" ?>

    <a href="pridat_ucet.php"> <button type="button"  name="pridat_ucet"  class="btn btn-primary btn-block">přidat nového uživatele</button> </a>
    <a href="index.php"> <button type="button"   class="btn btn-primary btn-block">HOME PAGE</button> </a>
    <br />
           <div class="container" style="width:700px;" align="center">
                <h3 class="text-center">Přehled uživatelů</h3><br />



                <?php if(isset($_SESSION['response'])){ ?>
<div class="alert alert-<?= $_SESSION['res_type'];?> alert-dismissible text-center">
  <button type="button" class="close" data-dismiss="alert">&times;</button>
  <b> <?= $_SESSION['response']; ?> </b>
</div>
<?php } unset($_SESSION['response']);?>


                <!--priat seesion respo -->
                <div class="table-responsive" id="employee_table">  
                     <table class="table table-hover">  
                          <tr>  
                               <th><a class="column_sort" id="id" data-order="desc" href="#">ID</a></th>  
                               <th><a class="column_sort" id="prihlas_jmeno" data-order="desc" href="#">login</a></th>  
                               <th><a class="column_sort" id="jmeno" data-order="desc" href="#">jmeno</a></th>  
                               <th><a class="column_sort" id="prijmeni" data-order="desc" href="#">prijmeni</a></th>       
                               <th><a class="column_sort" id="prava" data-order="desc" href="#">prava</a></th>
                               <th></th>
                          </tr>  
                          <?php  
                          while($row = mysqli_fetch_array($result))  
                          {  
                          ?>  
                          <tr>  
                               <td><?php echo $row["id"]; ?></td>  
                               <td><?php echo $row["prihlas_jmeno"]; ?></td>  
                               <td><?php echo $row["jmeno"]; ?></td>  
                               <td><?php echo $row["prijmeni"]; ?></td>  
                               <td><?php echo $row["prava"]; ?></td>  
                               <td>
                                    <a href="detail.php?detail=<?= $row['id'];?>" class=" badge badge-primary p-2">edit</a> |
                                    <a href="ucet.php?delete=<?= $row['id']; ?>" class=" badge badge-danger p-2" onclick="return confirm('Opravdu chcete tento záznam smazat?');" >vymaž</a>
                               </td>
                          </tr>  
                          <?php  
                          }  
                          ?>  
                     </table>  
                </div>  
           </div>  
           <br />
        <?php include "footer.php" ?>
      </body>
 </html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.18/datatables.min.css" />
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.18/datatables.min.js"></script>
 <script>  
 $(document).ready(function(){  
      $(document).on('click', '.column_sort', function(){  
           var column_name = $(this).attr("id");  
           var order = $(this).data("order");  
           var arrow = '';  
           //glyphicon glyphicon-arrow-up  
           //glyphicon glyphicon-arrow-down  
           if(order == 'desc')  
           {  
                arrow = '&nbsp;<span class="glyphicon glyphicon-arrow-down"></span>';  
           }  
           else  
           {  
                arrow = '&nbsp;<span class="glyphicon glyphicon-arrow-up"></span>';  
           }  
           $.ajax({  
                url:"sort.php",  
                method:"POST",  
                data:{column_name:column_name, order:order},  
                success:function(data)  
                {  
                     $('#employee_table').html(data);  
                     $('#'+column_name+'').append(arrow);  
                }  
           })  
      });  
 });  
 </script>

<?php $conn -> close(); ?>