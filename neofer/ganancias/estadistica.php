<?php
set_time_limit(60);
require_once('../connection.php');
$a=array();
$b=array();
$d=array();
$array=array();
$i=0;
switch ($_POST['t']) {
	case 'vendedor':
		$q=mysqli_query($con,"SELECT DISTINCT(vendedor) FROM total_ventas WHERE entregado='SI' AND MONTH(fecha)='".($_POST['m']+1)."' AND YEAR(fecha)='".$_POST['y']."'");
		while($r=mysqli_fetch_assoc($q)){
			$quer = mysqli_query($con,"SELECT SUM(total) FROM total_ventas WHERE vendedor='".$r['vendedor']."' AND entregado='SI' AND MONTH(fecha)='".($_POST['m']+1)."' AND YEAR(fecha)='".$_POST['y']."'");
			$rr=mysqli_fetch_row($quer);
			$a[$i]=$rr[0];
			$b[$i]=$r['vendedor'];
			$i++;
		}
		$d[0]='vendedor';
	break;
	case 'mensual':
		for($j=0;$j<12;$j++){
			$quer = mysqli_query($con,"SELECT SUM(total) FROM total_ventas WHERE entregado='SI' AND MONTH(fecha)='".($j+1)."' AND YEAR(fecha)='".$_POST['y']."'");
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
	case 'ganancia':
		for($j=0;$j<12;$j++){
			$query="entregado='SI' AND MONTH(fecha)='".($j+1)."' AND YEAR(fecha)='".$_POST['y']."'";
			$quer = mysqli_query($con,"SELECT sum(cantidad*(unitario-compra)) FROM notapedido WHERE $query");
			$quer1 = mysqli_query($con,"SELECT sum(cantidad*(unitario-compra)) FROM proforma WHERE $query");
			$quer2 = mysqli_query($con,"SELECT sum(cantidad*(unitario-compra)) FROM boleta WHERE $query");
			$quer3 = mysqli_query($con,"SELECT sum(cantidad*(unitario-compra)) FROM devoluciones WHERE $query");
			$quer4 = mysqli_query($con,"SELECT sum(cantidad*(unitario-compra)) FROM facturapaola WHERE $query");
			$rr=mysqli_fetch_row($quer);
			$rr1=mysqli_fetch_row($quer1);
			$rr2=mysqli_fetch_row($quer2);
			$rr3=mysqli_fetch_row($quer3);
			$rr4=mysqli_fetch_row($quer4);
			$a[$j]=$rr[0]+$rr1[0]+$rr2[0]-$rr3[0]+$rr4[0];
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
	case 'hora':
		for($j=0;$j<14;$j++){
			$quer = mysqli_query($con,"SELECT SUM(total) FROM total_ventas WHERE entregado='SI' AND MONTH(fecha)='".($_POST['m']+1)."' AND YEAR(fecha)='".$_POST['y']."' AND HOUR(hora) between '".($j+8).":00:00' and '".($j+8).":59:59'");
			$rr=mysqli_fetch_row($quer);
			$a[$j]=$rr[0];
			switch ($j) {
				case '0':
					$b[$j]="08:00-09:00";
				break;
				case '1':
					$b[$j]="09:00-10:00";
				break;
				case '2':
					$b[$j]="10:00-11:00";
				break;
				case '3':
					$b[$j]="11:00-12:00";
				break;
				case '4':
					$b[$j]="12:00-13:00";
				break;
				case '5':
					$b[$j]="13:00-14:00";
				break;
				case '6':
					$b[$j]="14:00-15:00";
				break;
				case '7':
					$b[$j]="15:00-16:00";
				break;
				case '8':
					$b[$j]="16:00-17:00";
				break;
				case '9':
					$b[$j]="17:00-18:00";
				break;
				case '10':
					$b[$j]="18:00-19:00";
				break;
				case '11':
					$b[$j]="19:00-20:00";
				break;
				case '12':
					$b[$j]="20:00-21:00";
				break;
				case '13':
					$b[$j]="21:00-22:00";
				break;
				default:
				break;
			}
		}
		$d[0]='mensual';
	break;
	case 'marca':
		$sql=mysqli_query($con,"SELECT * FROM marca WHERE activo='SI'");
	    while($row=mysqli_fetch_assoc($sql)){
	        $query="producto LIKE '%".$row['marca']."%' AND entregado='SI' AND month(fecha)='".($_POST['m']+1)."' AND year(fecha)='".$_POST['y']."'";
	        $sql1=mysqli_query($con,"SELECT sum(importe) FROM notapedido WHERE $query");
	        $sql2=mysqli_query($con,"SELECT sum(importe) FROM proforma WHERE $query");
	        $sql3=mysqli_query($con,"SELECT sum(importe) FROM boleta WHERE $query");
	        $sql4=mysqli_query($con,"SELECT sum(importe) FROM devoluciones WHERE $query");
	        $r1=mysqli_fetch_row($sql1);
	        $r2=mysqli_fetch_row($sql2);
	        $r3=mysqli_fetch_row($sql3);
	        $r4=mysqli_fetch_row($sql4);
	        $total=$r1[0]+$r2[0]+$r3[0]-$r4[0];
	        array_push($array,array($total,$row['marca']));
	    }
	    rsort($array);
	    for($x = 0; $x <  15; $x++) {
	        $a[$x]= $array[$x][0];
	        $b[$x]= $array[$x][1];
	    }
	    $d[0]='marca';
	break;
	case 'cliente':
		$sql=mysqli_query($con,"SELECT * FROM cliente WHERE activo='SI' and tipo='FERRETERIA'");
	    while($row=mysqli_fetch_assoc($sql)){
	        $query="cliente='".$row['cliente']."' AND entregado='SI' AND month(fecha)='".($_POST['m']+1)."' AND year(fecha)='".$_POST['y']."'";
	        $sql1=mysqli_query($con,"SELECT sum(total) FROM total_ventas WHERE $query");
	        $r1=mysqli_fetch_row($sql1);
	        array_push($array,array($r1[0],$row['cliente']));
	    }
	    rsort($array);
	    for($x = 0; $x <  15; $x++) {
	        $a[$x]= $array[$x][0];
	        $b[$x]= substr($array[$x][1],0,15);
	    }
	    $d[0]='cliente';
	break;
}
$c[0]=$a;
$c[1]=$b;
$c[2]=$d;
echo json_encode($c);
?>
