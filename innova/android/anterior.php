<?php 
require_once('../connectionandroid.php');
  if($_REQUEST['cargo']=='ALMACEN'){
	  $query="producto='".$_REQUEST['producto']."'";
	  $query = "SELECT * FROM compras WHERE $query AND entregado='SI' ORDER BY fecha DESC LIMIT 3";
  }else if($_REQUEST['cargo']=='ADMIN'){
    if($_REQUEST['cliente']==""){
      $query="idproducto='".$_REQUEST['producto']."'";
      $query = "SELECT * FROM compras WHERE $query AND entregado='SI' ORDER BY fecha DESC LIMIT 3";
    }else{
      $query="cliente='".$_REQUEST['cliente']."' AND id='".$_REQUEST['producto']."'";
      $query = "SELECT * FROM notapedido WHERE $query UNION SELECT * FROM proforma WHERE $query UNION SELECT * FROM boleta WHERE $query AND entregado='SI' ORDER BY fecha DESC LIMIT 3";
    }
  }else{
	  $query="cliente='".$_REQUEST['cliente']."' AND id='".$_REQUEST['producto']."'";
	  $query = "SELECT * FROM notapedido WHERE $query UNION SELECT * FROM proforma WHERE $query UNION SELECT * FROM boleta WHERE $query AND entregado='SI' ORDER BY fecha DESC LIMIT 3";
	}
  $sql=mysqli_query($con,$query);
   $datos=array();
   $i=0;
   while ($row=mysqli_fetch_assoc($sql)) {
    $datos[$i]["fecha"]=$row["fecha"];
    $datos[$i]["cantidad"]=$row["cantidad"];
    if($_REQUEST['cargo']=='ADMIN' && $_REQUEST['cliente']==""){
      $datos[$i]["producto"]=$row["proveedor"];
      if($row['billete']=='SOLES'){
        $datos[$i]["unitario"]="S/ ".$row["unitario"];
      }else{
        $datos[$i]["unitario"]="$ ".$row["unitario"];
      }
    }else{
      $datos[$i]["producto"]=$row["producto"];
      $datos[$i]["unitario"]="S/ ".$row["unitario"];
    }
    $i++;
   }
   echo json_encode($datos);

 ?>