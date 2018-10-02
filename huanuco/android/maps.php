<?php 
require_once('../connection.php');
  $query = "SELECT ruc,cliente,direccion,telefono,representante,id_cliente,latitud,longitud,activo FROM cliente WHERE latitud!='' AND longitud!='' AND activo!='ANULADO'";
  $sql=mysqli_query($con,$query);
   $datos=array();
   while ($row=mysqli_fetch_object($sql)) {
     $datos[]=$row;
   }
   echo json_encode($datos);

 ?>