<?php
require_once('../connection.php');
  if(isset($_POST) && !empty($_POST)){
    $search = explode(" ", $_POST['b']);
    $producto = "";
    foreach($search AS $s){
      $producto .= "concat(ruc,proveedor) LIKE '%".mysqli_real_escape_string($con,$s)."%' AND ";
    }
    $producto = substr($producto, 0, -4);
    $query = "SELECT * FROM proveedor WHERE $producto AND activo!='ANULADO' ORDER BY proveedor LIMIT 10";
    $result=mysqli_query($con,$query);
    ?>
    
      <?php
      while($row=mysqli_fetch_assoc($result)){
      ?>
        <tr class="tr">
          <td style='text-align:center'><?php echo $row['ruc']; ?></td>
          <td style='text-align:left'><?php echo $row['proveedor']; ?></td>
          <td style='text-align:left'><?php echo $row['direccion']; ?></td>
        </tr>
      <?php
      }
  }
?>