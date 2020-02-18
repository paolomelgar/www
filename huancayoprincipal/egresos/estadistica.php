<html>
<?php
set_time_limit(60);
require_once('../connection.php');
$a=array();
$b=array();
$d=array();
$array=array();
$i=0;
switch ($_POST['t']) {
	case 'todo':
		for($j=0;$j<12;$j++){
			$quer = mysqli_query($con,"SELECT SUM(monto) FROM ingresos WHERE ingreso='EGRESO' AND MONTH(fecha)='".($j+1)."' AND YEAR(fecha)='".$_POST['y']."' AND ingreso!='ANULADO'");
			$rr=mysqli_fetch_row($quer);
			$a[$j]=$rr[0];
			switch ($j) {
				case '0':
					$b[$j]="ENERO";
				break;
				case '1':
					$b[$j]="FEBRERO";
				break;
				case '2':
					$b[$j]="MARZO";
				break;
				case '3':
					$b[$j]="ABRIL";
				break;
				case '4':
					$b[$j]="MAYO";
				break;
				case '5':
					$b[$j]="JUNIO";
				break;
				case '6':
					$b[$j]="JULIO";
				break;
				case '7':
					$b[$j]="AGOSTO";
				break;
				case '8':
					$b[$j]="SETIEMBRE";
				break;
				case '9':
					$b[$j]="OCTUBRE";
				break;
				case '10':
					$b[$j]="NOVIEMBRE";
				break;
				case '11':
					$b[$j]="DICIEMBRE";
				break;
				default:
				break;
			}
		}
		$d[0]='mensual';
	break;
	case 'balance':
	$m=$_POST['m']+1;
		$quer1 = mysqli_query($con,"SELECT SUM(monto) FROM ingresos WHERE tipo='PERSONAL' AND MONTH(fecha)='".$m."' AND YEAR(fecha)='".$_POST['y']."' AND ingreso='EGRESO'");
		$quer2 = mysqli_query($con,"SELECT SUM(monto) FROM ingresos WHERE tipo='TRANSPORTE INGRESO' AND MONTH(fecha)='".$m."' AND YEAR(fecha)='".$_POST['y']."' AND ingreso='EGRESO'");
		$quer3 = mysqli_query($con,"SELECT SUM(monto) FROM ingresos WHERE tipo='SERVICIOS' AND MONTH(fecha)='".$m."' AND YEAR(fecha)='".$_POST['y']."' AND ingreso='EGRESO'");
		$quer4 = mysqli_query($con,"SELECT SUM(monto) FROM ingresos WHERE tipo='TRANSPORTE SALIDA' AND MONTH(fecha)='".$m."' AND YEAR(fecha)='".$_POST['y']."' AND ingreso='EGRESO'");
		$quer5 = mysqli_query($con,"SELECT SUM(monto) FROM ingresos WHERE tipo='GASTOS TRIBUTARIOS' AND MONTH(fecha)='".$m."' AND YEAR(fecha)='".$_POST['y']."' AND ingreso='EGRESO'");
		$quer6 = mysqli_query($con,"SELECT SUM(monto) FROM ingresos WHERE tipo='CONSTRUCCION' AND MONTH(fecha)='".$m."' AND YEAR(fecha)='".$_POST['y']."' AND ingreso='EGRESO'");
		$quer7 = mysqli_query($con,"SELECT SUM(monto) FROM ingresos WHERE tipo='GASTOS FINANCIEROS' AND MONTH(fecha)='".$m."' AND YEAR(fecha)='".$_POST['y']."' AND ingreso='EGRESO'");
		$quer8 = mysqli_query($con,"SELECT SUM(monto) FROM ingresos WHERE tipo='GASTOS ADMINISTRATIVOS' AND MONTH(fecha)='".$m."' AND YEAR(fecha)='".$_POST['y']."' AND ingreso='EGRESO'");
		$quer9 = mysqli_query($con,"SELECT SUM(monto) FROM ingresos WHERE tipo='GASTOS TIENDA' AND MONTH(fecha)='".$m."' AND YEAR(fecha)='".$_POST['y']."' AND ingreso='EGRESO'");
		$quer10= mysqli_query($con,"SELECT SUM(monto) FROM ingresos WHERE tipo='UTILES ESCRITORIO' AND MONTH(fecha)='".$m."' AND YEAR(fecha)='".$_POST['y']."' AND ingreso='EGRESO'");
		$quer11= mysqli_query($con,"SELECT SUM(monto) FROM ingresos WHERE tipo='MARKETING' AND MONTH(fecha)='".$m."' AND YEAR(fecha)='".$_POST['y']."' AND ingreso='EGRESO'");
		$quer12= mysqli_query($con,"SELECT SUM(monto) FROM ingresos WHERE tipo='FRANQUICIAS' AND MONTH(fecha)='".$m."' AND YEAR(fecha)='".$_POST['y']."' AND ingreso='EGRESO'");
		$quer13= mysqli_query($con,"SELECT SUM(monto) FROM ingresos WHERE tipo='INTERES' AND MONTH(fecha)='".$m."' AND YEAR(fecha)='".$_POST['y']."' AND ingreso='EGRESO'");
		$quer14= mysqli_query($con,"SELECT SUM(monto) FROM ingresos WHERE tipo='COMPARTIR PERSONAL' AND MONTH(fecha)='".$m."' AND YEAR(fecha)='".$_POST['y']."' AND ingreso='EGRESO'");
		$quer15= mysqli_query($con,"SELECT SUM(monto) FROM ingresos WHERE tipo='DESCUENTOS CLIENTES' AND MONTH(fecha)='".$m."' AND YEAR(fecha)='".$_POST['y']."' AND ingreso='EGRESO'");
		$quer16= mysqli_query($con,"SELECT SUM(monto) FROM ingresos WHERE tipo='SOFTWARE' AND MONTH(fecha)='".$m."' AND YEAR(fecha)='".$_POST['y']."' AND ingreso='EGRESO'");
		$quer17= mysqli_query($con,"SELECT SUM(monto) FROM ingresos WHERE tipo='HERRAMIENTAS TRABAJO' AND MONTH(fecha)='".$m."' AND YEAR(fecha)='".$_POST['y']."' AND ingreso='EGRESO'");
		$quer18= mysqli_query($con,"SELECT SUM(monto) FROM ingresos WHERE tipo='LIMPIEZA' AND MONTH(fecha)='".$m."' AND YEAR(fecha)='".$_POST['y']."' AND ingreso='EGRESO'");
		$quer19= mysqli_query($con,"SELECT SUM(monto) FROM ingresos WHERE tipo='COLABORACION' AND MONTH(fecha)='".$m."' AND YEAR(fecha)='".$_POST['y']."' AND ingreso='EGRESO'");
		$quer20= mysqli_query($con,"SELECT SUM(monto) FROM ingresos WHERE tipo='OTROS' AND MONTH(fecha)='".$m."' AND YEAR(fecha)='".$_POST['y']."' AND ingreso='EGRESO'");
		$quer21= mysqli_query($con,"SELECT SUM(monto) FROM ingresos WHERE tipo='VIAT VENTAS LOCAL' AND MONTH(fecha)='".$m."' AND YEAR(fecha)='".$_POST['y']."' AND ingreso='EGRESO'");
		$quer22= mysqli_query($con,"SELECT SUM(monto) FROM ingresos WHERE tipo='VIAT VENTAS PROVIN' AND MONTH(fecha)='".$m."' AND YEAR(fecha)='".$_POST['y']."' AND ingreso='EGRESO'");
		$quer23= mysqli_query($con,"SELECT SUM(monto) FROM ingresos WHERE tipo='VIAT REPARTO LOCAL' AND MONTH(fecha)='".$m."' AND YEAR(fecha)='".$_POST['y']."' AND ingreso='EGRESO'");
		$quer24= mysqli_query($con,"SELECT SUM(monto) FROM ingresos WHERE tipo='VIAT REPARTO PROVIN' AND MONTH(fecha)='".$m."' AND YEAR(fecha)='".$_POST['y']."' AND ingreso='EGRESO'");
		$quer25= mysqli_query($con,"SELECT SUM(monto) FROM ingresos WHERE tipo='INTERES PRESTAMO' AND MONTH(fecha)='".$m."' AND YEAR(fecha)='".$_POST['y']."' AND ingreso='EGRESO'");
		$quer26= mysqli_query($con,"SELECT SUM(monto) FROM ingresos WHERE tipo='REMODELACION' AND MONTH(fecha)='".$m."' AND YEAR(fecha)='".$_POST['y']."' AND ingreso='EGRESO'");
		$quer27= mysqli_query($con,"SELECT SUM(monto) FROM ingresos WHERE tipo='CAPACITACION' AND MONTH(fecha)='".$m."' AND YEAR(fecha)='".$_POST['y']."' AND ingreso='EGRESO'");
		$quer28= mysqli_query($con,"SELECT SUM(pendiente) FROM total_ventas WHERE credito='CREDITO' AND entregado='SI'");
		$quer29= mysqli_query($con,"SELECT SUM(pendiente) FROM total_compras WHERE credito='CREDITO' AND entregado='SI' AND billete='SOLES'");
		$quer30= mysqli_query($con,"SELECT SUM(pendiente*cambio) FROM total_compras WHERE credito='CREDITO' AND entregado='SI' AND billete='DOLARES'");
		$quer31= mysqli_query($con,"SELECT SUM(monto) FROM prestamos WHERE pendiente='SI'");
		$r1=mysqli_fetch_row($quer1);
		$r2=mysqli_fetch_row($quer2);
		$r3=mysqli_fetch_row($quer3);
		$r4=mysqli_fetch_row($quer4);
		$r5=mysqli_fetch_row($quer5);
		$r6=mysqli_fetch_row($quer6);
		$r7=mysqli_fetch_row($quer7);
		$r8=mysqli_fetch_row($quer8);
		$r9=mysqli_fetch_row($quer9);
		$r10=mysqli_fetch_row($quer10);
		$r11=mysqli_fetch_row($quer11);
		$r12=mysqli_fetch_row($quer12);
		$r13=mysqli_fetch_row($quer13);
		$r14=mysqli_fetch_row($quer14);
		$r15=mysqli_fetch_row($quer15);
		$r16=mysqli_fetch_row($quer16);
		$r17=mysqli_fetch_row($quer17);
		$r18=mysqli_fetch_row($quer18);
		$r19=mysqli_fetch_row($quer19);
		$r20=mysqli_fetch_row($quer20);
		$r21=mysqli_fetch_row($quer21);
		$r22=mysqli_fetch_row($quer22);
		$r23=mysqli_fetch_row($quer23);
		$r24=mysqli_fetch_row($quer24);
		$r25=mysqli_fetch_row($quer25);
		$r26=mysqli_fetch_row($quer26);
		$r27=mysqli_fetch_row($quer27);
		$ar=array();
      	$ar[0]=number_format($r1[0]+0, 2, '.', '');
      	$ar[1]=number_format($r2[0]+0, 2, '.', '');
      	$ar[2]=number_format($r3[0]+0, 2, '.', '');
      	$ar[3]=number_format($r4[0]+0, 2, '.', '');
      	$ar[4]=number_format($r5[0]+0, 2, '.', '');
      	$ar[5]=number_format($r6[0]+0, 2, '.', '');
      	$ar[6]=number_format($r7[0]+0, 2, '.', '');
      	$ar[7]=number_format($r8[0]+0, 2, '.', '');
      	$ar[8]=number_format($r9[0]+0, 2, '.', '');
      	$ar[9]=number_format($r10[0]+0, 2, '.', '');
      	$ar[10]=number_format($r11[0]+0, 2, '.', '');
      	$ar[11]=number_format($r12[0]+0, 2, '.', '');
      	$ar[12]=number_format($r13[0]+0, 2, '.', '');
      	$ar[13]=number_format($r14[0]+0, 2, '.', '');
      	$ar[14]=number_format($r15[0]+0, 2, '.', '');
      	$ar[15]=number_format($r16[0]+0, 2, '.', '');
      	$ar[16]=number_format($r17[0]+0, 2, '.', '');
      	$ar[17]=number_format($r18[0]+0, 2, '.', '');
      	$ar[18]=number_format($r19[0]+0, 2, '.', '');
      	$ar[19]=number_format($r20[0]+0, 2, '.', '');
      	$ar[20]=number_format($r21[0]+0, 2, '.', '');
      	$ar[21]=number_format($r22[0]+0, 2, '.', '');
      	$ar[22]=number_format($r23[0]+0, 2, '.', '');
      	$ar[23]=number_format($r24[0]+0, 2, '.', '');
      	$ar[24]=number_format($r25[0]+0, 2, '.', '');
      	$ar[25]=number_format($r26[0]+0, 2, '.', '');
      	$ar[26]=number_format($r27[0]+0, 2, '.', '');
      	$ar[27]=number_format($r1[0]+$r2[0]+$r3[0]+$r4[0]+$r5[0]+$r6[0]+$r7[0]+$r8[0]+$r9[0]+$r10[0]+$r11[0]+$r12[0]+$r13[0]+$r14[0]+$r15[0]+$r16[0]+$r17[0]+$r18[0]+$r19[0]+$r20[0]+$r21[0]+$r22[0]+$r23[0]+$r24[0]+$r25[0]+$r26[0]+$r27[0]+0, 2, '.', '');
		?>
		<table>
			<tr>
				<td width='30%' valign='top'>
					<div id='productos' style='overflow:auto;height:100%;'>
						<table border='1' width='100%'>
							<thead>
								<tr bgcolor="#428bca" style='font-weight: bold'><td align='center' width='32%'>MONTO</td><td align='center' width='36%'>TOTAL</td></tr>
							</thead>
							<tbody id='res'>
								<tr><td align='center' style='color:black'>PERSONAL</td><td align='center' class='text' contenteditable='true' style='color:red;font-weight:bold'><?php echo $ar[0]; ?></td></tr>
								<tr><td align='center' style='color:black'>TRANSPORTE INGRESO</td><td align='center' class='text' contenteditable='true' style='color:red;font-weight:bold'><?php echo $ar[1]; ?></td></tr>
								<tr><td align='center' style='color:black'>SERVICIOS</td><td align='center' class='text' contenteditable='true' style='color:red;font-weight:bold'><?php echo $ar[2]; ?></td></tr>
								<tr><td align='center' style='color:black'>TRANSPORTE SALIDA</td><td align='center' class='text' contenteditable='true' style='color:red;font-weight:bold'><?php echo $ar[3]; ?></td></tr>
								<tr><td align='center' style='color:black'>GASTOS TRIBUTARIOS</td><td align='center' class='text' contenteditable='true' style='color:red;font-weight:bold'><?php echo $ar[4]; ?></td></tr>
								<tr><td align='center' style='color:black'>CONSTRUCCION</td><td align='center' class='text' contenteditable='true' style='color:red;font-weight:bold'><?php echo $ar[5]; ?></td></tr>
								<tr><td align='center' style='color:black'>GASTOS FINANCIEROS</td><td align='center' class='text' contenteditable='true' style='color:red;font-weight:bold'><?php echo $ar[6]; ?></td></tr>
								<tr><td align='center' style='color:black'>GASTOS ADMINISTRATIVOS</td><td align='center' class='text' contenteditable='true' style='color:red;font-weight:bold'><?php echo $ar[7]; ?></td></tr>
								<tr><td align='center' style='color:black'>GASTOS TIENDA</td><td align='center' class='text' contenteditable='true' style='color:red;font-weight:bold'><?php echo $ar[8]; ?></td></tr>
								<tr><td align='center' style='color:black'>REMODELACION</td><td align='center' class='text' contenteditable='true' style='color:red;font-weight:bold'><?php echo $ar[25]; ?></td></tr>
								<tr><td align='center' style='color:black'>CAPACITACION</td><td align='center' class='text' contenteditable='true' style='color:red;font-weight:bold'><?php echo $ar[26]; ?></td></tr>
								<tr><td align='center' style='color:black'>VIAT VENTAS LOCAL</td><td align='center' class='text' contenteditable='true' style='color:red;font-weight:bold'><?php echo $ar[20]; ?></td></tr>
								<tr><td align='center' style='color:black'>VIAT VENTAS PROVINCIA</td><td align='center' class='text' contenteditable='true' style='color:red;font-weight:bold'><?php echo $ar[21]; ?></td></tr>
								<tr><td align='center' style='color:black'>VIAT REPARTO LOCAL</td><td align='center' class='text' contenteditable='true' style='color:red;font-weight:bold'><?php echo $ar[22]; ?></td></tr>
								<tr><td align='center' style='color:black'>VIAT REPARTO PROVINCIA</td><td align='center' class='text' contenteditable='true' style='color:red;font-weight:bold'><?php echo $ar[23]; ?></td></tr>
								<tr><td align='center' style='color:black'>UTILES ESCRITORIO</td><td align='center' class='text' contenteditable='true' style='color:red;font-weight:bold'><?php echo $ar[9]; ?></td></tr>
								<tr><td align='center' style='color:black'>MARKETING</td><td align='center' class='text' contenteditable='true' style='color:red;font-weight:bold'><?php echo $ar[10]; ?></td></tr>
								<tr><td align='center' style='color:black'>FRANQUICIAS</td><td align='center' class='text' contenteditable='true' style='color:red;font-weight:bold'><?php echo $ar[11]; ?></td></tr>
								<tr><td align='center' style='color:black'>INTERES PRESTAMO</td><td align='center' class='text' contenteditable='true' style='color:red;font-weight:bold'><?php echo $ar[24]; ?></td></tr>
								<tr><td align='center' style='color:black'>INTERES</td><td align='center' class='text' contenteditable='true' style='color:red;font-weight:bold'><?php echo $ar[12]; ?></td></tr>
								<tr><td align='center' style='color:black'>COMPARTIR PERSONAL</td><td align='center' class='text' contenteditable='true' style='color:red;font-weight:bold'><?php echo $ar[13]; ?></td></tr>
								<tr><td align='center' style='color:black'>DESCUENTOS CLIENTES</td><td align='center' class='text' contenteditable='true' style='color:red;font-weight:bold'><?php echo $ar[14]; ?></td></tr>
								<tr><td align='center' style='color:black'>SOFTWARE</td><td align='center' class='text' contenteditable='true' style='color:red;font-weight:bold'><?php echo $ar[15]; ?></td></tr>
								<tr><td align='center' style='color:black'>HERRAMIENTAS TRABAJO</td><td align='center' class='text' contenteditable='true' style='color:red;font-weight:bold'><?php echo $ar[16]; ?></td></tr>
								<tr><td align='center' style='color:black'>LIMPIEZA</td><td align='center' class='text' contenteditable='true' style='color:red;font-weight:bold'><?php echo $ar[17]; ?></td></tr>
								<tr><td align='center' style='color:black'>COLABORACION</td><td align='center' class='text' contenteditable='true' style='color:red;font-weight:bold'><?php echo $ar[18]; ?></td></tr>
								<tr><td align='center' style='color:black'>OTROS</td><td align='center' class='text' contenteditable='true' style='color:red;font-weight:bold'><?php echo $ar[19]; ?></td></tr>
								<tr><td align='center' style='color:black'>TOTAL</td><td align='center' class='text' contenteditable='true' style='color:red;font-weight:bold'><?php echo $ar[27]; ?></td></tr>
							</tbody>
						</table>
					</div>
				</td>
			</tr>
		</table>
		<?php
	break;
	case 'personal':
	for($j=0;$j<12;$j++){
			$quer = mysqli_query($con,"SELECT SUM(monto) FROM ingresos WHERE tipo='PERSONAL' AND MONTH(fecha)='".($j+1)."' AND YEAR(fecha)='".$_POST['y']."' AND ingreso!='ANULADO'");
			$rr=mysqli_fetch_row($quer);
			$a[$j]=$rr[0];
			switch ($j) {
				case '0':
					$b[$j]="ENERO";
				break;
				case '1':
					$b[$j]="FEBRERO";
				break;
				case '2':
					$b[$j]="MARZO";
				break;
				case '3':
					$b[$j]="ABRIL";
				break;
				case '4':
					$b[$j]="MAYO";
				break;
				case '5':
					$b[$j]="JUNIO";
				break;
				case '6':
					$b[$j]="JULIO";
				break;
				case '7':
					$b[$j]="AGOSTO";
				break;
				case '8':
					$b[$j]="SETIEMBRE";
				break;
				case '9':
					$b[$j]="OCTUBRE";
				break;
				case '10':
					$b[$j]="NOVIEMBRE";
				break;
				case '11':
					$b[$j]="DICIEMBRE";
				break;
				default:
				break;
			}
		}
		$d[0]='mensual';
	break;
	case 'servicios':
	for($j=0;$j<12;$j++){
			$quer = mysqli_query($con,"SELECT SUM(monto) FROM ingresos WHERE tipo='SERVICIOS' AND MONTH(fecha)='".($j+1)."' AND YEAR(fecha)='".$_POST['y']."' AND ingreso!='ANULADO'");
			$rr=mysqli_fetch_row($quer);
			$a[$j]=$rr[0];
			switch ($j) {
				case '0':
					$b[$j]="ENERO";
				break;
				case '1':
					$b[$j]="FEBRERO";
				break;
				case '2':
					$b[$j]="MARZO";
				break;
				case '3':
					$b[$j]="ABRIL";
				break;
				case '4':
					$b[$j]="MAYO";
				break;
				case '5':
					$b[$j]="JUNIO";
				break;
				case '6':
					$b[$j]="JULIO";
				break;
				case '7':
					$b[$j]="AGOSTO";
				break;
				case '8':
					$b[$j]="SETIEMBRE";
				break;
				case '9':
					$b[$j]="OCTUBRE";
				break;
				case '10':
					$b[$j]="NOVIEMBRE";
				break;
				case '11':
					$b[$j]="DICIEMBRE";
				break;
				default:
				break;
			}
		}
		$d[0]='mensual';
	break;
	case 'colaboracion':
		for($j=0;$j<12;$j++){
			$quer = mysqli_query($con,"SELECT SUM(monto) FROM ingresos WHERE tipo='COLABORACION' AND MONTH(fecha)='".($j+1)."' AND YEAR(fecha)='".$_POST['y']."' AND ingreso!='ANULADO'");
			$rr=mysqli_fetch_row($quer);
			$a[$j]=$rr[0];
			switch ($j) {
				case '0':
					$b[$j]="ENERO";
				break;
				case '1':
					$b[$j]="FEBRERO";
				break;
				case '2':
					$b[$j]="MARZO";
				break;
				case '3':
					$b[$j]="ABRIL";
				break;
				case '4':
					$b[$j]="MAYO";
				break;
				case '5':
					$b[$j]="JUNIO";
				break;
				case '6':
					$b[$j]="JULIO";
				break;
				case '7':
					$b[$j]="AGOSTO";
				break;
				case '8':
					$b[$j]="SETIEMBRE";
				break;
				case '9':
					$b[$j]="OCTUBRE";
				break;
				case '10':
					$b[$j]="NOVIEMBRE";
				break;
				case '11':
					$b[$j]="DICIEMBRE";
				break;
				default:
				break;
			}
		}
		$d[0]='mensual';
	break;
	case 'limpieza':
	for($j=0;$j<12;$j++){
			$quer = mysqli_query($con,"SELECT SUM(monto) FROM ingresos WHERE tipo='LIMPIEZA' AND MONTH(fecha)='".($j+1)."' AND YEAR(fecha)='".$_POST['y']."' AND ingreso!='ANULADO'");
			$rr=mysqli_fetch_row($quer);
			$a[$j]=$rr[0];
			switch ($j) {
				case '0':
					$b[$j]="ENERO";
				break;
				case '1':
					$b[$j]="FEBRERO";
				break;
				case '2':
					$b[$j]="MARZO";
				break;
				case '3':
					$b[$j]="ABRIL";
				break;
				case '4':
					$b[$j]="MAYO";
				break;
				case '5':
					$b[$j]="JUNIO";
				break;
				case '6':
					$b[$j]="JULIO";
				break;
				case '7':
					$b[$j]="AGOSTO";
				break;
				case '8':
					$b[$j]="SETIEMBRE";
				break;
				case '9':
					$b[$j]="OCTUBRE";
				break;
				case '10':
					$b[$j]="NOVIEMBRE";
				break;
				case '11':
					$b[$j]="DICIEMBRE";
				break;
				default:
				break;
			}
		}
		$d[0]='mensual';
	break;
	case 'gastos':
		for($j=0;$j<12;$j++){
			$quer = mysqli_query($con,"SELECT SUM(monto) FROM ingresos WHERE tipo='GASTOS TIENDA' AND MONTH(fecha)='".($j+1)."' AND YEAR(fecha)='".$_POST['y']."' AND ingreso!='ANULADO'");
			$rr=mysqli_fetch_row($quer);
			$a[$j]=$rr[0];
			switch ($j) {
				case '0':
					$b[$j]="ENERO";
				break;
				case '1':
					$b[$j]="FEBRERO";
				break;
				case '2':
					$b[$j]="MARZO";
				break;
				case '3':
					$b[$j]="ABRIL";
				break;
				case '4':
					$b[$j]="MAYO";
				break;
				case '5':
					$b[$j]="JUNIO";
				break;
				case '6':
					$b[$j]="JULIO";
				break;
				case '7':
					$b[$j]="AGOSTO";
				break;
				case '8':
					$b[$j]="SETIEMBRE";
				break;
				case '9':
					$b[$j]="OCTUBRE";
				break;
				case '10':
					$b[$j]="NOVIEMBRE";
				break;
				case '11':
					$b[$j]="DICIEMBRE";
				break;
				default:
				break;
			}
		}
		$d[0]='mensual';
	break;
}

?>
