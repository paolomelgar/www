<?php 
require_once('../connection.php');
    $sql=mysqli_query($con,"UPDATE usuario SET password='".$_POST['pass']."' WHERE nombre='".$_POST['nombre']."'");
?>