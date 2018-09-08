<?php
session_start();
require_once('../connection.php');
if($_SESSION['valida']=='true'){
    date_default_timezone_set("America/Lima");
    $hoy=date("Y-m-d");
    if($_POST['transporte']!=''){
        $insert1=mysqli_query($con,"INSERT INTO ingresos (ingreso,tipo,monto,detalle,fecha,origen,sesion) 
                    VALUES ('".$_POST['oper']."','".$_POST['tipo']."','".$_POST['monto']."','".$_POST['detalle']." - Trans: ".$_POST['transporte']."',NOW(),'FERREBOOM','".$_SESSION['cargo']."')");
    }else{
        $insert1=mysqli_query($con,"INSERT INTO ingresos (ingreso,tipo,monto,detalle,fecha,origen,sesion) 
                    VALUES ('".$_POST['oper']."','".$_POST['tipo']."','".$_POST['monto']."','".$_POST['detalle']."',NOW(),'FERREBOOM','".$_SESSION['cargo']."')");
    }
    if($_SESSION['cargo']=='CAJERO TIENDA'){
        if($_POST['oper']=='INGRESO'){
        	$inser=mysqli_query($con,"UPDATE dinerodiario SET ingresos=(ingresos+".$_POST['monto'].") WHERE fecha='$hoy'");}
        else{
        	$inser=mysqli_query($con,"UPDATE dinerodiario SET egresos=(egresos+".$_POST['monto'].") WHERE fecha='$hoy'");}
    }else if($_SESSION['cargo']=='CAJERO FIERROS'){
        if($_POST['oper']=='INGRESO'){
            $inser=mysqli_query($con,"UPDATE dinerodiario1 SET ingresos=(ingresos+".$_POST['monto'].") WHERE fecha='$hoy'");}
        else{
            $inser=mysqli_query($con,"UPDATE dinerodiario1 SET egresos=(egresos+".$_POST['monto'].") WHERE fecha='$hoy'");}
    }else{
        if($_POST['oper']=='INGRESO'){
            $inser=mysqli_query($con,"UPDATE cajamayor SET ingresos=(ingresos+".$_POST['monto'].") WHERE fecha='$hoy'");}
        else{
            $inser=mysqli_query($con,"UPDATE cajamayor SET egresos=(egresos+".$_POST['monto'].") WHERE fecha='$hoy'");}
    }
}
?>