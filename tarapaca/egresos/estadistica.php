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
			$quer = mysqli_query($con,"SELECT SUM(monto) FROM ingresos WHERE ingreso='EGRESO' AND MONTH(fecha)='".($j+1)."' AND YEAR(fecha)='".$_POST['y']."'");
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
	case 'flete':
		for($j=0;$j<12;$j++){
			$quer = mysqli_query($con,"SELECT SUM(monto) FROM ingresos WHERE tipo='FLETE' AND MONTH(fecha)='".($j+1)."' AND YEAR(fecha)='".$_POST['y']."'");
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
	case 'delivery':
		for($j=0;$j<12;$j++){
			$quer = mysqli_query($con,"SELECT SUM(monto) FROM ingresos WHERE tipo='DELIVERY' AND MONTH(fecha)='".($j+1)."' AND YEAR(fecha)='".$_POST['y']."'");
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
	case 'personal':
	for($j=0;$j<12;$j++){
			$quer = mysqli_query($con,"SELECT SUM(monto) FROM ingresos WHERE tipo='PERSONAL' AND MONTH(fecha)='".($j+1)."' AND YEAR(fecha)='".$_POST['y']."'");
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
			$quer = mysqli_query($con,"SELECT SUM(monto) FROM ingresos WHERE tipo='SERVICIOS' AND MONTH(fecha)='".($j+1)."' AND YEAR(fecha)='".$_POST['y']."'");
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
	case 'impuestos':
	for($j=0;$j<12;$j++){
			$quer = mysqli_query($con,"SELECT SUM(monto) FROM ingresos WHERE tipo='IMPUESTOS' AND MONTH(fecha)='".($j+1)."' AND YEAR(fecha)='".$_POST['y']."'");
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
$c[0]=$a;
$c[1]=$b;
$c[2]=$d;
echo json_encode($c);
?>
