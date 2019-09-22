<?php
  require_once('../connection.php');
    if(isset($_POST) && !empty($_POST)){
      $fecha = date('Y-m-d', strtotime(str_replace('/', '-', $_POST['fecha'])));
      $sql=mysqli_query($con,"SELECT * FROM adelantoscompras WHERE fecha='$fecha'");
      $sql1=mysqli_query($con,"SELECT * FROM adelantosletra WHERE fechapago='$fecha'");
?>
  <script type='text/javascript' src='../picnet.table.filter.min.js'></script> 
  <script type="text/javascript">
    $(document).ready(function() {
      $('#filter1').tableFilter({
          filteredRows: function(filterStates) {
            var sumatotal  = 0;
            $('#verbody tr').filter(":visible").each(function(){
              sumatotal =  parseFloat(sumatotal) +  parseFloat($(this).find("td:eq(4)").text());        
            });
            $('#sumatotal').text("S/. "+sumatotal.toFixed(2)); 
          },
          enableCookies: false
        });
    });
  </script>
    <table width="100%" cellpadding="0" cellspacing="0" border="1" align="center">
      <thead>
        <tr bgcolor="black" style="color:white;text-align:center;font-size:11px;font-weight:bold">
          <th width="30%">PROVEEDOR</th>
          <th width="10%">FORMA PAGO</th>
          <th width="20%">BANCO</th>
          <th width="25%">Nro</th>
          <th width="15%">MONTO</th>
        </tr>
      </thead>
    </table>
  <div style="overflow:auto;height:80%;align:center">
    <table width="100%" cellpadding="0" cellspacing="0" border="1" align="center" id='filter1'>
      <thead style='background-color:#2E9AFE'>
        <tr style='display:none'>
          <th width="30%">PROVEEDOR</th>
          <th width="10%">FORMA PAGO</th>
          <th width="20%">BANCO</th>
          <th width="25%">Nro</th>
          <th width="15%">MONTO</th>
        </tr>
      </thead>
      <tbody id="verbody">
        <?php
          while($row=mysqli_fetch_assoc($sql)){
            ?>
            <tr style="font-size:12px;font-weight:bold">
              <td width="30%"><?php echo $row['proveedor']; ?></td>
              <td width="10%" align="center"><?php echo $row['forma']; ?></td>
              <td width="20%" align="center"><?php echo $row['banco']; ?></td>
              <td width="25%" align="center"><?php echo $row['nro']; ?></td>
              <?php if($row['cambio']>0){ ?>
              <td width="15%" align="right"><?php echo number_format(round($row['adelanto']*$row['cambio'],1),1,".","")."0"; ?></td>
              <?php }else{ ?>
              <td width="15%" align="right"><?php echo number_format(round($row['adelanto'],1),1,".","")."0"; ?></td>
              <?php } ?>
            </tr>
            <?php
          }
          while($row1=mysqli_fetch_assoc($sql1)){
            ?>
            <tr style="font-size:12px;font-weight:bold">
              <td width="30%"><?php echo $row1['proveedor']; ?></td>
              <td width="10%" align="center">LETRA</td>
              <td width="20%" align="center"></td>
              <td width="25%" align="center"></td>
              <?php if($row1['cambio']>0){ ?>
              <td width="15%" align="right"><?php echo number_format(round($row1['adelanto']*$row1['cambio'],1),1,".","")."0"; ?></td>
              <?php }else{ ?>
              <td width="15%" align="right"><?php echo number_format(round($row1['adelanto'],1),1,".","")."0"; ?></td>
              <?php } ?>
            </tr>
            <?php
          }
        ?>
      </tbody>
       <tfoot>
          <tr style="font-size:12px;font-weight:bold;">
            <td colspan="4" align='right'>TOTAL</td>
            <td align="right" width='10%' id='sumatotal'></td>
          </tr>
       </tfoot>
     </table>
   </div>
   <?php 
        }
?>