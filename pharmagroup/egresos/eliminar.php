<?php
  require_once('../connection.php');
  $fecha = date('Y-m-d', strtotime(str_replace('/', '-', $_POST['fecha'])));
  if(isset($_POST) && !empty($_POST)){
  	if($_POST['sesion']=='CAJERO'){
  		if($_POST['tipo']=='INGRESO'){
		    $ins=mysqli_query($con,"UPDATE dinerodiario SET ingresos=(ingresos-".$_POST['monto'].") WHERE fecha='$fecha'");
		}
		else{
			$ins=mysqli_query($con,"UPDATE dinerodiario SET egresos=(egresos-".$_POST['monto'].") WHERE fecha='$fecha'");
		}
	}
	else{
		if($_POST['tipo']=='INGRESO'){
		    $ins=mysqli_query($con,"UPDATE cajamayor SET ingresos=(ingresos-".$_POST['monto'].") WHERE fecha='$fecha'");
		}
		else{
			$ins=mysqli_query($con,"UPDATE cajamayor SET egresos=(egresos-".$_POST['monto'].") WHERE fecha='$fecha'");
		}
	}
	$p=mysqli_query($con,"UPDATE ingresos SET ingreso='ANULADO' WHERE id='".$_POST['id']."'");
  }
?>