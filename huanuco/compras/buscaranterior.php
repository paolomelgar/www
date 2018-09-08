<?php
require_once('../connection.php');
    if(isset($_POST) && !empty($_POST)){
      $sql=mysqli_query($con,"SELECT * FROM compras WHERE idproducto='".$_POST['id']."' AND entregado='SI' ORDER BY id DESC LIMIT 6");
?>
<table width="100%" align="center" style="font-size:12px;" id='listanterior'>
      <thead>
        <tr style="background-color:yellow;text-align:center">
          <th width="12%">COMPROBANTE</th>
          <th width="8%">FECHA</th>
          <th width="14%">PROVEEDOR</th>
          <th width="6%">CANTIDAD</th>
          <th width="40%">PRODUCTO</th>
          <th width="6%">PRECIO</th>
          <th width="8%">IMPORTE</th>
          <th width="6%">CAM</th>
        </tr>
      </thead>
      <tbody id="compranterior" style='font-weight:bold'>
        <?php
        if(mysqli_num_rows($sql)>0){
          while($row=mysqli_fetch_assoc($sql)){
          ?>
          <tr bgcolor="#FBEFEF">
          <td align="center"><?php echo $row['documento']; ?></td>
          <td walign="center"><?php echo date('d/m/Y', strtotime(str_replace('-', '/', $row['fecha']))); ?></td>
          <td><?php echo substr($row['proveedor'],0,20); ?></td>
          <td align="center"><?php echo $row['cantidad']; ?></td>
          <td><?php echo $row['producto']; ?></td>
          <?php if($row['billete']=='SOLES'){ ?>
          <td align="right" style='color:blue;font-weight:bold;'><?php echo "S/ ".$row['unitario']; ?></td>
          <td align="right" style='color:blue;font-weight:bold;'><?php echo "S/ ".$row['importe']; ?></td>
          <td align="center"></td>
          <?php }
          else{ ?>
          <td align="right" style='color:green;font-weight:bold;'><?php echo "$ ".$row['unitario']; ?></td>
          <td align="right" style='color:green;font-weight:bold;'><?php echo "$ ".$row['importe']; ?></td>
          <td align="center"><?php echo $row['cambio']; ?></td>
          <?php } ?>
        </tr>
          <?php
          }
        }else{?>
          <tr bgcolor="#FBEFEF">
            <td align="center" style='color:red' colspan='7'>NO SE REALIZO COMPRAS DE ESTE PRODUCTO</td>
          </tr>
        <?php
      }
   ?>
   </tbody>
   </table>
  <?php 
  }
?>