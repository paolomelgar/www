<?php 
    require_once('../connection.php');
	$sql=mysqli_query($con,"UPDATE pagoletras SET fecha='".date('Y-m-d', strtotime(str_replace('/', '-', $_POST['fecha'])))."' WHERE id='".$_POST['id']."'");
?>