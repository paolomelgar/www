<?php 
require_once('../connection.php');
if(isset($_POST) && !empty($_POST)){
	switch ($_POST['pos']) {
		case '7':
		$sql=mysqli_query($con,"UPDATE producto SET proveedor='".$_POST['val']."' WHERE id='".$_POST['id']."'");
		break;
		case '8':
		$sql=mysqli_query($con,"UPDATE producto SET ubicacion='".$_POST['val']."' WHERE id='".$_POST['id']."'");
		break;
		case '9':
		$sql=mysqli_query($con,"UPDATE producto SET ubicacion2='".$_POST['val']."' WHERE id='".$_POST['id']."'");
		break;
		case '10':
		$sql=mysqli_query($con,"UPDATE producto SET cant_caja='".$_POST['val']."' WHERE id='".$_POST['id']."'");
		break;
	}
}