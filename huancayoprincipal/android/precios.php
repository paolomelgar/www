<?php 
require_once('../connection.php');
  $query = "SELECT producto,marca,p_promotor,p_especial,p_compra,stock_real,id,cant_caja,foto,activo,familia,fecha FROM producto ORDER BY producto";
  $sql=mysqli_query($con,$query);
  $datos=array();
  while ($row=mysqli_fetch_object($sql)) {
     $datos[]=$row;
  }
  echo json_encode($datos);
?>