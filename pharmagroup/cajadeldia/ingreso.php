<?php
  require_once('../connection.php');
    if(isset($_POST) && !empty($_POST)){
      $fecha = date('Y-m-d', strtotime(str_replace('/', '-', $_POST['fecha'])));
      $sql=mysqli_query($con,"SELECT * FROM ingresos WHERE ingreso='INGRESO' AND fecha='$fecha' AND sesion='CAJERO'");
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
          <th width="15%">ENCARGADO</th>
          <th width="10%">TIPO</th>
          <th width="15%">ORIGEN</th>
          <th width="50%">DETALLE</th>
          <th width="10%">MONTO</th>
        </tr>
      </thead>
    </table>
  <div style="overflow:auto;height:80%;align:center">
    <table width="100%" cellpadding="0" cellspacing="0" border="1" align="center" id='filter1'>
      <thead style='background-color:#2E9AFE'>
        <tr style='display:none'>
          <th width="15%">ENCARGADO</th>
          <th width="10%">TIPO</th>
          <th width="15%">ORIGEN</th>
          <th width="50%">DETALLE</th>
          <th width="10%">MONTO</th>
        </tr>
      </thead>
      <tbody id="verbody">
        <?php
          while($row=mysqli_fetch_assoc($sql)){
            ?>
            <tr style="font-size:12px;font-weight:bold">
              <td width="15%" align="center"><?php echo $row['sesion']; ?></td>
              <td width="10%" align="center"><?php echo $row['tipo']; ?></td>
              <td width="15%" align="center"><?php echo $row['origen']; ?></td>
              <td width="50%" align="left"><?php echo $row['detalle']; ?></td>
              <td width="10%" align="right"><?php echo $row['monto']; ?></td>
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