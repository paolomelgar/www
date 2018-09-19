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
		$sql=mysqli_query($con,"UPDATE producto SET cant_caja='".$_POST['val']."' WHERE id='".$_POST['id']."'");
		break;
		case '10':
		$sql=mysqli_query($con,"UPDATE producto SET caja_master='".$_POST['val']."' WHERE id='".$_POST['id']."'");
		break;
		case '11':
		$sql=mysqli_query($con,"UPDATE producto SET stock_real='".$_POST['val']."' WHERE id='".$_POST['id']."'");
		break;
		case '12':
		$sql=mysqli_query($con,"UPDATE producto SET stock_con='".$_POST['val']."' WHERE id='".$_POST['id']."'");
		break;
		case '13':
		$sql=mysqli_query($con,"UPDATE producto SET stock_con1='".$_POST['val']."' WHERE id='".$_POST['id']."'");
		break;
		case '14':
		$sql=mysqli_query($con,"UPDATE producto SET p_mayor='".$_POST['val']."' WHERE id='".$_POST['id']."'");
		break;
		case '15':
		$sql=mysqli_query($con,"UPDATE producto SET p_promotor='".$_POST['val']."' WHERE id='".$_POST['id']."'");
		break;
		case '16':
		$sql=mysqli_query($con,"UPDATE producto SET p_especial='".$_POST['val']."' WHERE id='".$_POST['id']."'");
		break;
		case '17':
		$sql=mysqli_query($con,"UPDATE producto SET p_franquicia='".$_POST['val']."' WHERE id='".$_POST['id']."'");
		break;
		case '18':
		$sql=mysqli_query($con,"UPDATE producto SET p_compra='".$_POST['val']."' WHERE id='".$_POST['id']."'");
		break;
		
	}
}
?>