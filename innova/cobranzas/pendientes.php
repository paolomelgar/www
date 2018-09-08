<?php
require_once('../connection.php');
    $sql=mysqli_query($con,"SELECT * FROM acuenta WHERE vendedor='".$_POST['vendedor']."' AND pendiente='SI'");
    $a=0;
    ?>
    <div style="overflow-y:overlay;overflow-x:hidden;height:70%;align:center">
      <table width='98%' id="venta5" style="border-collapse: collapse;" align='center'>
        <thead style='background-color:black;color:white'>
          <tr>
            <th width="15%" style="border: 1px solid white;">SERIE</th>
            <th width="45%" style="border: 1px solid white;">CLIENTE</th>
            <th width="10%" style="border: 1px solid white;">TOTAL</th>
            <th width="10%" style="border: 1px solid white;">PEND</th>
            <th width="10%" style="border: 1px solid white;">ACUENTA</th>
            <th width="10%" style="border: 1px solid white;">RESTA</th>
            <th style="display:none;"></th>
            <?php } ?>
          </tr>
        </thead>
        <tbody id="verbody1">
        <?php 
        while($row=mysqli_fetch_assoc($sql)){
          $q=mysqli_query($con,"SELECT pendiente,total FROM total_ventas WHERE serieventas='".$row['serie']."' AND documento='NOTA DE PEDIDO'");
          $a=mysqli_fetch_row($q);
          ?>
          <tr style="font-size:12px;font-weight:bold" class='fila'>
            <td width="15%" style="border: 1px solid black;"><?php echo $row['serie']; ?></td>
            <td width="45%" style="border: 1px solid black;"><?php echo $row['cliente']; ?></td>
            <td width="10%" style="border: 1px solid black;" align='right'><?php echo $a[1]; ?></td>
            <td width="10%" style="border: 1px solid black;" align='right'><?php echo $a[0]; ?></td>
            <td width="10%" style="border: 1px solid black;background-color:#f63;" align='right'><?php echo number_format($row['monto'],2,'.',''); ?></td>
            <td width="10%" style="border: 1px solid black;" align='right'><?php echo number_format(($a[0]-$row['monto']),2,'.',''); ?></td>
            <td style="display:none"><?php echo $row['id']; ?></td>
          </tr>
          <?php
        }
        ?>
        </tbody>
        <tfoot>
          <tr>
            <td width='70%' style="border: 1px solid black;text-align:right" colspan='4'>TOTAL</td>
            <td width='10%' style="border: 1px solid black;text-align:right;background-color:#f63;" id='sumapendiente1'></td>
            <td width='10%' style="border: 1px solid black;text-align:right" colspan='2'></td>
          </tr>
        </tfoot>
      </table>
    </div>