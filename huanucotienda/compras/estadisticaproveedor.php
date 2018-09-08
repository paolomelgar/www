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
	$query = "SELECT SUM(montototal) FROM total_compras WHERE proveedor='".$_POST['b']."' AND entregado='SI' AND billete='SOLES' AND YEAR(fechafactura)='".$y."' AND MONTH(fechafactura)='".date('m',strtotime("-".$i." month"))."'";
	$query1 = "SELECT SUM(montototal*cambio) FROM total_compras WHERE proveedor='".$_POST['b']."' AND entregado='SI' AND billete='DOLARES' AND YEAR(fechafactura)='".$y."' AND MONTH(fechafactura)='".date('m',strtotime("-".$i." month"))."'";
	$result=mysqli_query($con,$query);
	$result1=mysqli_query($con,$query1);
	$row=mysqli_fetch_row($result);
	$row1=mysqli_fetch_row($result1);
	$a[$i]=$row[0]+$row1[0];
	$b[$i]=$meses[date('n',strtotime("-".$i." month"))-1]." ".$y;
}
$c[0]=$a;
$c[1]=$b;
echo json_encode($c,JSON_NUMERIC_CHECK);
?>
