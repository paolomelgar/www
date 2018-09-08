<?php 
require_once('../connection.php');
    $hoy=date("Y-m-d");
    $insert1=mysqli_query($con,"INSERT INTO ingresos (ingreso,tipo,monto,detalle,fecha,origen,sesion) 
    				VALUES ('".$_POST['oper']."','".$_POST['tipo']."','".$_POST['monto']."','".$_POST['detalle']."',NOW(),'FERREBOOM','ADMIN')");
    if($_POST['oper']=='INGRESO'){
    	$inser=mysqli_query($con,"UPDATE cajamayor SET ingresos=(ingresos+".$_POST['monto'].") WHERE fecha='$hoy'");}
    else{
    	$inser=mysqli_query($con,"UPDATE cajamayor SET egresos=(egresos+".$_POST['monto'].") WHERE fecha='$hoy'");}
?>