<?php 
require_once('../connection.php');
if(isset($_POST) && !empty($_POST)){
	$res=mysqli_query($con,"INSERT INTO marca (marca,activo,foto) VALUES ('".$_POST['b']."','SI','NO')");
} ?>