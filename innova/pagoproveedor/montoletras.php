<?php
require_once('../connection.php');
    $hoy=date("Y-m-d");
    if($_POST['cambio']>0){
	    $monto=$_POST['real'][0]*$_POST['cambio'];
	    $monto=round($monto,1);
	}
	else{
		$monto=$_POST['real'][0];
		$monto=round($monto,1);
	}
    $insert=mysqli_query($con,"UPDATE cajamayor SET proveedor=(proveedor+$monto) WHERE fecha='$hoy'");
	$que=mysqli_query($con,"INSERT INTO adelantosletra (value,adelanto,cambio,fechapago,monto,fechaletra,proveedor) 
	                VALUES ('".$_POST['value']."',
	                        '".$_POST['real'][0]."',
	                        '".$_POST['cambio']."',
	                        NOW(),
	                        '".$_POST['monto'][0]."',
	                        '".date('Y-m-d', strtotime(str_replace('/', '-', $_POST['fecha'][0])))."',
	                        '".$_POST['proveedor']."'
	                    )");
	$res=mysqli_query($con,"SELECT pendiente,acuenta FROM total_compras WHERE value='".$_POST['value']."'");
	$row = mysqli_fetch_row($res);
	$pendiente=$row[0]-$_POST['monto'][0];
	$acuenta=$row[1]+$_POST['monto'][0];
	if($pendiente>10){
		$sql=mysqli_query($con,"UPDATE total_compras SET pendiente='$pendiente',acuenta='$acuenta' WHERE value='".$_POST['value']."'");
	}
	else{
		$sql=mysqli_query($con,"UPDATE total_compras SET pendiente='$pendiente',acuenta='$acuenta',credito='CANCELADO' WHERE value='".$_POST['value']."'");
	}
	$res=mysqli_query($con,"UPDATE pagoletras SET pendiente='NO' WHERE value='".$_POST['value']."' AND pendiente='SI' ORDER BY fecha LIMIT 1");
?>