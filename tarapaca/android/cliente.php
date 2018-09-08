<?php 
require_once('../connection.php');
  $search = explode(" ", $_REQUEST['cliente']);
  $producto = "";
  if($_REQUEST['tipo']=="ruc"){
    $producto .= "ruc LIKE '%".$_REQUEST['cliente']."%'";
  }else{
    foreach($search AS $s){
      $producto .= "cliente LIKE '%".mysqli_real_escape_string($con,$s)."%' AND ";
    }
    $producto = substr($producto, 0, -4);
  }
  $query = "SELECT ruc,cliente,direccion,telefono,representante,id_cliente FROM cliente WHERE $producto AND tipo='FERRETERIA' ORDER BY cliente LIMIT 10";
  $sql=mysqli_query($con,$query);
   $datos=array();
   while ($row=mysqli_fetch_object($sql)) {
   	 $datos[]=$row;
   }
   echo json_encode($datos);

 ?>