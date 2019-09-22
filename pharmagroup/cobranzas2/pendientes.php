<?php
require_once('../connection.php');
    $sql=mysqli_query($con,"SELECT * FROM acuenta WHERE vendedor='".$_POST['vendedor']."' AND pendiente='SI'");
    ?>
    <script type='text/javascript' src='../picnet.table.filter.min.js'></script> 
    <script type="text/javascript">
      $(document).ready(function() {
        $('#venta5').tableFilter({
          filteredRows: function(filterStates) {
            var sumatotal  = 0;
            var sumapendiente = 0;
            var sumaacuenta  = 0;
            $('#verbody1 tr').filter(":visible").each(function(){
              sumatotal =  parseFloat(sumatotal) +  parseFloat($(this).find("td:eq(3)").text());        
              sumapendiente =   parseFloat(sumapendiente) +  parseFloat($(this).find("td:eq(4)").text());
              sumaacuenta =   parseFloat(sumaacuenta) +  parseFloat($(this).find("td:eq(5)").text());
            });
            $('#sumatotal1').text(sumatotal.toFixed(2)); 
            $('#sumapendiente1').text(sumapendiente.toFixed(2)); 
            $('#sumaacuenta1').text(sumaacuenta.toFixed(2)); 
          },
          enableCookies: false
        });
      });
    </script>
    <table width='98%' align='center' style='border-collapse:collapse;'>
      <thead>
        <tr bgcolor="black" style="color:white;font-weight:bold;" >
          <th width="15%" style="border: 1px solid white;">SERIE</th>
          <th width="45%" style="border: 1px solid white;">CLIENTE</th>
          <th width="10%" style="border: 1px solid white;">TOTAL</th>
          <th width="10%" style="border: 1px solid white;">PEND</th>
          <th width="10%" style="border: 1px solid white;">ACUENTA</th>
          <th width="10%" style="border: 1px solid white;">RESTA</th>
        </tr>
      </thead>
    </table>
    <div style="overflow:auto;height:70%;align:center">
      <table width='98%' id="venta5" style="border-collapse: collapse;" align='center'>
        <thead style='background-color:#2E9AFE'>
          <tr style="display:none;" >
            <th width="15%" style="border: 1px solid white;">fasd</th>
            <th width="45%" style="border: 1px solid white;">fasd</th>
            <th width="10%" style="border: 1px solid white;">VENDEDOR</th>
            <th width="10%" style="border: 1px solid white;">VENDEDOR</th>
            <th width="10%" style="border: 1px solid white;">SERIE</th>
            <th width="10%" style="border: 1px solid white;">CLIENTE</th>
          </tr>
        </thead>
        <tbody id="verbody1">
        <?php 
        while($row=mysqli_fetch_assoc($sql)){
          $q=mysqli_query($con,"SELECT pendiente,total FROM total_ventas WHERE serieventas='".$row['serie']."' AND documento='NOTA DE PEDIDO'");
          $a=mysqli_fetch_row($q);
          ?>
          <tr style="font-size:12px;font-weight:bold">
            <td width="15%" style="border: 1px solid black;"><?php echo $row['serie']; ?></td>
            <td width="45%" style="border: 1px solid black;"><?php echo $row['cliente']; ?></td>
            <td width="10%" style="border: 1px solid black;" align='right'><?php echo $a[1]; ?></td>
            <td width="10%" style="border: 1px solid black;" align='right'><?php echo $a[0]; ?></td>
            <td width="10%" style="border: 1px solid black;background-color:#f63;" align='right'><?php echo $row['monto']; ?></td>
            <td width="10%" style="border: 1px solid black;" align='right'><?php echo ($a[0]-$row['monto']); ?></td>
          </tr>
          <?php
        }
        ?>
        </tbody>
      </table>
    </div>
    <table width='98%' align='center' style="border-collapse: collapse;margin-top:4px">
      <tr>
        <td width='70%' style="border: 1px solid black;text-align:right" colspan='2'>TOTAL</td>
        <td width='10%' style="border: 1px solid black;text-align:right" id='sumatotal1'></td>
        <td width='10%' style="border: 1px solid black;text-align:right;background-color:#f63;" id='sumapendiente1'></td>
        <td width='10%' style="border: 1px solid black;text-align:right" id='sumaacuenta1'></td>
      </tr>
    </table>