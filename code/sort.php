<?php  
  
 include 'conn.php';
 $output = '';  
 $order = $_POST["order"];  
 if($order == 'desc')  
 {  
      $order = 'asc';  
 }  
 else  
 {  
      $order = 'desc';  
 }  
 //$query = "SELECT * FROM ma_prava     
 //INNER JOIN logos_login
 //ON ma_prava.id = logos_login.id_login 
 //INNER JOIN prava
 //ON ma_prava.id = prava.id_prava
 
 $query = "SELECT * FROM ucet
 ORDER BY ".$_POST["column_name"]." ".$_POST["order"]."";  
 $result = mysqli_query($conn, $query);  
 $output .= '  
 <table class="table table-hover">  
      <tr>  
           <th><a class="column_sort" id="id" data-order="'.$order.'" href="#">ID</a></th>  
           <th><a class="column_sort" id="prihlas_jmeno" data-order="'.$order.'" href="#">login</a></th>  
           <th><a class="column_sort" id="jmeno" data-order="'.$order.'" href="#">jmeno</a></th>  
           <th><a class="column_sort" id="prijmeni" data-order="'.$order.'" href="#">prijmeni</a></th>  
           <th><a class="column_sort" id="prava" data-order="'.$order.'" href="#">prava</a></th>  
           <th></th>
      </tr>  
 ';  
 while($row = mysqli_fetch_array($result))  
 {  
      $output .= '  
      <tr>  
           <td>' . $row["id"] . '</td>  
           <td>' . $row["prihlas_jmeno"] . '</td>  
           <td>' . $row["jmeno"] . '</td>  
           <td>' . $row["prijmeni"] . '</td>  
           <td>' . $row["prava"] . '</td>  
           <td>
              <a href="detail.php?detail='. $row['id'] .'" class=" badge badge-primary p-2">edit</a> |
              <a href="ucet.php?delete='. $row['id'] .'" class=" badge badge-danger p-2" onclick="return confirm(`Opravdu chcete tento záznam smazat?`);" >vymaž</a> 
           </td> 
      </tr>  
      ';  
 }  
 $output .= '</table>';  
 echo $output;  
 ?>

<?php $conn -> close(); ?>