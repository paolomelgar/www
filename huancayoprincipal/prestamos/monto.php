<?php
require_once('../connection.php');
	$hoy=date("Y-m-d");
	$insert=mysqli_query($con,"UPDATE cajamayor SET egresos=(egresos+".$_POST['monto'].") WHERE fecha='$hoy'");
	$que=mysqli_query($con,"INSERT INTO pagoprestamos (serie,monto,fecha,banco,dni)
	                VALUES ('".$_POST['id']."',
	                        '".$_POST['monto']."',
	                        NOW(),
	                        '".$_POST['banco']."',
                            '".$_POST['documento']."'
	                    )");
	$subtotal=0;
	$subtotal=$_POST['monto']-$_POST['interes'];
	$sql=mysqli_query($con,"UPDATE prestamos SET pendiente='NO' WHERE id='".$_POST['id']."'");
	$insert1=mysqli_query($con,"INSERT INTO ingresos (ingreso,tipo,monto,detalle,fecha,origen,sesion,usuario,mediopago) 
    				VALUES ('INGRESO','PRESTAMO',-$subtotal,'".$_POST['banco']." - ".$_POST['documento']."',NOW(),'FERREBOOM','".$_SESSION['cargo']."','".$_SESSION['nombre']."','EFECTIVO')");
	$insert2=mysqli_query($con,"INSERT INTO ingresos (ingreso,tipo,monto,detalle,fecha,origen,sesion,usuario,mediopago) 
    				VALUES ('EGRESO','INTERES PRESTAMO','".$_POST['interes']."','INTERES: ".$_POST['banco']." - ".$_POST['documento']."',NOW(),'FERREBOOM','".$_SESSION['cargo']."','".$_SESSION['nombre']."','EFECTIVO')");
?>