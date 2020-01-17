<?php 
require_once('../connection.php');
if(isset($_POST) && !empty($_POST)){
	switch ($_POST['pos']) {
		case '3':
		$sql=mysqli_query($con,"UPDATE producto SET porcentaje='".$_POST['val']."' WHERE id='".$_POST['id']."'");
		break;
		case '4':
		$sql=mysqli_query($con,"UPDATE producto SET cant_caja='".$_POST['val']."' WHERE id='".$_POST['id']."'");
		break;
	}
}