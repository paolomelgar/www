<?php
require_once('../connection.php');
    date_default_timezone_set("America/Lima");
    $hoy=date("Y-m-d");
    if($_SESSION['cargo']=='CAJERO'){
    	$insert=mysqli_query($con,"UPDATE dinerodiario SET creditos=(creditos+".$_POST['monto'].") WHERE fecha='$hoy'");
    }
    else{
        $insert=mysqli_query($con,"UPDATE cajamayor SET creditos=(creditos+".$_POST['monto'].") WHERE fecha='$hoy'");
    }
    $que=mysqli_query($con,"INSERT INTO adelantos (serie,adelanto,encargado,fecha,forma,banco,nro,cliente,sesion,fechapagooo) 
                    VALUES ('".$_POST['serie']."',
                            '".$_POST['monto']."',
                            '".$_SESSION['nombre']."',
                            NOW(),
                            '".$_POST['forma']."',
                            '".$_POST['banco']."',
                            '".$_POST['nro']."',
                            '".$_POST['cliente']."',
                            '".$_SESSION['cargo']."',
                            '".date('Y-m-d', strtotime(str_replace('/', '-', $_POST['fechapagooo'])))."'
                        )");
    $res=mysqli_query($con,"SELECT pendiente,acuenta FROM total_ventas WHERE serieventas='".$_POST['serie']."' AND documento='NOTA DE PEDIDO'");
    $row = mysqli_fetch_row($res);
    $pendiente=$row[0]-$_POST['monto'];
    $acuenta=$row[1]+$_POST['monto'];
    if($pendiente>0){
    	$sql=mysqli_query($con,"UPDATE total_ventas SET pendiente='$pendiente',acuenta='$acuenta' WHERE serieventas='".$_POST['serie']."' AND documento='NOTA DE PEDIDO'");
    }
    else{
    	$sql=mysqli_query($con,"UPDATE total_ventas SET pendiente='$pendiente',acuenta='$acuenta',credito='CANCELADO' WHERE serieventas='".$_POST['serie']."' AND documento='NOTA DE PEDIDO'");
    }
?>