<?php 
require_once('../connection.php');
	$hoy=date("Y-m-d");
	for ($i=0; $i<sizeof($_POST['serie']) ; $i++) {
		$qq=mysqli_query($con,"UPDATE acuenta SET pendiente='NO' WHERE serie='".$_POST['serie'][$i]."'");
        $que=mysqli_query($con,"INSERT INTO adelantos (serie,adelanto,encargado,fecha,forma,banco,nro,cliente,sesion) 
	                VALUES ('".$_POST['serie'][$i]."',
	                        '".$_POST['monto'][$i]."',
	                        '".$_POST['vendedor']."',
	                        NOW(),
	                        'EFECTIVO',
	                        '',
                            '',
	                        '".$_POST['cliente'][$i]."',
	                        '".$_SESSION['cargo']."'
	                    )");
        if($_SESSION['cargo']=='CAJERO'){
			$insert=mysqli_query($con,"UPDATE dinerodiario SET creditos=(creditos+".$_POST['monto'][$i].") WHERE fecha='$hoy'");
		}
		elseif($_SESSION['cargo']=='ADMIN'){
		    $insert=mysqli_query($con,"UPDATE cajamayor SET creditos=(creditos+".$_POST['monto'][$i].") WHERE fecha='$hoy'");
		}
        
        $res=mysqli_query($con,"SELECT pendiente,acuenta FROM total_ventas WHERE serieventas='".$_POST['serie'][$i]."' AND documento='NOTA DE PEDIDO'");
		$row = mysqli_fetch_row($res);
		$pendiente=$row[0]-$_POST['monto'][$i];
		$acuenta=$row[1]+$_POST['monto'][$i];
		if($pendiente>1){
			$sql=mysqli_query($con,"UPDATE total_ventas SET pendiente='$pendiente',acuenta='$acuenta' WHERE serieventas='".$_POST['serie'][$i]."' AND documento='NOTA DE PEDIDO'");
		}
		else{
			$sql=mysqli_query($con,"UPDATE total_ventas SET pendiente='$pendiente',acuenta='$acuenta',credito='CANCELADO' WHERE serieventas='".$_POST['serie'][$i]."' AND documento='NOTA DE PEDIDO'");
		}
    }
?>