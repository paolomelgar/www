<?php
  require_once('../connection.php');
    $ini = date('Y-m-d', strtotime(str_replace('/', '-', $_POST['inicio'])));
    $fin = date('Y-m-d', strtotime(str_replace('/', '-', $_POST['final'])));
    $query="('$ini' <= fecha AND fecha <= '$fin')";
    if($_POST['cliente']==''){$query.="";}
    else{$query.=" AND cliente='".$_POST['cliente']."'";}
    if($_POST['change']=='REAL'){
      $sql=mysqli_query($con,"SELECT * FROM notapedido WHERE $query AND entregado='SI' UNION SELECT * FROM proforma WHERE $query AND entregado='SI' ORDER BY fecha,hora");
    }
    else{
      $sql=mysqli_query($con,"SELECT * FROM factura WHERE $query UNION SELECT * FROM boleta WHERE $query ORDER BY fecha,hora");
    }
    $n=1;
    ?>
    <script type='text/javascript' src='../picnet.table.filter.min.js'></script> 
    <script type="text/javascript">
      $(document).ready(function() {
        $('#venta').tableFilter({
          filteredRows: function(filterStates) {
            var cantidad  = 0;
            var total  = 0;
            $('#verbody tr').filter(":visible").each(function(){
                cantidad = parseFloat(cantidad) + parseFloat($(this).find("td:eq(5)").text());
                total = parseFloat(total) + parseFloat($(this).find("td:eq(8)").text());
            });
            $('#cantidad').text(cantidad); 
            $('#total').text("S/. "+total.toFixed(2)); 
          },
          enableCookies: false
        });
      });
    </script>
    <table width='98%' align='center'>
      <thead>
        <tr align='center' bgcolor="black" style="color:white;font-weight:bold;">
          <th width='2%'>N°</th>
          <th width='20%'>CLIENTE</th>
          <th width='10%'>FECHA</th>
          <th width='10%'>COMPROBANTE</th>
          <th width='10%'>SERIE</th>
          <th width='5%'>CANT</th>
          <th width='23%'>PRODUCTO</th>
          <th width='10%'>UNITARIO</th>
          <th width='10%'>TOTAL</th>
        </tr>
      </thead>
    </table>
    <div style="overflow:auto;height:85%;align:center">
    <table width='98%' id="venta" style="border-collapse: collapse;" align='center'>
      <thead style='background-color:#2E9AFE'>
        <tr style="display:none">
          <th width='2%'>N°</th>
          <th width='20%'>CLIENTE</th>
          <th width='10%'>FECHA</th>
          <th width='10%'>COMPROBANTE</th>
          <th width='10%'>SERIE</th>
          <th width='5%'>CANTIDAD</th>
          <th width='23%'>PRODUCTO</th>
          <th width='10%'>UNITARIO</th>
          <th width='10%'>TOTAL</th>
        </tr>
      </thead>
      <tbody id="verbody">
      <?php 
        while($row=mysqli_fetch_assoc($sql)){
        ?>
        <tr style="font-size:12px;font-weight:bold">
          <td style="border: 1px solid black;text-align:right" width='2%'><?php echo $n; ?></td>
          <td style="border: 1px solid black;" width='20%'><?php echo $row['cliente']; ?></td>
          <td style="border: 1px solid black;text-align:center" width='10%'><?php echo date('d/m/Y', strtotime(str_replace('-','/',$row['fecha']))); ?></td>
          <?php if($_POST['change']=='REAL'){ ?>
          <td style="border: 1px solid black;text-align:center" width='10%'><?php echo $row['documento']; ?></td>
          <td style="border: 1px solid black;text-align:center" width='10%'><?php echo $row['serienota']; ?></td>
          <?php }else{ ?>
          <td style="border: 1px solid black;text-align:center" width='10%'><?php echo $row['documento']; ?></td>
          <td style="border: 1px solid black;text-align:center" width='10%'><?php echo $row['seriefactura']; ?></td>
          <?php } ?>
          <td style="border: 1px solid black;text-align:right" width='5%'><?php echo $row['cantidad']; ?></td>
          <td style="border: 1px solid black;" width='23%'><?php echo $row['producto']; ?></td>
          <td style="border: 1px solid black;text-align:right" width='10%'><?php echo $row['unitario']; ?></td>
          <td style="border: 1px solid black;text-align:right" width='10%'><?php echo $row['importe']; ?></td>
        </tr>
        <?php
        $n++;
      }
    ?>
      </tbody>
      <tfoot>
        <tr style="font-size:12px;font-weight:bold">
          <td width='52%' style="border: 1px solid black;text-align:right" colspan='5'>TOTAL:</td>
          <td width='5%' style="border: 1px solid black;text-align:right" id='cantidad'></td>
          <td width='33%' style="border: 1px solid black;text-align:right" colspan='2'></td>
          <td width='10%' style="border: 1px solid black;text-align:right" id='total'></td>
        </tr>
      </tfoot>
    </table>
  </div>
