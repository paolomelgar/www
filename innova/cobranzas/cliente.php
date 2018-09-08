<?php
$con = mysqli_connect('localhost','root','','paolo');
mysqli_query ($con,"SET NAMES 'utf8'");
  if(isset($_POST) && !empty($_POST)){
    $search = explode(" ", $_POST['b']);
    $producto = "";
    foreach($search AS $s){
      $producto .= "concat(ruc,cliente) LIKE '%".mysqli_real_escape_string($con,$s)."%' AND ";
    }
    $producto = substr($producto, 0, -4);
    $query = "SELECT * FROM cliente WHERE $producto ORDER BY cliente LIMIT 10";
    $result=mysqli_query($con,$query);
    ?>
    <table width="60%" border="0" style="border-collapse: collapse;">
      <thead>
        <tr bgcolor="#428bca" style="color:#FFF; text-align:center;">
          <th width="10%" style='border: 1px solid black;'>RUC</th>
          <th width="30%" style='border: 1px solid black;'>CLIENTE</th>
          <th width="40%" style='border: 1px solid black;'>DIRECCION</th>
          <th width="5%" style='border: 1px solid black;'>CREDITO</th>
        </tr>
      </thead>
      <tbody id="tb" >
      <?php
      while($row=mysqli_fetch_assoc($result)){
      ?>
        <tr class="tr">
          <td width="10%" align="center" style='border: 1px solid black;'><?php echo $row['ruc']; ?></td>
          <td width="30%" align="center" style='border: 1px solid black;'><?php echo $row['cliente']; ?></td>
          <td width="40%" align="center" style='border: 1px solid black;'><?php echo $row['direccion']; ?></td>
          <td width="5%" align="center" style='border: 1px solid black;'><?php echo $row['credito']; ?></td>
        </tr>
      <?php
      }
      ?>
      </tbody>
    </table>
   <?php 
  }
?>