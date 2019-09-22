<?php 
require_once('../connection.php');
  $search = explode(" ", $_REQUEST['usuario']);
    $producto = "";
    foreach($search AS $s){
      $producto .= "nombre LIKE '%".mysqli_real_escape_string($con,$s)."%' AND ";
    }
    $producto = substr($producto, 0, -4);
    $query = "SELECT nombre,cargo FROM usuario WHERE $producto AND cargo!='CLIENTE' ORDER BY nombre";
  $sql=mysqli_query($con,$query);
   $datos=array();
   while ($row=mysqli_fetch_object($sql)) {
     $datos[]=$row;
   }
   echo json_encode($datos);

 ?>