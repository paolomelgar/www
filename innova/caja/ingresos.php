<?php
	require_once('../connection.php');
	$hoy=date("Y-m-d");
	if($_POST['numfactura']!=''){
        if($_POST['transporte']!=''){
        $insert1=mysqli_query($con,"INSERT INTO ingresos (ingreso,tipo,monto,detalle,fecha,origen,sesion,usuario,mediopago,numfactura,fechafactura) 
                        VALUES ('".$_POST['oper']."','".$_POST['tipo']."','".$_POST['monto']."','".$_POST['detalle']." - Trans: ".$_POST['transporte']."',NOW(),'FERREBOOM','".$_SESSION['cargo']."','".$_SESSION['nombre']."','".$_POST['mediopago']."','".$_POST['numfactura']."','".date('Y-m-d', strtotime(str_replace('/', '-', $_POST['fechafactura'])))."')");
        }else if($_POST['personal']!=''){
        $insert1=mysqli_query($con,"INSERT INTO ingresos (ingreso,tipo,monto,detalle,fecha,origen,sesion,usuario,mediopago,numfactura,fechafactura) 
                    VALUES ('".$_POST['oper']."','".$_POST['tipo']."','".$_POST['monto']."','SUELDO: ".$_POST['personal']." ".$_POST['detalle']."',NOW(),'FERREBOOM','".$_SESSION['cargo']."','".$_SESSION['nombre']."','".$_POST['mediopago']."','".$_POST['numfactura']."','".date('Y-m-d', strtotime(str_replace('/', '-', $_POST['fechafactura'])))."')");
        }else if($_POST['servicios']!=''){
        $insert1=mysqli_query($con,"INSERT INTO ingresos (ingreso,tipo,monto,detalle,fecha,origen,sesion,usuario,mediopago,numfactura,fechafactura) 
                    VALUES ('".$_POST['oper']."','".$_POST['tipo']."','".$_POST['monto']."',' ".$_POST['servicios']." ".$_POST['detalle']."',NOW(),'FERREBOOM','".$_SESSION['cargo']."','".$_SESSION['nombre']."','".$_POST['mediopago']."','".$_POST['numfactura']."','".date('Y-m-d', strtotime(str_replace('/', '-', $_POST['fechafactura'])))."')");
        }else if($_POST['transportesalida']!=''){
        $insert1=mysqli_query($con,"INSERT INTO ingresos (ingreso,tipo,monto,detalle,fecha,origen,sesion,usuario,mediopago,numfactura,fechafactura) 
                    VALUES ('".$_POST['oper']."','".$_POST['tipo']."','".$_POST['monto']."',' ".$_POST['transportesalida']." ".$_POST['detalle']."',NOW(),'FERREBOOM','".$_SESSION['cargo']."','".$_SESSION['nombre']."','".$_POST['mediopago']."','".$_POST['numfactura']."','".date('Y-m-d', strtotime(str_replace('/', '-', $_POST['fechafactura'])))."')");
        }else if($_POST['construccion']!=''){
        $insert1=mysqli_query($con,"INSERT INTO ingresos (ingreso,tipo,monto,detalle,fecha,origen,sesion,usuario,mediopago,numfactura,fechafactura) 
                    VALUES ('".$_POST['oper']."','".$_POST['tipo']."','".$_POST['monto']."',' ".$_POST['construccion']." ".$_POST['detalle']."',NOW(),'FERREBOOM','".$_SESSION['cargo']."','".$_SESSION['nombre']."','".$_POST['mediopago']."','".$_POST['numfactura']."','".date('Y-m-d', strtotime(str_replace('/', '-', $_POST['fechafactura'])))."')");
        }else if($_POST['tributarios']!=''){
        $insert1=mysqli_query($con,"INSERT INTO ingresos (ingreso,tipo,monto,detalle,fecha,origen,sesion,usuario,mediopago,numfactura,fechafactura) 
                    VALUES ('".$_POST['oper']."','".$_POST['tipo']."','".$_POST['monto']."',' ".$_POST['tributarios']." ".$_POST['detalle']."',NOW(),'FERREBOOM','".$_SESSION['cargo']."','".$_SESSION['nombre']."','".$_POST['mediopago']."','".$_POST['numfactura']."','".date('Y-m-d', strtotime(str_replace('/', '-', $_POST['fechafactura'])))."')");
        }else{
            $insert1=mysqli_query($con,"INSERT INTO ingresos (ingreso,tipo,monto,detalle,fecha,origen,sesion,usuario,mediopago,numfactura,fechafactura) 
                        VALUES ('".$_POST['oper']."','".$_POST['tipo']."','".$_POST['monto']."','".$_POST['detalle']."',NOW(),'FERREBOOM','".$_SESSION['cargo']."','".$_SESSION['nombre']."','".$_POST['mediopago']."','".$_POST['numfactura']."','".date('Y-m-d', strtotime(str_replace('/', '-', $_POST['fechafactura'])))."')");
        }
    }else{
        if($_POST['transporte']!=''){
        $insert1=mysqli_query($con,"INSERT INTO ingresos (ingreso,tipo,monto,detalle,fecha,origen,sesion,usuario,mediopago,numfactura,fechafactura) 
                        VALUES ('".$_POST['oper']."','".$_POST['tipo']."','".$_POST['monto']."','".$_POST['detalle']." - Trans: ".$_POST['transporte']."',NOW(),'FERREBOOM','".$_SESSION['cargo']."','".$_SESSION['nombre']."','".$_POST['mediopago']."','NO',NOW())");
        }else if($_POST['personal']!=''){
        $insert1=mysqli_query($con,"INSERT INTO ingresos (ingreso,tipo,monto,detalle,fecha,origen,sesion,usuario,mediopago,numfactura,fechafactura) 
                    VALUES ('".$_POST['oper']."','".$_POST['tipo']."','".$_POST['monto']."','SUELDO: ".$_POST['personal']." ".$_POST['detalle']."',NOW(),'FERREBOOM','".$_SESSION['cargo']."','".$_SESSION['nombre']."','".$_POST['mediopago']."','NO',NOW())");
        }else if($_POST['servicios']!=''){
        $insert1=mysqli_query($con,"INSERT INTO ingresos (ingreso,tipo,monto,detalle,fecha,origen,sesion,usuario,mediopago,numfactura,fechafactura) 
                    VALUES ('".$_POST['oper']."','".$_POST['tipo']."','".$_POST['monto']."',' ".$_POST['servicios']." ".$_POST['detalle']."',NOW(),'FERREBOOM','".$_SESSION['cargo']."','".$_SESSION['nombre']."','".$_POST['mediopago']."','NO',NOW())");
        }else if($_POST['transportesalida']!=''){
        $insert1=mysqli_query($con,"INSERT INTO ingresos (ingreso,tipo,monto,detalle,fecha,origen,sesion,usuario,mediopago,numfactura,fechafactura) 
                    VALUES ('".$_POST['oper']."','".$_POST['tipo']."','".$_POST['monto']."',' ".$_POST['transportesalida']." ".$_POST['detalle']."',NOW(),'FERREBOOM','".$_SESSION['cargo']."','".$_SESSION['nombre']."','".$_POST['mediopago']."','NO',NOW())");
        }else if($_POST['construccion']!=''){
        $insert1=mysqli_query($con,"INSERT INTO ingresos (ingreso,tipo,monto,detalle,fecha,origen,sesion,usuario,mediopago,numfactura,fechafactura) 
                    VALUES ('".$_POST['oper']."','".$_POST['tipo']."','".$_POST['monto']."',' ".$_POST['construccion']." ".$_POST['detalle']."',NOW(),'FERREBOOM','".$_SESSION['cargo']."','".$_SESSION['nombre']."','".$_POST['mediopago']."','NO',NOW())");
        }else if($_POST['tributarios']!=''){
        $insert1=mysqli_query($con,"INSERT INTO ingresos (ingreso,tipo,monto,detalle,fecha,origen,sesion,usuario,mediopago,numfactura,fechafactura) 
                    VALUES ('".$_POST['oper']."','".$_POST['tipo']."','".$_POST['monto']."',' ".$_POST['tributarios']." ".$_POST['detalle']."',NOW(),'FERREBOOM','".$_SESSION['cargo']."','".$_SESSION['nombre']."','".$_POST['mediopago']."','NO',NOW())");
        }else{
        $insert1=mysqli_query($con,"INSERT INTO ingresos (ingreso,tipo,monto,detalle,fecha,origen,sesion,usuario,mediopago,numfactura,fechafactura) 
                    VALUES ('".$_POST['oper']."','".$_POST['tipo']."','".$_POST['monto']."','".$_POST['detalle']."',NOW(),'FERREBOOM','".$_SESSION['cargo']."','".$_SESSION['nombre']."','".$_POST['mediopago']."','NO',NOW())");
        }
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