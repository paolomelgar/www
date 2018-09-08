<?php
require_once('../connection.php');
$a=array();
$b=array();
$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
$m=date('m');
$y=date('Y');
$datos=array();
for ($i=0; $i<10 ; $i++){
	if($i==$m){
		$y--;
	}
	$query = "SELECT SUM(total) FROM total_ventas WHERE cliente='".$_REQUEST['cliente']."' AND entregado='SI' AND YEAR(fecha)='".$y."' AND MONTH(fecha)='".date('m',strtotime("-".$i." month"))."'";
	$result=mysqli_query($con,$query);
	$row=mysqli_fetch_row($result);
	if($row[0]==null){
		$row[0]=0;
	}
	$datos[$i]["total"] =$row[0];
	$datos[$i]["mes"] =$meses[date('n',strtotime("-".$i." month"))-1]." ".$y;
}
echo json_encode($datos);
?>
