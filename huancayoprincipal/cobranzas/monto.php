<?php
require_once('../connection.php');
	$hoy=date("Y-m-d");
    $insert=mysqli_query($con,"UPDATE cajamayor SET creditos=(creditos+".$_POST['monto'].") WHERE fecha='$hoy'");
	$que=mysqli_query($con,"INSERT INTO adelantos (serie,adelanto,encargado,fecha,forma,banco,nro,cliente,sesion) 
	                VALUES ('".$_POST['serie']."',
	                        '".$_POST['monto']."',
	                        '".$_POST['vendedor']."',
	                        NOW(),
	                        '".$_POST['forma']."',
	                        '".$_POST['banco']."',
                            '".$_POST['nro']."',
	                        '".$_POST['cliente']."',
	                        '".$_SESSION['cargo']."'
	                    )");
	$res=mysqli_query($con,"SELECT pendiente,acuenta FROM total_ventas WHERE serieventas='".$_POST['serie']."' AND documento='NOTA DE PEDIDO'");
	$row = mysqli_fetch_row($res);
	$pendiente=$row[0]-$_POST['monto'];
	$acuenta=$row[1]+$_POST['monto'];
	if($pendiente>0){
		$sql=mysqli_query($con,"UPDATE total_ventas SET pendiente='$pendiente',acuenta='$acuenta' WHERE serieventas='".$_POST['serie']."' AND documento='NOTA DE PEDIDO'");
	}else{
		$sql=mysqli_query($con,"UPDATE total_ventas SET pendiente='$pendiente',acuenta='$acuenta',credito='CANCELADO' WHERE serieventas='".$_POST['serie']."' AND documento='NOTA DE PEDIDO'");
	}
?>