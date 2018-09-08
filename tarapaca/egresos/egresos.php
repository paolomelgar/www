<?php
session_start();
require_once('../connection.php');
    date_default_timezone_set("America/Lima");
    $hoy=date("Y-m-d");
    if($_POST['personal']!=''){
        $insert1=mysqli_query($con,"INSERT INTO ingresos (ingreso,tipo,monto,detalle,fecha,sesion) 
                    VALUES ('".$_POST['oper']."','".$_POST['tipo']."','".$_POST['monto']."','Sueldo: ".$_POST['personal']."',NOW(),'".$_SESSION['cargo']."')");
    }else if($_POST['servicios']!=''){
        $insert1=mysqli_query($con,"INSERT INTO ingresos (ingreso,tipo,monto,detalle,fecha,sesion) 
                    VALUES ('".$_POST['oper']."','".$_POST['tipo']."','".$_POST['monto']."','Pago: ".$_POST['servicios']."',NOW(),'".$_SESSION['cargo']."')");
    }else if($_POST['impuestos']!=''){
        $insert1=mysqli_query($con,"INSERT INTO ingresos (ingreso,tipo,monto,detalle,fecha,sesion) 
                    VALUES ('".$_POST['oper']."','".$_POST['tipo']."','".$_POST['monto']."','".$_POST['impuestos']."',NOW(),'".$_SESSION['cargo']."')");
    }else{
        $insert1=mysqli_query($con,"INSERT INTO ingresos (ingreso,tipo,monto,detalle,fecha,sesion) 
                    VALUES ('".$_POST['oper']."','".$_POST['tipo']."','".$_POST['monto']."','".$_POST['concepto']."',NOW(),'".$_SESSION['cargo']."')");
    }
    if($_SESSION['cargo']=='CAJERO'){
        if($_POST['oper']=='INGRESO'){
        	$inser=mysqli_query($con,"UPDATE dinerodiario SET ingresos=(ingresos+".$_POST['monto'].") WHERE fecha='$hoy'");}
        else{
        	$inser=mysqli_query($con,"UPDATE dinerodiario SET egresos=(egresos+".$_POST['monto'].") WHERE fecha='$hoy'");}
    }else{
        if($_POST['oper']=='INGRESO'){
            $inser=mysqli_query($con,"UPDATE cajamayor SET ingresos=(ingresos+".$_POST['monto'].") WHERE fecha='$hoy'");}
        else{
            $inser=mysqli_query($con,"UPDATE cajamayor SET egresos=(egresos+".$_POST['monto'].") WHERE fecha='$hoy'");}
    }
?>