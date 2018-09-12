<?php
    require_once('../connection.php');
    $query=mysqli_query($con,"UPDATE total_compras SET letra='SI' WHERE value='".$_POST['value']."'");
    if($_POST['pendiente']=='S'){
	    for ($i=0; $i<sizeof($_POST['monto']) ; $i++) {
	    	$sql= mysqli_query($con,"INSERT INTO pagoletras (proveedor,value,monto,estado,billete,fecha,unico,pendiente) VALUES ('".$_POST['proveedor']."','".$_POST['value']."','".$_POST['monto'][$i]."','PENDIENTE','S/.','".date('Y-m-d', strtotime(str_replace('/', '-', $_POST['fecha'][$i])))."','".$_POST['unico'][$i]."','SI')");
	    }
	}
	else{
		for ($i=0; $i<sizeof($_POST['monto']) ; $i++) {
	    	$sql= mysqli_query($con,"INSERT INTO pagoletras (proveedor,value,monto,estado,billete,fecha,unico,pendiente) VALUES ('".$_POST['proveedor']."','".$_POST['value']."','".$_POST['monto'][$i]."','PENDIENTE','$.','".date('Y-m-d', strtotime(str_replace('/', '-', $_POST['fecha'][$i])))."','".$_POST['unico'][$i]."','SI')");
	    }
	}
?>