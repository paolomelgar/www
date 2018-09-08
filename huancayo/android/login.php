<?php 
require_once('../connection.php');
$arr = array('login' => '');
  $sql=mysqli_query($con,"SELECT nombre,cargo FROM usuario WHERE usuario='".$_REQUEST['user']."' AND password='".$_REQUEST['pass']."' AND activo='SI'");
  
   $datos=array();
   while ($row=mysqli_fetch_object($sql)) {
     $datos[]=$row;
   }
   echo json_encode($datos);
?>