<?php 
require_once('../connection.php');
  $query1 = "INSERT INTO position (vendedor,latitud,longitud,fecha,hora) VALUES ('".$_REQUEST['user']."','".$_REQUEST['latitud']."','".$_REQUEST['longitud']."',NOW(),NOW())";
  $sql=mysqli_query($con,$query1);
  $sql2=mysqli_query($con,"SELECT activo FROM usuario WHERE nombre='".$_REQUEST['user']."' AND activo='SI'");
   $rs=mysqli_fetch_array($sql2);
   $arr= array('activo' => $rs["activo"]==null?'':$rs["activo"]);
   echo json_encode($arr);

 ?>
