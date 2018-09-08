<?php 
require_once('../connection.php');
  $sql=mysqli_query($con,"INSERT INTO cliente (ruc,cliente,direccion,telefono,representante,tipo,activo) VALUES ('".$_REQUEST['ruc']."','".$_REQUEST['cliente']."','".$_REQUEST['direccion']."','".$_REQUEST['telefono']."','".$_REQUEST['representante']."','FERRETERIA','SI')");
  
  $res = mysqli_query($con,"SELECT MAX(id_cliente) AS id_cliente FROM cliente");

   $datos=array();
   while ($row=mysqli_fetch_object($res)) {
     $datos[]=$row;
   }
   echo json_encode($datos);
?>