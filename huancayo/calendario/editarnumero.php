<?php 
    require_once('../connection.php');
    switch ($_POST['tipo']) {
	    case 'unico':
	    $sql=mysqli_query($con,"UPDATE pagoletras SET unico='".$_POST['value']."' WHERE id='".$_POST['id']."'");
	    break;
	    case 'fecha':
	    $sql=mysqli_query($con,"UPDATE pagoletras SET fecha='".date('Y-m-d', strtotime(str_replace('/', '-', $_POST['value'])))."' WHERE id='".$_POST['id']."'");
	    break;
	    case 'total':
	    $sql=mysqli_query($con,"UPDATE total_compras SET fechapago='".date('Y-m-d', strtotime(str_replace('/', '-', $_POST['value'])))."' WHERE id='".$_POST['id']."'");
	    break;
	}
?>