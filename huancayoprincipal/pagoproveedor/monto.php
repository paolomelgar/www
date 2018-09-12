<?php
require_once('../connection.php');
    $hoy=date("Y-m-d");
    if($_POST['cambio']>0){
	    $monto=$_POST['monto']*$_POST['cambio'];
	    $monto=round($monto,1);
	}
	else{
		$monto=$_POST['monto'];
		$monto=round($monto,1);
	}
    $insert=mysqli_query($con,"UPDATE cajamayor SET proveedor=(proveedor+$monto) WHERE fecha='$hoy'");
	$que=mysqli_query($con,"INSERT INTO adelantoscompras (value,adelanto,cambio,fecha,forma,banco,nro,proveedor) 
	                VALUES ('".$_POST['value']."',
	                        '".$_POST['monto']."',
	                        '".$_POST['cambio']."',
	                        NOW(),
	                        '".$_POST['forma']."',
	                        '".$_POST['banco']."',
                          '".$_POST['nro']."',
	                        '".$_POST['proveedor']."'
	                    )");
	$res=mysqli_query($con,"SELECT pendiente,acuenta FROM total_compras WHERE value='".$_POST['value']."'");
	$row = mysqli_fetch_row($res);
	$pendiente=$row[0]-$_POST['monto'];
	$acuenta=$row[1]+$_POST['monto'];
	if($pendiente>0){
		$sql=mysqli_query($con,"UPDATE total_compras SET pendiente='$pendiente',acuenta='$acuenta' WHERE value='".$_POST['value']."'");
	}
	else{
		$sql=mysqli_query($con,"UPDATE total_compras SET pendiente='$pendiente',acuenta='$acuenta',credito='CANCELADO' WHERE value='".$_POST['value']."'");
	}
?>