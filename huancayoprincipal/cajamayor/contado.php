<?php
  require_once('../connection.php');
    if(isset($_POST) && !empty($_POST)){
      $fecha = date('Y-m-d', strtotime(str_replace('/', '-', $_POST['fecha'])));
      $sql=mysqli_query($con,"SELECT * FROM total_compras WHERE fechafactura='$fecha' AND credito='CONTADO' ORDER BY documento,serie");
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
          <th width="10%">SERIE</th>
          <th width="15%">HORA</th>
          <th width="20%">COMPROBANTE</th>
          <th width="35%">CLIENTE</th>
          <th width="10%">TOTAL</th>
          <th width="10%"></th>
        </tr>
      </thead>
    </table>
  <div style="overflow:auto;height:80%;align:center">
    <table width="100%" cellpadding="0" cellspacing="0" border="1" align="center" id='filter1'>
      <thead style='background-color:#2E9AFE'>
        <tr style='display:none'>
          <th width="10%">SERIE</th>
          <th width="15%">HORA</th>
          <th width="20%">COMPROBANTE</th>
          <th width="35%">CLIENTE</th>
          <th width="10%">TOTAL</th>
          <th width="10%">a</th>
          <th width="10%" style='display:none'></th>
        </tr>
      </thead>
      <tbody id="verbody">
        <?php
        while($row=mysqli_fetch_assoc($sql)){
        ?>
        <tr style="font-size:12px;font-weight:bold">
          <td width="10%" align="right"><?php echo $row['serie']; ?></td>
          <td width="15%" align="center"><?php echo $row['hora']; ?></td>
          <td width="20%" align="center"><?php echo $row['documento']; ?></td>
          <td width="35%"><?php echo $row['proveedor']; ?></td>
          <?php if($row['entregado']=='ANULADO'){
            $row['montototal']=0; ?>
          <td width="10%" align="right"><?php echo $row['montototal']; ?></td>
          <td width="10%" align="center"><div class='ver' style="cursor:pointer;color:blue">ANULADO</div></td>
          <?php }elseif($row['entregado']=='NO' && $row['documento']=='FACTURA'){
            $row['montototal']=0; ?>
          <td width="10%" align="right"><?php echo $row['montototal']; ?></td>
          <td width="10%" align="center"><div class="ver" style="cursor:pointer;color:green">NO AFECTA</div></td>
          <?php }else{
            if($row['billete']=='SOLES'){
            $p=number_format(round($row['montototal'],1),1,".","")."0";?>
          <td width="10%" align="right"><?php echo $p; ?></td>
          <?php }else{
            $p=number_format(round($row['montototal']*$row['cambio'],1),1,".","")."0";?>
          <td width="10%" align="right"><?php echo $p; ?></td>
          <?php } ?>
          <td width="10%" align="center"><div class="ver" style="cursor:pointer;color:red">VER</div></td>
          <?php } ?>
          <td width="10%" style='display:none'><?php echo $row['value']; ?></td>
        </tr>
        <?php
    }
   ?>
   </tbody>
   <tfoot>
      <tr style="font-size:12px;font-weight:bold;">
        <td width='80%' colspan="4" align='right'>TOTAL</td>
        <td width='10%' align="right" id='sumatotal'></td>
        <td width='10%'></td>
      </tr>
   </tfoot>
   </table>
   </div>
   <?php 
        }
?>