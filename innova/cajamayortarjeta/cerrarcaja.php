<?php
  	require_once('../connection.php');
  	date_default_timezone_set("America/Lima");
  	$hoy=date("Y-m-d");
  	$envio=mysqli_query($con,"SELECT fecha FROM dineromayortarjeta WHERE id=(SELECT max(id) FROM dineromayortarjeta)");
	$ro = mysqli_fetch_row($envio);
	if($hoy!=$ro[0]){
	    $ins1=mysqli_query($con,"INSERT INTO dineromayortarjeta (total,cajareal,diferencia,fecha) 
	    	VALUES ('".$_POST['total']."',
	    	'".$_POST['real']."',
	    	'".$_POST['diferencia']."',
	    	'".date('Y-m-d', strtotime(str_replace('/', '-', $_POST['fecha'])))."'
	    	)");
	}else{
		$inser=mysqli_query($con,"UPDATE dineromayortarjeta SET total='".$_POST['total']."',cajareal='".$_POST['real']."',diferencia='".$_POST['diferencia']."' WHERE fecha='$hoy'");
	}
?>