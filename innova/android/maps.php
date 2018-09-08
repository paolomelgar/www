<?php 
require_once('../connectionandroid.php');
  $query = "SELECT cliente,latitud,longitud,activo FROM cliente WHERE latitud!='' AND longitud!=''";
  $sql=mysqli_query($con,$query);
   $datos=array();
   while ($row=mysqli_fetch_object($sql)) {
     $datos[]=$row;
   }
   echo json_encode($datos);

 ?>