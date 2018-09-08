<?php
require_once('../connection.php');
  if(isset($_POST) && !empty($_POST)){
    $search = explode(" ", $_POST['b']);
    $producto = "";
    foreach($search AS $s){
      $producto .= "concat(proveedor,ruc) LIKE '%".mysqli_real_escape_string($con,$s)."%' AND ";
    }
    $producto = substr($producto, 0, -4);
    $query = "SELECT * FROM proveedor WHERE $producto ORDER BY proveedor LIMIT 10";
    $result=mysqli_query($con,$query);
    ?>
    <table width="70%" border="0" style="border-collapse: collapse;">
      <thead id="head">
        <tr bgcolor="#428bca" style="color:#FFF; text-align:center">
          <th width="10%" style='border: 1px solid black;'>RUC</th>
          <th width="30%" style='border: 1px solid black;'>PROVEEDOR</th>
          <th width="40%" style='border: 1px solid black;'>DIRECCION</th>
        </tr>
      </thead>
      <tbody id="tb" >
      <?php
      while($row=mysqli_fetch_assoc($result)){
      ?>
        <tr class="tr" bgcolor='white'>
          <td width="10%" align="center" style='border: 1px solid black;'><?php echo $row['ruc']; ?></td>
          <td width="30%" align="center" style='border: 1px solid black;'><?php echo $row['proveedor']; ?></td>
          <td width="40%" align="center" style='border: 1px solid black;'><?php echo $row['direccion']; ?></td>
        </tr>
      <?php
      }
      ?>
      </tbody>
    </table>
    <?php 
    }
?>