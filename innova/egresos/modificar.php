<?php 
require_once('../connection.php');
if(isset($_POST) && !empty($_POST)){
	switch ($_POST['pos']) {
		case '1':
		$sql=mysqli_query($con,"UPDATE ingresos SET fecha='".date('d/m/Y', strtotime(str_replace('-','/',$_POST['val'])))."' WHERE id='".$_POST['id']."'");
		break;
		case '2':
		$sql=mysqli_query($con,"UPDATE ingresos SET ingreso='".$_POST['val']."' WHERE id='".$_POST['id']."'");
		break;
		case '4':
		$sql=mysqli_query($con,"UPDATE ingresos SET tipo='".$_POST['val']."' WHERE id='".$_POST['id']."'");
		break;
		case '5':
		$sql=mysqli_query($con,"UPDATE ingresos SET monto='".$_POST['val']."' WHERE id='".$_POST['id']."'");
		break;
		case '6':
		$sql=mysqli_query($con,"UPDATE ingresos SET detalle='".$_POST['val']."' WHERE id='".$_POST['id']."'");
		break;
		
	}
}