<?php
  require_once('../connection.php');
    if(isset($_POST) && !empty($_POST)){
      $fecha = date('Y-m-d', strtotime(str_replace('/', '-', $_POST['fecha'])));
      $sql=mysqli_query($con,"SELECT * FROM total_ventas WHERE fecha='$fecha' AND credito='CONTADO' ORDER BY documento,serieventas");
      $sum=0;
?>
  <script type="text/javascript" src="../jquery-1.11.1.min.js"></script>
  <script type='text/javascript' src='../picnet.table.filter.min.js'></script> 
  <script type="text/javascript">
    $(document).ready(function() {
      $('#filter1').tableFilter();
    });
  </script>
    <table width="100%" cellpadding="0" cellspacing="0" border="1" align="center">
      <thead>
        <tr bgcolor="black" style="color:#FFF; text-align:center;font-size:11px;font-weight:bold">
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
          <th width="10%"></th>
        </tr>
      </thead>
      <tbody id="verbody">
        <?php
        while($row=mysqli_fetch_assoc($sql)){
        ?>
        <tr bgcolor="#FBEFEF" style="font-size:12px;font-weight:bold">
          <td width="10%" align="right"><?php echo $row['serieventas']; ?></td>
          <td width="15%" align="center"><?php echo $row['hora']; ?></td>
          <td width="20%" align="center"><?php echo $row['documento']; ?></td>
          <td width="35%"><?php echo $row['cliente']; ?></td>
          <?php if($row['entregado']=='ANULADO'){
            $row['total']=0; ?>
          <td width="10%" align="right"><?php echo "S/. ".$row['total']; ?></td>
          <td width="10%" align="center"><div class='ver' style="cursor:pointer;color:blue">ANULADO</div></td>
          <?php }else{ ?>
          <td width="10%" align="right"><?php echo "S/. ".$row['total']; ?></td>
          <td width="10%" align="center"><div class="ver" style="cursor:pointer;color:red">VER</div></td>
          <?php } ?>
        </tr>
        <?php
        $sum+=$row['total'];
    }
   ?>
   </tbody>
   <tfoot>
      <tr style="font-size:12px;font-weight:bold;">
        <td colspan="4" align='right'>TOTAL</td>
        <td align="right" width='10%'><?php echo "S/. ".number_format($sum,2);?></td>
        <td width='5%'></td>
      </tr>
   </tfoot>
   </table>
   </div>
   <?php 
        }
?>