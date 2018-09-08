<?php
require_once('../connection.php');
    $sql=mysqli_query($con,"SELECT * FROM total_ventas WHERE MONTH(fecha)=".$_POST['m']." AND YEAR(fecha)=".$_POST['y']." AND entregado='SI' AND vendedor='".$_SESSION['nombre']."' ORDER BY fecha,hora");
    ?>
    <script type='text/javascript' src='../picnet.table.filter.min.js'></script> 
    <script type="text/javascript">
      $(document).ready(function() {
        $('#venta').tableFilter({
          filteredRows: function(filterStates) {
            var sumatotal  = 0;
            var sumapendiente = 0;
            var sumaacuenta  = 0;
            $('#verbody tr').filter(":visible").each(function(){
              sumatotal =  parseFloat(sumatotal) +  parseFloat($(this).find("td:eq(2)").text());        
              sumapendiente =   parseFloat(sumapendiente) +  parseFloat($(this).find("td:eq(3)").text());
              sumaacuenta =   parseFloat(sumaacuenta) +  parseFloat($(this).find("td:eq(4)").text());
            });
            $('#sumatotal').text("S/. "+sumatotal.toFixed(2)); 
            $('#sumapendiente').text("S/. "+sumapendiente.toFixed(2)); 
            $('#sumaacuenta').text("S/. "+sumaacuenta.toFixed(2)); 
          },
          enableCookies: false
        });
      });
    </script>
    <table width='98%' align='center' style='border-collapse:collapse;'>
      <thead>
        <tr bgcolor="black" style="color:white;font-weight:bold;" >
          <th width="10%" style="border: 1px solid white;">FECHA</th>
          <th width="35%" style="border: 1px solid white;">CLIENTE</th>
          <th width="10%" style="border: 1px solid white;">TOTAL</th>
          <th width="10%" style="border: 1px solid white;">PENDIENTE</th>
          <th width="10%" style="border: 1px solid white;">ADELANTO</th>
          <th width="10%" style="border: 1px solid white;">ESTADO</th>
          <th width="10%" style="border: 1px solid white;">F. PAGO</th>
          <th width="5%" style="border: 1px solid white;"></th>
        </tr>
      </thead>
    </table>
    <div style="overflow:auto;height:90%;align:center">
      <table width='98%' id="venta" style="border-collapse: collapse;" align='center'>
        <thead style='background-color:#2E9AFE'>
          <tr style="display:none;" >
            <th width="10%" style="border: 1px solid white;">FECHA</th>
            <th width="35%" style="border: 1px solid white;">CLIENTE</th>
            <th width="10%" style="border: 1px solid white;">TOTAL</th>
            <th width="10%" style="border: 1px solid white;">PENDIENTE</th>
            <th width="10%" style="border: 1px solid white;">ADELANTO</th>
            <th width="10%" style="border: 1px solid white;">ESTADO</th>
            <th width="10%" style="border: 1px solid white;">F. PAGO</th>
            <th width="5%" style="border: 1px solid white;"> </th>
            <th width="10%" style="display:none">F. PAGO</th>
          </tr>
        </thead>
        <tbody id="verbody">
        <?php 
        while($row=mysqli_fetch_assoc($sql)){
          ?>
          <tr style="font-size:12px;font-weight:bold">
            <td width="10%" style="border: 1px solid black;" align='center'><?php echo $row['fecha']; ?></td>
            <td width="35%" style="border: 1px solid black;"><?php echo $row['cliente']; ?></td>
            <td width="10%" style="border: 1px solid black;" align='right'><?php echo $row['total']; ?></td>
            <td width="10%" style="border: 1px solid black;" align='right'><?php echo $row['pendiente']; ?></td>
            <td width="10%" style="border: 1px solid black;" align='right'><?php echo $row['acuenta']; ?></td>
            <td width="10%" style="border: 1px solid black;" align='center'><?php echo $row['credito']; ?></td>
            <td width="10%" style="border: 1px solid black;" align='center'><?php echo $row['fechapago']; ?></td>
            <td width="5%" style="border: 1px solid black;color:red;cursor:pointer" class='ver' align='center'>Ver</td>
            <td width="8%" style="display:none"><?php echo $row['serieventas']; ?></td>
          </tr>
          <?php
        }
        ?>
        </tbody>
      </table>
    </div>
    <table width='98%' align='center' style="border-collapse: collapse;margin-top:4px">
      <tr>
        <td width='50%' style="border: 1px solid black;text-align:right" colspan='2'>TOTAL</td>
        <td width='10%' style="border: 1px solid black;text-align:right" id='sumatotal'></td>
        <td width='10%' style="border: 1px solid black;text-align:right;" id='sumapendiente'></td>
        <td width='10%' style="border: 1px solid black;text-align:right" id='sumaacuenta'></td>
        <td width='20%' style="border: 1px solid black;text-align:right" colspan='2'></td>
      </tr>
    </table>
