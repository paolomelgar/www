<?php 
require_once('../connection.php');
$insert1=mysqli_query($con,"INSERT INTO ingresos (ingreso,tipo,monto,detalle,fecha,origen,sesion) 
				VALUES ('".$_POST['oper']."','".$_POST['tipo']."','".$_POST['monto']."','".$_POST['detalle']."',NOW(),'FERREBOOM','ADMIN')");
?>