<?php
  require_once('../connection.php');
      $sql=mysqli_query($con,"SELECT * FROM total_pedido WHERE entregado='NO' ORDER BY hora,fecha");
?>
    <table width="100%" cellpadding="0" cellspacing="0" border="1" align="center">
      <thead>
        <tr bgcolor="#1c94c4" style="color:#FFF;height:30px; text-align:center;font-size:13px;font-weight:bold">
          <th width="20%">VENDEDOR</th>
          <th width="15%">FECHA</th>
          <th width="35%">CLIENTE</th>
          <th width="12%">TOTAL</th>
        </tr>
      </thead>
    </table>
  <div style="overflow:auto;height:350px;align:center">
    <table width="100%" cellpadding="0" cellspacing="0" border="1" align="center">
      <tbody id="listpendientes">
        <?php
        while($row=mysqli_fetch_assoc($sql)){
        ?>
        <tr bgcolor="#FBEFEF" style="font-size:13px;font-weight:bold;height:50px" class='buscar'>
          <td width="12%" align="center" style="display:none"><?php echo $row['seriepedido']; ?></td>
          <td width="20%" align="center"><?php echo $row['vendedor']; ?></td>
          <td width="15%" align="center"><?php echo $row['fecha']."<br>".$row['hora']; ?></td>
          <td width="35%"><?php echo $row['cliente']; ?></td>
          <td width="12%" align="right"><?php echo "S/ ".$row['total']; ?></td>
        </tr>
        <?php
        }
        ?>
      </tbody>
    </table>
  </div>
