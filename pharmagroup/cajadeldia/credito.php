<?php
  require_once('../connection.php');
    if(isset($_POST) && !empty($_POST)){
      $fecha = date('Y-m-d', strtotime(str_replace('/', '-', $_POST['fecha'])));
      $sql=mysqli_query($con,"SELECT * FROM adelantos WHERE fecha='$fecha' AND sesion='CAJERO'");
?>
  <script type='text/javascript' src='../picnet.table.filter.min.js'></script> 
  <script type="text/javascript">
    $(document).ready(function() {
      $('#filter1').tableFilter({
          filteredRows: function(filterStates) {
            var sumatotal  = 0;
            $('#verbody tr').filter(":visible").each(function(){
              sumatotal =  parseFloat(sumatotal) +  parseFloat($(this).find("td:eq(3)").text());        
            });
            $('#sumatotal').text("S/. "+sumatotal.toFixed(2)); 
          },
          enableCookies: false
        });
    });
  </script>
    <table width="100%" cellpadding="0" cellspacing="0" border="1" align="center">
      <thead>
        <tr bgcolor="black" style="color:#FFF; text-align:center;font-size:11px;font-weight:bold">
          <th width="15%">SERIE</th>
          <th width="25%">ENCARGADO</th>
          <th width="45%">CLIENTE</th>
          <th width="15%">MONTO</th>
        </tr>
      </thead>
    </table>
  <div style="overflow:auto;height:80%;align:center">
    <table width="100%" cellpadding="0" cellspacing="0" border="1" align="center" id='filter1'>
      <thead style='background-color:#2E9AFE'>
        <tr style='display:none'>
          <th width="15%">SERIE</th>
          <th width="25%">ENCARGADO</th>
          <th width="45%">CLIENTE</th>
          <th width="15%">MONTO</th>
        </tr>
      </thead>
      <tbody id="verbody">
        <?php
          while($row=mysqli_fetch_assoc($sql)){
            ?>
            <tr style="font-size:12px;font-weight:bold">
              <td width="15%" align="right"><?php echo $row['serie']; ?></td>
              <td width="25%" align="center"><?php echo $row['encargado']; ?></td>
              <td width="45%"><?php echo $row['cliente']; ?></td>
              <td width="15%" align="right"><?php echo $row['adelanto']; ?></td>
            </tr>
            <?php
          }
        ?>
      </tbody>
       <tfoot>
          <tr style="font-size:12px;font-weight:bold;">
            <td colspan="3" align='right'>TOTAL</td>
            <td align="right" width='10%' id='sumatotal'></td>
          </tr>
       </tfoot>
     </table>
   </div>
   <?php 
        }
?>