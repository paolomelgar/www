<?php
  require_once('../connection.php');
    $ini = date('Y-m-d', strtotime(str_replace('/', '-', $_POST['ini'])));
    $fin = date('Y-m-d', strtotime(str_replace('/', '-', $_POST['fin'])));
    $query="";
    if($_POST['estado']=='CANCELADO'){
      $query.="('$ini' <= fecha AND fecha <= '$fin') AND credito='CANCELADO'";
    }
    else{
      $query.="credito='CREDITO'";
    }
    if(isset($_POST['cliente']) && !empty($_POST['cliente'])){
      $query.=" AND cliente='".$_POST['cliente']."'";
    }
    if($_SESSION['cargo']=='ADMIN' ||  $_SESSION['cargo']=='ENCARGADOTIENDA' || $_SESSION['cargo']=='ASISTENTE' || $_SESSION['cargo']=='LOGISTICA'){
      $sql=mysqli_query($con,"SELECT * FROM total_ventas WHERE $query AND entregado='SI' ORDER BY fecha,hora");
    }
    else{
      $sql=mysqli_query($con,"SELECT * FROM total_ventas WHERE $query AND entregado='SI' AND vendedor='".$_SESSION['nombre']."' ORDER BY fecha,hora");
    }
    $q=mysqli_query($con,"SELECT * FROM letra WHERE $query ORDER BY fecha,value");
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
              sumatotal =  parseFloat(sumatotal) +  parseFloat($(this).find("td:eq(4)").text());        
              sumapendiente =   parseFloat(sumapendiente) +  parseFloat($(this).find("td:eq(5)").text());
              sumaacuenta =   parseFloat(sumaacuenta) +  parseFloat($(this).find("td:eq(6)").text());
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
          <th width="2%" style="border: 1px solid white;"></th>
          <th width="10%" style="border: 1px solid white;">VENDEDOR</th>
          <th width="5%" style="border: 1px solid white;">SERIE</th>
          <th width="20%" style="border: 1px solid white;">CLIENTE</th>
          <th width="10%" style="border: 1px solid white;">TOTAL</th>
          <th width="10%" style="border: 1px solid white;">PENDIENTE</th>
          <th width="10%" style="border: 1px solid white;">ADELANTO</th>
          <th width="8%" style="border: 1px solid white;">F. EMISION</th>
          <th width="8%" style="border: 1px solid white;">F. VENCIM</th>
          <th width="4%" style="border: 1px solid white;">DIAS</th>
          <th width="8%" style="border: 1px solid white;">DETALLES</th>
          <?php if($_SESSION['cargo']=='ADMIN' || $_SESSION['cargo']=='ASISTENTE' || $_SESSION['cargo']=='ENCARGADOTIENDA'){ ?>
          <th width="5%" style="border: 1px solid white;">COBRAR</th>
          <?php } ?>
        </tr>
      </thead>
    </table>
    <div style="overflow:auto;height:40%;align:center">
      <table width='98%' id="venta" style="border-collapse: collapse;" align='center'>
        <thead style='background-color:#2E9AFE'>
          <tr style="display:none;" >
            <th width="2%" style="border: 1px solid white;"></th>
            <th width="10%" style="border: 1px solid white;">VENDEDOR</th>
            <th width="5%" style="border: 1px solid white;">SERIE</th>
            <th width="20%" style="border: 1px solid white;">CLIENTE</th>
            <th width="10%" style="border: 1px solid white;">TOTAL</th>
            <th width="10%" style="border: 1px solid white;">PENDIENTE</th>
            <th width="10%" style="border: 1px solid white;">ADELANTO</th>
            <th width="8%" style="border: 1px solid white;">F. EMISION</th>
            <th width="8%" style="border: 1px solid white;">F. VENCIM</th>
            <th width="4%" style="border: 1px solid white;">DIAS</th>
            <th width="8%" style="border: 1px solid white;">DETALLES</th>
            <th width="8%" style="border: 1px solid white;display:none">DETALLES</th>
            <?php if($_SESSION['cargo']=='ADMIN' || $_SESSION['cargo']=='ASISTENTE'|| $_SESSION['cargo']=='ENCARGADOTIENDA'){ ?>
            <th width="5%" style="border: 1px solid white;">COBRAR</th>
            <?php } ?>
          </tr>
        </thead>
        <tbody id="verbody">
        <?php 
        while($row=mysqli_fetch_assoc($sql)){
          $interval=strtotime($row['fecha'])-strtotime(date("Y-m-d"));
          $diferencia=-intval($interval/60/60/24);
          if((strtotime(date("Y-m-d"))-strtotime($row['fecha']))>60*60*24*45){
            $as= "style='font-size:12px;font-weight:bold;background-color:#FF8B8B'";
          }else if((strtotime(date("Y-m-d"))-strtotime($row['fecha']))>60*60*24*30 && (strtotime(date("Y-m-d"))-strtotime($row['fecha']))<=60*60*24*60){
            $as= "style='font-size:12px;font-weight:bold;background-color:#EFFF82'";
          }else{
            $as= "style='font-size:12px;font-weight:bold;background-color:#74FF64'";
          }
          ?>
          <tr <?php echo $as; ?>>
            <td width="2%" style="border: 1px solid black;"><input type='checkbox' class='check'></td>
            <td width="10%" style="border: 1px solid black;"><?php echo substr($row['vendedor'],0,15); ?></td>
            <td width="5%" style="border: 1px solid black;text-align:center" align='right'><?php echo $row['serieventas']; ?></td>
            <td width="20%" style="border: 1px solid black;"><?php echo $row['cliente']; ?></td>
            <td width="10%" style="border: 1px solid black;" align='right'><?php echo $row['total']; ?></td>
            <td width="10%" style="border: 1px solid black;background-color:#f63;color:blue;font-size:14px" align='right'><?php echo $row['pendiente']; ?></td>
            <td width="10%" style="border: 1px solid black;" align='right'><?php echo $row['acuenta']; ?></td>
            <td width="8%" style="border: 1px solid black;" align='center'><?php echo $row['fecha']; ?></td>
            <td width="8%" style="border: 1px solid black;" align='center'><?php echo $row['fechapago']; ?></td>
            <td width="6%" style="border: 1px solid black;" align='center'><?php echo $diferencia; ?></td>
            <td width="8%" style="border: 1px solid black;" align='center'><div class="detail" style="cursor:pointer;color:red">DETALLES</div></td>
            <td width="20%" style="border: 1px solid black;display:none"><?php echo $row['ruc']; ?></td>
            <?php if($_SESSION['cargo']=='ADMIN' || $_SESSION['cargo']=='ASISTENTE' || $_SESSION['cargo']=='ENCARGADOTIENDA'){ ?>
            <td width="5%" style="border: 1px solid black;" align='center'><div class="cobrar" style="cursor:pointer;color:red">COBRAR</div></td>
            <?php } ?>
          </tr>
          <?php
        }
        while($ro=mysqli_fetch_assoc($q)){
          $sqll=mysqli_query($con,"SELECT fechapago FROM letraclientes WHERE value='".$ro['value']."' AND pendiente='SI' ORDER BY fechapago LIMIT 1");
          $f=mysqli_fetch_row($sqll);
          $interval=strtotime($f[0])-strtotime(date("Y-m-d"));
          $diferencia=-intval($interval/60/60/24);
          ?>
          <tr style="font-size:12px;font-weight:bold">
            <td width="2%" style="border: 1px solid black;"></td>
            <td width="10%" style="border: 1px solid black;"></td>
            <td width="5%" style="border: 1px solid black;text-align:center" align='right'><?php echo $ro['value']; ?></td>
            <td width="20%" style="border: 1px solid black;"><?php echo $ro['cliente']; ?></td>
            <td width="10%" style="border: 1px solid black;" align='right'><?php echo $ro['total']; ?></td>
            <td width="10%" style="border: 1px solid black;background-color:#f63;color:blue;font-size:14px" align='right'><?php echo $ro['pendiente']; ?></td>
            <td width="10%" style="border: 1px solid black;" align='right'><?php echo $ro['adelanto']; ?></td>
            <td width="8%" style="border: 1px solid black;" align='center'><?php echo $ro['fecha']; ?></td>
            <td width="8%" style="border: 1px solid black;" align='center'><?php echo $f[0]; ?></td>
            <td width="6%" style="border: 1px solid black;" align='center'><?php echo $diferencia; ?></td>
            <td width="8%" style="border: 1px solid black;" align='center'><div class="detailletra" style="cursor:pointer;color:red">LETRA</div></td>
            <td width="20%" style="border: 1px solid black;display:none"></td>
            <?php if($_SESSION['cargo']=='ADMIN' || $_SESSION['cargo']=='ASISTENTE' || $_SESSION['cargo']=='ENCARGADOTIENDA'){ ?>
            <td width="5%" style="border: 1px solid black;" align='center'><div class="cobrarletra" style="cursor:pointer;color:red">COBRAR</div></td>
            <?php } ?>
          </tr>
          <?php
        }
        ?>
        </tbody>
      </table>
    </div>
    <table width='98%' align='center' style="border-collapse: collapse;margin-top:4px">
      <tr>
        <td width='35%' style="border: 1px solid black;text-align:right" colspan='3'>TOTAL</td>
        <td width='10%' style="border: 1px solid black;text-align:right" id='sumatotal'></td>
        <td width='10%' style="border: 1px solid black;text-align:right;background-color:#f63;" id='sumapendiente'></td>
        <td width='10%' style="border: 1px solid black;text-align:right" id='sumaacuenta'></td>
        <td width='35%' style="border: 1px solid black;text-align:right" colspan='4'></td>
      </tr>
    </table>
