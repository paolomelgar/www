<?php 
require_once('../connection.php');
  $query="credito='CREDITO' AND entregado='SI'";
  if(isset($_REQUEST['cliente']) && !empty($_REQUEST['cliente'])){
    $query .= " AND cliente='".$_REQUEST['cliente']."'";
  }
  if($_REQUEST['cargo']!='PROMOTOR'){
    $query1 = "SELECT cliente,fecha,fechapago,vendedor,total,pendiente,acuenta,serieventas FROM total_ventas WHERE $query ORDER BY fecha";
  }else{
    $query.=" AND vendedor='".$_REQUEST['vendedor']."'";
    $query1 = "SELECT cliente,fecha,fechapago,vendedor,total,pendiente,acuenta,serieventas FROM total_ventas WHERE $query ORDER BY fecha";
  }
  $sql=mysqli_query($con,$query1);
   $datos=array();
   while ($row=mysqli_fetch_object($sql)) {
     $datos[]=$row;
   }
   echo json_encode($datos);

 ?>