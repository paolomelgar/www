<?php
    require_once('../connection.php');
    date_default_timezone_set("America/Lima");
    $hoy=date("Y-m-d");
    $envio=mysqli_query($con,"SELECT fecha FROM dinerodiario WHERE id=(SELECT max(id) FROM dinerodiario)");
	$ro = mysqli_fetch_row($envio);
	if($hoy!=$ro[0]){
	    $ins1=mysqli_query($con,"INSERT INTO dinerodiario (total,cajareal,diferencia,fecha,visaizipay) VALUES ('".$_POST['total']."','".$_POST['real']."','".$_POST['diferencia']."','$hoy','".$_POST['visaizipay']."')");
	}else{
		$inser=mysqli_query($con,"UPDATE dinerodiario SET total='".$_POST['total']."',cajareal='".$_POST['real']."',diferencia='".$_POST['diferencia']."',visaizipay='".$_POST['visaizipay']."' WHERE fecha='$hoy'");
	}
  	
?>