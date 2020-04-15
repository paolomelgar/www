<?php
    require_once('../connection.php');
    $ini = date('Y-m-d', strtotime(str_replace('/', '-', $_POST['ini'])));
    $fin = date('Y-m-d', strtotime(str_replace('/', '-', $_POST['fin'])));
    $query="";
    if($_POST['estado']=='CANCELADO'){
      $query.="('$ini' <= fecha AND fecha <= '$fin') AND pendiente='NO'";
    }
    else{
      $query.="pendiente='SI'";
    }
      $sql=mysqli_query($con,"SELECT * FROM prestamistas WHERE $query ORDER BY fecha");
      $n=0;
    ?>
    <script type='text/javascript' src='../picnet.table.filter.min.js'></script> 
    <script type="text/javascript">
      $(document).ready(function() {
        $('#venta').tableFilter({
          filteredRows: function(filterStates) {
            var suma = 0;
            $('#verbody tr').filter(":visible").each(function(){
              suma =  parseFloat(suma) +  parseFloat($(this).find("td:eq(3)").text());        
            });
            $('#suma').text("S/. "+suma.toFixed(2)); 
          },
          enableCookies: false
        });
      });
    </script>
    <table width='98%' align='center' style='border-collapse:collapse;'>
      <thead>
        <tr bgcolor="black" style="color:white;font-weight:bold;" >
          <th width="3%" style="border: 1px solid white;">N°</th>
          <th width="15%" style="border: 1px solid white;">PRESTAMISTA</th>
          <th width="15%" style="border: 1px solid white;">DOCUMENTO</th>
          <th width="10%" style="border: 1px solid white;">MONTO</th>
          <th width="10%" style="border: 1px solid white;">INTERES</th>
          <th width="10%" style="border: 1px solid white;">PORCENTAJE</th>
          <th width="17%" style="border: 1px solid white;">FECHA PAGO</th>
          <th width="10%" style="border: 1px solid white;">DIAS</th>
          <th width="10%" style="border: 1px solid white;">PAGAR</th>
        </tr>
      </thead>
    </table>
    <div style="overflow:auto;height:80%;align:center">
      <table width='98%' id="venta" style="border-collapse: collapse;" align='center'>
        <thead style='background-color:#2E9AFE'>
          <tr style="display:none;" >
            <th width="3%" style="border: 1px solid white;">N°</th>
            <th width="15%" style="border: 1px solid white;">PRESTAMISTA</th>
            <th width="15%" style="border: 1px solid white;">DOCUMENTO</th>
            <th width="10%" style="border: 1px solid white;">MONTO</th>
            <th width="10%" style="border: 1px solid white;">INTERES</th>
            <th width="10%" style="border: 1px solid white;">PORCENTAJE</th>
            <th width="17%" style="border: 1px solid white;">FECHA PAGO</th>
            <th width="10%" style="border: 1px solid white;">DIAS</th>
            <th width="10%" style="border: 1px solid white;">PAGAR</th>
            <th style="border: 1px solid white;display:none">N°</th>
          </tr>
        </thead>
        <tbody id="verbody">
        <?php 
        while($row=mysqli_fetch_assoc($sql)){
          $n++;
          $interval=strtotime($row['fecha'])-strtotime(date("Y-m-d"));
          $diferencia=intval($interval/60/60/24);
          ?>
          <tr style="font-size:12px;font-weight:bold">
            <td width="3%" style="border: 1px solid black;" align='right'><?php echo $n; ?></td>
            <td width="15%" style="border: 1px solid black;"><?php echo $row['banco']; ?></td>
            <td width="15%" style="border: 1px solid black;" align='center'><?php echo $row['dni']; ?></td>
            <td width="10%" style="border: 1px solid black;background-color:#f63;color:blue;font-size:14px" align='right'><?php echo $row['monto']; ?></td>
            <td width="10%" style="border: 1px solid black;background-color:#f63;color:blue;font-size:14px" align='right'><?php echo $row['interes']; ?></td>
            <td width="10%" style="border: 1px solid black;background-color:#f63;color:blue;font-size:14px" align='right'><?php echo $row['porcentaje']; ?></td>
            <td width="17%" style="border: 1px solid black;" align='center'><?php echo $row['fecha']; ?></td>
            <td width="10%" style="border: 1px solid black;" align='center'><?php echo $diferencia; ?></td>
            <td width="10%" style="border: 1px solid black;" align='center'><div class="cobrar" style="cursor:pointer;color:red">PAGAR</div></td>
            <td style="border: 1px solid black;display:none"><?php echo $row['id']; ?></td>
          </tr>
          <?php
        }
        ?>
        </tbody>
      </table>
    </div>
    <table width='98%' align='center' style="border-collapse: collapse;margin-top:4px">
      <tr>
        <td width='31%' style="border: 1px solid black;text-align:right" colspan='3'>TOTAL</td>
        <td width='10%' style="border: 1px solid black;text-align:right" id='suma'></td>
        <td width='57%' style="border: 1px solid black;text-align:right" colspan='4'></td>
      </tr>
    </table>
