<?php 
require_once('../connection.php');
  $query = "SELECT producto,marca,p_promotor,p_mayor,p_compra,stock_real,id,cant_caja,foto,activo,familia,fecha,codigo,antiguedad FROM producto WHERE activo!='UNIDAD' ORDER BY producto";
  
  $sql=mysqli_query($con,$query);
  $datos=array();
  $i=0;
  while ($row=mysqli_fetch_assoc($sql)) {
    $datos[$i]["producto"]=$row["producto"];
    $datos[$i]["marca"]=$row["marca"];
    $datos[$i]["p_promotor"]=$row["p_promotor"];
    $datos[$i]["p_especial"]=$row["p_mayor"];
    $datos[$i]["p_compra"]=$row["p_compra"];
    $datos[$i]["stock_real"]=$row["stock_real"];
    $datos[$i]["id"]=$row["id"];
    $datos[$i]["cant_caja"]=$row["cant_caja"];
    $datos[$i]["foto"]=$row["foto"];
    $datos[$i]["activo"]=$row["activo"];
    $datos[$i]["familia"]=$row["familia"];
    $datos[$i]["fecha"]=$row["fecha"];
    $datos[$i]["codigo"]=$row["codigo"];
    $datos[$i]["antiguedad"]=$row["antiguedad"];
    $i++;
  }
  echo json_encode($datos);
?>