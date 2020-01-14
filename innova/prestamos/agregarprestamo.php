<?php 
  require_once('../connection.php');
  if(isset($_POST) && !empty($_POST)){
    $totalinteres=0;
    $cuotainteres=0;
    $cuotas=0;
    $porcentaje=0;
    for ($i=0; $i<sizeof($_POST['monto']) ; $i++) {
      $totalinteres=$totalinteres+$_POST['monto'][$i];
      $cuotas++;
    }
    $cuotainteres=($totalinteres-$_POST['total'])/$cuotas;
    $porcentaje=($totalinteres-$_POST['total'])*100/$_POST['total'];
    for ($i=0; $i<sizeof($_POST['monto']) ; $i++) {
      $sql= mysqli_query($con,"INSERT INTO prestamos (banco,dni,monto,fecha,pendiente,interes,porcentaje) VALUES ('".$_POST['banco']."','".$_POST['documento']."','".$_POST['monto'][$i]."','".date('Y-m-d', strtotime(str_replace('/', '-', $_POST['fecha'][$i])))."','SI',$cuotainteres,$porcentaje)");
    }
    $hoy=date("Y-m-d");
    $insert=mysqli_query($con,"UPDATE cajamayor SET ingresos=(ingresos+".$_POST['total'].") WHERE fecha='$hoy'");
    $insert1=mysqli_query($con,"INSERT INTO ingresos (ingreso,tipo,monto,detalle,fecha,origen,sesion,usuario,mediopago) 
            VALUES ('INGRESO','PRESTAMO','".$_POST['total']."','".$_POST['banco']." - ".$_POST['documento']."',NOW(),'FERREBOOM','".$_SESSION['cargo']."','".$_SESSION['nombre']."','EFECTIVO')");
  }