<?php
  require_once('../connection.php');
  if(isset($_POST) && !empty($_POST['cliente'])){
    $query="cliente='".$_POST['cliente']."' AND id='".$_POST['id']."' AND entregado='SI'";
    $sql=mysqli_query($con,"SELECT * FROM notapedido WHERE $query UNION SELECT * FROM proforma WHERE $query UNION SELECT * FROM boleta WHERE $query UNION SELECT * FROM facturapaola WHERE $query ORDER BY fecha DESC LIMIT 3");
?>
    <table width="100%" align="center" style="font-size:13px;" id='listanterior'>
      <thead>
        <tr style="background-color:yellow;text-align:center">
          <th width="12%">COMPROBANTE</th>
          <th width="12%">FECHA</th>
          <th width="5%">CANT</th>
          <th width="30%">PRODUCTO</th>
          <th width="6%">PRECIO</th>
          <th width="7%">IMPORTE</th>
          <th width="15%">VENDEDOR</th>
        </tr>
      </thead>
      <tbody id="compranterior" style='font-weight:bold'>
        <?php
        if(mysqli_num_rows($sql)>0){
          while($row=mysqli_fetch_assoc($sql)){
          ?>
          <tr bgcolor="#FBEFEF">
            <td align="center"><?php echo $row['documento']; ?></td>
            <td align="center"><?php echo date('d/m/Y', strtotime(str_replace('-', '/', $row['fecha'])))." - ".$row['hora']; ?></td>
            <td align="center"><?php echo $row['cantidad']; ?></td>
            <td><?php echo $row['producto']; ?></td>
            <td align="right"><?php echo $row['unitario']; ?></td>
            <td align="right"><?php echo $row['importe']; ?></td>
            <td align="center"><?php echo $row['vendedor']; ?></td>
          </tr>
          <?php
          }
        }else{?>
          <tr bgcolor="#FBEFEF">
            <td align="center" style='color:red' colspan='7'><?php echo $_POST['cliente']; ?> NO REALIZO COMPRAS DE ESTE PRODUCTO</td>
          </tr>
        <?php
      }
   ?>
   </tbody>
   </table>
   </div>
   <?php 
  }
?>