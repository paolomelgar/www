<?php
  require_once('../connection.php');
    $sql=mysqli_query($con,"SELECT * FROM dinerodiario WHERE MONTH(fecha)=".$_POST['m']." AND YEAR(fecha)=".$_POST['y']." ORDER BY fecha");
    ?>
    <script type='text/javascript' src='../picnet.table.filter.min.js'></script> 
    <script type="text/javascript">
      $(document).ready(function() {
        $('#table').tableFilter({
          filteredRows: function(filterStates) {
            var totaldia  = 0;
            var creditos  = 0;
            var ingresos  = 0;
            var diferencia  = 0;
            var ingresototal  = 0;
            var contados  = 0;
            var proveedor  = 0;
            var flete  = 0;
            var trans  = 0;
            var serv  = 0;
            var personal  = 0;
            var egresos  = 0;
            var egresototal  = 0;
            var totaldiario  = 0;
            $('#verbody tr').filter(":visible").each(function(){
                creditos = parseFloat(creditos) + parseFloat($(this).find("td:eq(1)").text());        
                ingresos = parseFloat(ingresos) + parseFloat($(this).find("td:eq(2)").text());        
                ingresototal = parseFloat(ingresototal) + parseFloat($(this).find("td:eq(3)").text());        
                contados = parseFloat(contados) + parseFloat($(this).find("td:eq(4)").text());        
                proveedor = parseFloat(proveedor) + parseFloat($(this).find("td:eq(5)").text());        
                flete = parseFloat(flete) + parseFloat($(this).find("td:eq(6)").text());        
                trans = parseFloat(trans) + parseFloat($(this).find("td:eq(7)").text());        
                serv = parseFloat(serv) + parseFloat($(this).find("td:eq(8)").text());        
                personal = parseFloat(personal) + parseFloat($(this).find("td:eq(9)").text());        
                egresos = parseFloat(egresos) + parseFloat($(this).find("td:eq(10)").text());        
                egresototal = parseFloat(egresototal) + parseFloat($(this).find("td:eq(11)").text());        
                totaldiario = parseFloat(totaldiario) + parseFloat($(this).find("td:eq(12)").text());        
            });
            $('#totaldia').text("S/ "+totaldia.toFixed(2)); 
            $('#creditos').text("S/ "+creditos.toFixed(2)); 
            $('#ingresos').text("S/ "+ingresos.toFixed(2)); 
            $('#diferencia').text("S/ "+diferencia.toFixed(2)); 
            $('#ingresototal').text("S/ "+ingresototal.toFixed(2)); 
            $('#contados').text("S/ "+contados.toFixed(2)); 
            $('#proveedor').text("S/ "+proveedor.toFixed(2)); 
            $('#flete').text("S/ "+flete.toFixed(2)); 
            $('#trans').text("S/ "+trans.toFixed(2)); 
            $('#serv').text("S/ "+serv.toFixed(2)); 
            $('#personal').text("S/ "+personal.toFixed(2)); 
            $('#egresos').text("S/ "+egresos.toFixed(2)); 
            $('#egresototal').text("S/ "+egresototal.toFixed(2)); 
            $('#totaldiario').text("S/ "+totaldiario.toFixed(2)); 
          },
          enableCookies: false
        });
      });
    </script>
    <table width="100%" align="left" id="table" class="table table-bordered table-condensed">
      <thead>
        <tr>
          <th class='btn-primary'>&nbsp;</th>
          <th colspan="3"  class='btn-primary' style="text-align:center">INGRESOS</th>
          <th colspan="8" class='btn-primary' style="text-align:center">EGRESOS</th>
          <th class='btn-primary'>&nbsp;</th>
        </tr>
        <tr align="center" style="color:#000">
          <th width="4%" class='btn-warning' style="text-align:center;font-size:12px">DIA</th>
          <th width="10%" class='btn-info' style="text-align:center;font-size:12px">COBRO CREDITOS CLIENTES</th>
          <th width="10%" class='btn-info' style="text-align:center;font-size:12px">OTROS INGRESOS</th>
          <th width="10%" class='btn-info' style="text-align:center;font-size:12px">TOTAL INGRESOS</th>
          <th width="7%" class='btn-success' style="text-align:center;font-size:12px">COMPRAS CONTADO</th>
          <th width="7%" class='btn-success' style="text-align:center;font-size:12px">PAGOS A PROVEEDORES</th>
          <th width="7%" class='btn-success' style="text-align:center;font-size:12px">FLETES</th>
          <th width="7%" class='btn-success' style="text-align:center;font-size:12px">TRANSPORTES</th>
          <th width="7%" class='btn-success' style="text-align:center;font-size:12px">SERV. BASICOS</th>
          <th width="7%" class='btn-success' style="text-align:center;font-size:12px">PERSONAL</th>
          <th width="7%" class='btn-success' style="text-align:center;font-size:12px">OTROS</th>
          <th width="8%" class='btn-success' style="text-align:center;font-size:12px">TOTAL EGRESOS</th>
          <th width="9%" class='btn-danger' style="text-align:center;font-size:12px">TOTAL DIARIO</th>
        </tr>
      </thead>
      <tbody id="verbody">
      <?php 
        while($row=mysqli_fetch_assoc($sql)){
          $sql1=mysqli_query($con,"SELECT creditos,ingresos,contados,proveedor FROM cajamayor WHERE fecha='".$row['fecha']."'");
          $sql2=mysqli_query($con,"SELECT SUM(monto) FROM ingresos WHERE ingreso='EGRESO' AND tipo='FLETES' AND fecha='".$row['fecha']."'");
          $sql3=mysqli_query($con,"SELECT SUM(monto) FROM ingresos WHERE ingreso='EGRESO' AND tipo='TRANSPORTES' AND fecha='".$row['fecha']."'");
          $sql4=mysqli_query($con,"SELECT SUM(monto) FROM ingresos WHERE ingreso='EGRESO' AND tipo='SERV. BASICOS' AND fecha='".$row['fecha']."'");
          $sql5=mysqli_query($con,"SELECT SUM(monto) FROM ingresos WHERE ingreso='EGRESO' AND tipo='PERSONAL' AND fecha='".$row['fecha']."'");
          $sql6=mysqli_query($con,"SELECT SUM(monto) FROM ingresos WHERE ingreso='EGRESO' AND tipo!='FLETES' AND tipo!='TRANSPORTES' AND tipo!='SERV. BASICOS' AND tipo!='PERSONAL' AND fecha='".$row['fecha']."'");
          $s1=mysqli_query($con,"SELECT * FROM adelantos WHERE fecha='".$row['fecha']."' ORDER BY cliente");
          $s2=mysqli_query($con,"SELECT * FROM adelantoscompras WHERE fecha='".$row['fecha']."' ORDER BY proveedor");
          $s3=mysqli_query($con,"SELECT * FROM adelantosletra WHERE fechapago='".$row['fecha']."' ORDER BY proveedor");
          $s4=mysqli_query($con,"SELECT * FROM ingresos WHERE fecha='".$row['fecha']."' AND tipo='FLETES' AND ingreso='EGRESO' ORDER BY detalle");
          $s5=mysqli_query($con,"SELECT * FROM total_compras WHERE fechaingreso='".$row['fecha']."' AND credito='CONTADO' AND entregado='SI' ORDER BY proveedor");
          $s6=mysqli_query($con,"SELECT * FROM ingresos WHERE fecha='".$row['fecha']."' AND tipo='TRANSPORTES' AND ingreso='EGRESO' ORDER BY detalle");
          $s7=mysqli_query($con,"SELECT * FROM ingresos WHERE fecha='".$row['fecha']."' AND tipo='SERV. BASICOS' AND ingreso='EGRESO' ORDER BY detalle");
          $s8=mysqli_query($con,"SELECT * FROM ingresos WHERE fecha='".$row['fecha']."' AND tipo='PERSONAL' AND ingreso='EGRESO' ORDER BY detalle");
          $ro=mysqli_fetch_row($sql1);
          $ro1=mysqli_fetch_row($sql2);
          $ro2=mysqli_fetch_row($sql3);
          $ro3=mysqli_fetch_row($sql4);
          $ro4=mysqli_fetch_row($sql5);
        	$ro5=mysqli_fetch_row($sql6);
          $ingreso=$row['cajareal']+$ro[0]+$ro[1]+$row['egresos'] ;
          $egreso=$ro[2]+$ro[3]+$ro1[0]+$ro2[0];
            ?>
            <tr style="font-size:12px;font-weight:bold">
              <td style="text-align:center" bgcolor="#fcf8e3"><?php echo substr($row['fecha'],-2); ?></td>
              <td style="text-align:right"  bgcolor="#d9edf7" title='<?php while($r1=mysqli_fetch_assoc($s1)){echo $r1['cliente']." : ".$r1['adelanto']."<br/>";}?>'><?php echo number_format($row['creditos']+$ro[0],2,".",""); ?></td>
              <td style="text-align:right"  bgcolor="#d9edf7"><?php echo number_format($row['ingresos']+$ro[1],2,".",""); ?></td>
              <td style="text-align:right;font-size:15px;color:blue" width='10%' bgcolor="#d9edf7"><?php echo number_format($ingreso,2,".",""); ?></td>
              <td style="text-align:right" bgcolor="#dff0d8" title='<?php while($r5=mysqli_fetch_assoc($s5)){if($r5['cambio']>0){echo $r5['proveedor']." : $.".$r5['montototal']."<br/>";}else{echo $r5['proveedor']." : S/. ".$r5['montototal']."<br/>";}}?>'><?php echo number_format($ro[2],2,".",""); ?></td>
              <td style="text-align:right" bgcolor="#dff0d8" title='<?php while($r2=mysqli_fetch_assoc($s2)){if($r2['cambio']>0){echo $r2['proveedor']." : $.".$r2['adelanto']."<br/>";}else{echo $r2['proveedor']." : S/. ".$r2['adelanto']."<br/>";}} while($r3=mysqli_fetch_assoc($s3)){if($r3['cambio']>0){echo $r3['proveedor']." : $. ".$r3['adelanto']." - LETRA<br/>";}else{echo $r3['proveedor']." : S/. ".$r3['adelanto']." - LETRA<br/>";}} ?>'><?php echo number_format($ro[3],2,".",""); ?></td>
              <td style="text-align:right" bgcolor="#dff0d8" title='<?php while($r4=mysqli_fetch_assoc($s4)){echo $r4['monto']." - ".$r4['detalle']."<br/>"; } ?>'><?php echo number_format($ro1[0]+0,2,".",""); ?></td>
              <td style="text-align:right" bgcolor="#dff0d8" title='<?php while($r6=mysqli_fetch_assoc($s6)){echo $r6['monto']." - ".$r6['detalle']."<br/>"; } ?>'><?php echo number_format($ro2[0]+0,2,".",""); ?></td>
              <td style="text-align:right" bgcolor="#dff0d8" title='<?php while($r7=mysqli_fetch_assoc($s7)){echo $r7['monto']." - ".$r7['detalle']."<br/>"; } ?>'><?php echo number_format($ro3[0]+0,2,".",""); ?></td>
              <td style="text-align:right" bgcolor="#dff0d8" title='<?php while($r8=mysqli_fetch_assoc($s8)){echo $r8['monto']." - ".$r8['detalle']."<br/>"; } ?>'><?php echo number_format($ro4[0]+0,2,".",""); ?></td>
              <td style="text-align:right" bgcolor="#dff0d8"><?php echo number_format($ro5[0]+0,2,".",""); ?></td>
              <td style="text-align:right;font-size:15px;color:blue" bgcolor="#dff0d8"><?php echo number_format($egreso,2,".",""); ?></td>
              <td style="text-align:right"  bgcolor="#f2dede"><?php echo number_format($ingreso-$egreso,2,".",""); ?></td>
            </tr>
            <?php
      }
    ?>
      </tbody>
      <tfoot>
        <tr align="center" style='font-size:14px'>
          <th style="text-align:right" class='btn-warning'></th>
          <th style="text-align:right"  class='btn-info' id='creditos'></th>
          <th style="text-align:right"  class='btn-info' id='ingresos'></th>
          <th style="text-align:right"  class='btn-info' id='ingresototal'></th>
          <th style="text-align:right" class='btn-success' id='contados'></th>
          <th style="text-align:right" class='btn-success' id='proveedor'></th>
          <th style="text-align:right" class='btn-success' id='flete'></th>
          <th style="text-align:right" class='btn-success' id='trans'></th>
          <th style="text-align:right" class='btn-success' id='serv'></th>
          <th style="text-align:right" class='btn-success' id='personal'></th>
          <th style="text-align:right" class='btn-success' id='egresos'></th>
          <th style="text-align:right" class='btn-success' id='egresototal'></th>
          <th style="text-align:right"  class='btn-danger' id='totaldiario'></th>
        </tr>
      </tfoot>
    </table>