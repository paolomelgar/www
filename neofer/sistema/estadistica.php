<?php
require_once('../connection.php');
$a=array();
$b=array();
$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
$m=date('m');
$y=date('Y');
for ($i=0; $i<10 ; $i++){
	if($i==$m){
		$y--;
	}
	$query = "SELECT SUM(total) FROM total_ventas WHERE entregado='SI' AND YEAR(fecha)='".$y."' AND MONTH(fecha)='".date('m',strtotime("-".$i." month"))."'";
	$result=mysqli_query($con,$query);
	$row=mysqli_fetch_row($result);
	$a[$i]=$row[0];
	$b[$i]=$meses[date('n',strtotime("-".$i." month"))-1]." ".$y;
}
$c[0]=$a;
$c[1]=$b;
echo json_encode($c,JSON_NUMERIC_CHECK);
?>
