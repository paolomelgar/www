<?php 
require_once('../connection.php');
  $search = explode(" ", $_REQUEST['proveedor']);
    $producto = "";
    foreach($search AS $s){
      $producto .= "proveedor LIKE '%".mysqli_real_escape_string($con,$s)."%' AND ";
    }
    $producto = substr($producto, 0, -4);
    $query = "SELECT proveedor,mail,celular FROM proveedor WHERE $producto ORDER BY proveedor";
  $sql=mysqli_query($con,$query);
   $datos=array();
   while ($row=mysqli_fetch_object($sql)) {
     $datos[]=$row;
   }
   echo json_encode($datos);

 ?>