<?php
set_time_limit(60);
require_once('../connection.php');
$a=array();
$b=array();
$d=array();
$array=array();
$i=0;
switch ($_POST['t']) {
	case 'ferreteria':
		$query = mysqli_query($con,"SELECT SUM(total) FROM total_ventas WHERE cliente LIKE '%FERRE. %' AND entregado='SI' AND MONTH(fecha)='".($_POST['m']+1)."' AND YEAR(fecha)='".$_POST['y']."'");
		$que = mysqli_query($con,"SELECT SUM(total) FROM total_ventas WHERE cliente LIKE '%CONS. %' AND entregado='SI' AND MONTH(fecha)='".($_POST['m']+1)."' AND YEAR(fecha)='".$_POST['y']."'");
		$que1 = mysqli_query($con,"SELECT SUM(total) FROM total_ventas WHERE cliente LIKE '%PROM. %' AND entregado='SI' AND MONTH(fecha)='".($_POST['m']+1)."' AND YEAR(fecha)='".$_POST['y']."'");
		$que2 = mysqli_query($con,"SELECT SUM(total) FROM total_ventas WHERE cliente LIKE '%MAY. %' AND entregado='SI' AND MONTH(fecha)='".($_POST['m']+1)."' AND YEAR(fecha)='".$_POST['y']."'");
		$que3 = mysqli_query($con,"SELECT SUM(total) FROM total_ventas WHERE cliente NOT LIKE '%PROM. %' AND cliente NOT LIKE '%FERRE. %' AND cliente NOT LIKE '%CONS. %' AND cliente NOT LIKE '%MAY. %' AND entregado='SI' AND MONTH(fecha)='".($_POST['m']+1)."' AND YEAR(fecha)='".$_POST['y']."'");
		$row=mysqli_fetch_row($query); 
		$row1=mysqli_fetch_row($que);
		$row2=mysqli_fetch_row($que1);
		$row3=mysqli_fetch_row($que2);
		$row4=mysqli_fetch_row($que3);
		$a[0]=$row[0];
		$b[0]="FERRETERIA";
		$a[1]=$row1[0];
		$b[1]="CONSTRUCTORA";
		$a[2]=$row2[0];
		$b[2]="PROMOTOR";
		$a[3]=$row3[0];
		$b[3]="MAYOR";
		$a[4]=$row4[0];
		$b[4]="TIENDA";
		$d[0]='ferreteria';
	break;
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
			//$quer = mysqli_query($con,"SELECT sum(cantidad*(unitario-compra)) FROM devoluciones WHERE $query ");
			$rr=mysqli_fetch_row($quer);
			$rr1=mysqli_fetch_row($quer1);
			$rr2=mysqli_fetch_row($quer2);
			$rr3=mysqli_fetch_row($quer3);
			$a[$j]=$rr[0]+$rr1[0]+$rr2[0]-$rr3[0];
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
		for($j=0;$j<12;$j++){
			$quer = mysqli_query($con,"SELECT SUM(total) FROM total_ventas WHERE entregado='SI' AND MONTH(fecha)='".$_POST['m']."' AND YEAR(fecha)='".$_POST['y']."' AND HOUR(hora) between '".($j+8).":00:00' and '".($j+8).":59:59'");
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
				default:
				break;
			}
		}
		$d[0]='hora';
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
		$sql=mysqli_query($con,"SELECT * FROM cliente WHERE activo='SI' AND cliente LIKE '%FERRE.%'");
	    while($row=mysqli_fetch_assoc($sql)){
	        $query="cliente='".$row['cliente']."' AND entregado='SI' AND month(fecha)='".($_POST['m']+1)."' AND year(fecha)='".$_POST['y']."'";
	        $sql1=mysqli_query($con,"SELECT sum(total) FROM total_ventas WHERE $query");
	        $r1=mysqli_fetch_row($sql1);
	        array_push($array,array($r1[0],$row['cliente']));
	    }
	    rsort($array);
	    for($x = 0; $x <  15; $x++) {
	        $a[$x]= $array[$x][0];
	        $b[$x]= substr($array[$x][1],7,17);
	    }
	    $d[0]='marca';
	break;
}
$c[0]=$a;
$c[1]=$b;
$c[2]=$d;
echo json_encode($c);
?>
