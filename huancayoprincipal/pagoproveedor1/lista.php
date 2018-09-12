<?php
  require_once('../connection.php');
  $ini = date('Y-m-d', strtotime(str_replace('/', '-', $_POST['ini'])));
  $fin = date('Y-m-d', strtotime(str_replace('/', '-', $_POST['fin'])));
  $query="";
  if($_POST['estado']=='CANCELADO'){
    $query.="('$ini' <= fechafactura AND fechafactura <= '$fin') AND credito='CANCELADO'";
  }
  else{
    $query.="credito='CREDITO'";
  }
  if(isset($_POST['proveedor']) && !empty($_POST['proveedor'])){
    $query.=" AND proveedor='".$_POST['proveedor']."'";
  }
  $sql=mysqli_query($con,"SELECT * FROM total_compras WHERE $query AND entregado='SI' ORDER BY fechapago");
  ?>
  <script type='text/javascript' src='../picnet.table.filter.min.js'></script> 
  <script type="text/javascript">
    $(document).ready(function() {
      $('#venta').tableFilter({
        filteredRows: function(filterStates) {
          var sumatotal  = 0;
          var sumapendiente = 0;
          var sumaacuenta  = 0;
          var sumatotal1  = 0;
          var sumapendiente1 = 0;
          var sumaacuenta1  = 0;
          $('#verbody tr').filter(":visible").each(function(){
            if($(this).find("td:eq(3)").text().slice(0,1)=='S'){
              sumatotal =  parseFloat(sumatotal) +  parseFloat($(this).find("td:eq(2)").text().slice(4));        
              sumapendiente =   parseFloat(sumapendiente) +  parseFloat($(this).find("td:eq(3)").text().slice(4));
              sumaacuenta =   parseFloat(sumaacuenta) +  parseFloat($(this).find("td:eq(4)").text().slice(4));
            }
            else{
              sumatotal1 =  parseFloat(sumatotal1) +  parseFloat($(this).find("td:eq(2)").text().slice(4));        
              sumapendiente1 =   parseFloat(sumapendiente1) +  parseFloat($(this).find("td:eq(3)").text().slice(4));
              sumaacuenta1 =   parseFloat(sumaacuenta1) +  parseFloat($(this).find("td:eq(4)").text().slice(4));
            }
          });
          $('#sumatotal').html("<b style='color:blue'>S/. "+sumatotal.toFixed(2)+"</b><br><b style='color:green'>$. "+sumatotal1.toFixed(2)+"</b>"); 
          $('#sumapendiente').html("<b style='color:blue'>S/. "+sumapendiente.toFixed(2)+"</b><br><b style='color:green'>$. "+sumapendiente1.toFixed(2)+"</b>"); 
          $('#sumaacuenta').html("<b style='color:blue'>S/. "+sumaacuenta.toFixed(2)+"</b><br><b style='color:green'>$. "+sumaacuenta1.toFixed(2)+"</b>"); 
        },
        enableCookies: false
      });
    });
  </script>
  <table style="border-collapse: collapse;" width="98%" align="center">
    <thead>
      <tr bgcolor="black" style="color:white;font-weight:bold;" >
        <th width="10%" style="border: 1px solid white;">SERIE</th>
        <th width="20%" style="border: 1px solid white;">PROVEEDOR</th>
        <th width="10%" style="border: 1px solid white;">TOTAL</th>
        <th width="10%" style="border: 1px solid white;">PENDIENTE</th>
        <th width="10%" style="border: 1px solid white;">ADELANTO</th>
        <th width="10%" style="border: 1px solid white;">F. EMISION</th>
        <th width="10%" style="border: 1px solid white;">F. VENCIM</th>
        <th width="10%" style="border: 1px solid white;">DIAS</th>
        <th width="10%" style="border: 1px solid white;">DETALLES</th>
      </tr>
    </thead>
  </table>
  <div style="overflow:auto;height:40%;align:center">
    <table width='98%' id="venta" style="border-collapse: collapse;" align='center'>
      <thead style='background-color:#2E9AFE'>
        <tr style="display:none;" >
          <th width="10%" style="border: 1px solid white;">SERIE</th>
          <th width="20%" style="border: 1px solid white;">PROVEEDOR</th>
          <th width="10%" style="border: 1px solid white;">TOTAL</th>
          <th width="10%" style="border: 1px solid white;">PENDIENTE</th>
          <th width="10%" style="border: 1px solid white;">ADELANTO</th>
          <th width="10%" style="border: 1px solid white;">F. EMISION</th>
          <th width="10%" style="border: 1px solid white;">F. VENCIM</th>
          <th width="10%" style="border: 1px solid white;">DIAS</th>
          <th width="10%" style="border: 1px solid white;">DETALLES</th>
          <th width="10%" style="display:none"></th>
          <th width="10%" style="display:none"></th>
        </tr>
      </thead>
      <tbody id="verbody">
        <?php 
        while($row=mysqli_fetch_assoc($sql)){
          $sqll=mysqli_query($con,"SELECT fecha FROM pagoletras WHERE value='".$row['value']."' AND pendiente='SI' ORDER BY id LIMIT 1");
          $f=mysqli_fetch_row($sqll);
          if(mysqli_num_rows($sqll)>0){$fechapago=$f[0];}
          else{$fechapago=$row['fechapago'];}
          $interval=strtotime($fechapago)-strtotime(date("Y-m-d"));
          $diferencia=intval($interval/60/60/24);
        ?>
        <tr style="font-size:14px;font-weight:bold">
          <td width="10%" align='center' style="border: 1px solid black;"><?php echo $row['documento'].'<br>'.$row['serie']."-".$row['numero']; ?></td>
          <td width="20%" style="border: 1px solid black;"><?php echo htmlentities($row['proveedor']); ?></td>
          <?php if($row['billete']=='SOLES'){ ?>
          <td width="10%" align='right' style="border: 1px solid black;color:blue;font-weight:bold;"><?php echo "S/. ".$row['montototal']; ?></td>
          <td width="10%" align='right' style="border: 1px solid black;background-color:#f63;color:blue;font-weight:bold;"><?php echo "S/. ".$row['pendiente']; ?></td>
          <td width="10%" align='right' style="border: 1px solid black;color:blue;font-weight:bold;"><?php echo "S/. ".$row['acuenta']; ?></td>
          <?php }else{ ?>
          <td width="10%" align='right'  style="border: 1px solid black;color:green;font-weight:bold;"><?php echo " $. ".$row['montototal']; ?></td>
          <td width="10%" align='right'  style="border: 1px solid black;background-color:#f63;color:green;font-weight:bold;"><?php echo " $. ".$row['pendiente']; ?></td>
          <td width="10%" align='right'  style="border: 1px solid black;color:green;font-weight:bold;"><?php echo " $. ".$row['acuenta']; ?></td>
          <?php } ?>
          <td width="10%" align='center' style="border: 1px solid black;"><?php echo $row['fechafactura']; ?></td>
          <td width="10%" align='center' style="border: 1px solid black;"><?php echo $fechapago; ?></td>
          <td width="10%" align='center' style="border: 1px solid black;"><?php echo $diferencia; ?></td>
          <?php if($row['letra']=='NO'){?>
          <td width="10%" align='center' style="border: 1px solid black;"><div class="detail" style="cursor:pointer;color:red">DETALLES</div></td>
          <?php }else{ ?>
          <td width="10%" align='center' style="border: 1px solid black;"><div class="detail" style="cursor:pointer;color:red">LETRA</div></td>
          <?php } ?>
          <td style="display:none"><?php echo $row['value']; ?></td>
          <td style="display:none"><?php echo $row['letra']; ?></td>
        </tr>
          <?php
        }
        ?>
      </tbody>
    </table>
  </div>
  <table width='98%' align='center' style="border-collapse: collapse;margin-top:4px">
    <tr>
      <td width='30%' style="border: 1px solid black;text-align:right" colspan='2'>TOTAL</td>
      <td width='10%' style="border: 1px solid black;text-align:right;font-size:14px" id='sumatotal'></td>
      <td width='10%' style="border: 1px solid black;text-align:right;font-size:14px;background-color:#f63;" id='sumapendiente'></td>
      <td width='10%' style="border: 1px solid black;text-align:right;font-size:14px" id='sumaacuenta'></td>
      <td width='40%' style="border: 1px solid black;text-align:right" colspan='3'></td>
    </tr>
  </table>
  