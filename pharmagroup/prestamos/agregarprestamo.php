<?php 
  require_once('../connection.php');
  if(isset($_POST) && !empty($_POST)){
    for ($i=0; $i<sizeof($_POST['monto']) ; $i++) {
      $sql= mysqli_query($con,"INSERT INTO prestamos (banco,dni,monto,fecha,pendiente) VALUES ('".$_POST['banco']."','".$_POST['documento']."','".$_POST['monto'][$i]."','".date('Y-m-d', strtotime(str_replace('/', '-', $_POST['fecha'][$i])))."','SI')");
    }
    $hoy=date("Y-m-d");
    $insert=mysqli_query($con,"UPDATE cajamayor SET ingresos=(ingresos+".$_POST['total'].") WHERE fecha='$hoy'");
    $insert1=mysqli_query($con,"INSERT INTO ingresos (ingreso,tipo,monto,detalle,fecha,origen,sesion) 
    				VALUES ('INGRESO','PRESTAMO','".$_POST['total']."','".$_POST['banco']." - ".$_POST['documento']."',NOW(),'FERREBOOM','ADMIN')");
  }