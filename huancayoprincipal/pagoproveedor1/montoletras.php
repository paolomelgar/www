<?php
	require_once('../connection.php');
    $hoy=date("Y-m-d");
    for ($i=0; $i<sizeof($_POST['monto']) ; $i++) {
    	$rm=mysqli_query($con,"SELECT unico FROM pagoletras WHERE id='".$_POST['id'][$i]."'");
    	$mm=mysqli_fetch_row($rm);
	    if($_POST['cambio']>0){
		    $monto=$_POST['real'][$i]*$_POST['cambio'];
		    $monto=round($monto,1);
		}
		else{
			$monto=$_POST['real'][$i];
			$monto=round($monto,1);
		}
	    $insert=mysqli_query($con,"UPDATE cajamayor SET proveedor=(proveedor+$monto) WHERE fecha='$hoy'");
		$que=mysqli_query($con,"INSERT INTO adelantosletra (value,adelanto,cambio,fechapago,monto,fechaletra,proveedor,unico) 
		                VALUES ('".$_POST['value']."',
		                        '".$_POST['real'][$i]."',
		                        '".$_POST['cambio']."',
		                        NOW(),
		                        '".$_POST['monto'][$i]."',
		                        '".date('Y-m-d', strtotime(str_replace('/', '-', $_POST['fecha'][$i])))."',
		                        '".$_POST['proveedor']."',
		                        '".$mm[0]."'
		                    )");
		$res=mysqli_query($con,"SELECT pendiente,acuenta FROM total_compras WHERE value='".$_POST['value']."'");
		$row = mysqli_fetch_row($res);
		$pendiente=$row[0]-$_POST['monto'][$i];
		$acuenta=$row[1]+$_POST['monto'][$i];
		if($pendiente>10){
			$sql=mysqli_query($con,"UPDATE total_compras SET pendiente='$pendiente',acuenta='$acuenta' WHERE value='".$_POST['value']."'");
		}
		else{
			$sql=mysqli_query($con,"UPDATE total_compras SET pendiente='$pendiente',acuenta='$acuenta',credito='CANCELADO' WHERE value='".$_POST['value']."'");
		}
	 	$res=mysqli_query($con,"UPDATE pagoletras SET pendiente='NO' WHERE id='".$_POST['id'][$i]."'");
	}
?>