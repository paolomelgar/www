<?php
  require_once('../connection.php');
      $sql=mysqli_query($con,"SELECT * FROM total_pedido WHERE entregado='NO' ORDER BY fecha,nropedido");
?>
    <table width="100%" cellpadding="0" cellspacing="0" border="1" align="center">
      <thead>
        <tr bgcolor="#1c94c4" style="color:#FFF; text-align:center;font-size:12px;font-weight:bold">
          <th width="6%"></th>
          <th width="12%" style="display:none">SERIE</th>
          <th width="16%">VENDEDOR</th>
          <th width="13%">FECHA</th>
          <th width="4%">N°</th>
          <th width="33%">CLIENTE</th>
          <th width="12%">TOTAL</th>
          <th width="7%">VER</th>
          <th width="11%">IMPRIMIR</th>
        </tr>
      </thead>
    </table>
  <div style="overflow:auto;height:350px;align:center">
    <table width="100%" cellpadding="0" cellspacing="0" border="1" align="center">
      <tbody id="listpendientes">
        <?php
        while($row=mysqli_fetch_assoc($sql)){
        ?>
        <tr bgcolor="#FBEFEF" style="font-size:12px;font-weight:bold">
          <td width="6%" align="center"><span class='ui-icon ui-icon-trash x' style='cursor:pointer'></td>
          <td width="12%" align="center" style="display:none"><?php echo $row['seriepedido']; ?></td>
          <td width="16%" align="center"><?php echo $row['vendedor']; ?></td>
          <td width="13%" align="center"><?php echo $row['fecha']."<br>".$row['hora']; ?></td>
          <td width="4%" align="right" style='color:blue;font-weight:bold;font-size:20px'><?php echo $row['nropedido']; ?></td>
          <td width="33%"><?php echo $row['cliente']; ?></td>
          <td width="12%" align="right"><?php echo "S/ ".$row['total']; ?></td>
          <?php if($row['imprimir']==0){ ?>
            <td width="7%" align="center"></td>
            <td width="11%" align="center"><div class="imprimir1" style="color:green;cursor:pointer">Imprimir</div></td>
          <?php }else{ ?>
            <td width="7%" align="center"><div class="recibirpendiente" style="color:red;cursor:pointer">Ver</div></td>
            <td width="11%" align="center"><div class="imprimir1" style="color:blue;cursor:pointer">Reimprimir</div></td>
          <?php } ?>
        </tr>
        <?php
        }
        ?>
      </tbody>
    </table>
  </div>
