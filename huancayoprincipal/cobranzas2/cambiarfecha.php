<?php 
    require_once('../connection.php');
	$sql=mysqli_query($con,"UPDATE letraclientes SET fechapago='".date('Y-m-d', strtotime(str_replace('/', '-', $_POST['fecha'])))."' WHERE id='".$_POST['id']."'");
?>