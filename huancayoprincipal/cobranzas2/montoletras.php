<?php
	require_once('../connection.php');
    $hoy=date("Y-m-d");
    for ($i=0; $i<sizeof($_POST['monto']) ; $i++) {
		$monto=$_POST['real'][$i];
		$monto=round($monto,1);
	    $insert=mysqli_query($con,"UPDATE cajamayor SET creditos=(creditos+$monto) WHERE fecha='$hoy'");
		$que=mysqli_query($con,"INSERT INTO cobroletras (value,adelanto,fechapago,monto,fechaletra,cliente) 
		                VALUES ('".$_POST['value']."',
		                        '".$_POST['real'][$i]."',
		                        NOW(),
		                        '".$_POST['monto'][$i]."',
		                        '".date('Y-m-d', strtotime(str_replace('/', '-', $_POST['fecha'][$i])))."',
		                        '".$_POST['cliente']."'
		                    )");
		$res=mysqli_query($con,"SELECT pendiente,adelanto FROM letra WHERE value='".$_POST['value']."'");
		$row = mysqli_fetch_row($res);
		$pendiente=$row[0]-$_POST['monto'][$i];
		$acuenta=$row[1]+$_POST['monto'][$i];
		if($pendiente>10){
			$sql=mysqli_query($con,"UPDATE letra SET pendiente='$pendiente',adelanto='$acuenta' WHERE value='".$_POST['value']."'");
		}
		else{
			$sql=mysqli_query($con,"UPDATE letra SET pendiente='$pendiente',adelanto='$acuenta',credito='CANCELADO' WHERE value='".$_POST['value']."'");
		}
		$res=mysqli_query($con,"UPDATE letraclientes SET pendiente='NO' WHERE id='".$_POST['id'][$i]."'");
	}
?>