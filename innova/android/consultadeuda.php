<?php 
require_once('../connectionandroid.php');
  $query="day(fecha)='".$_REQUEST['day']."' AND month(fecha)='".$_REQUEST['month']."' AND year(fecha)='".$_REQUEST['year']."'";
  $query1="day(fechapago)='".$_REQUEST['day']."' AND month(fechapago)='".$_REQUEST['month']."' AND year(fechapago)='".$_REQUEST['year']."'";
  $query = "SELECT monto,billete,proveedor,unico FROM pagoletras WHERE pendiente='SI' AND $query UNION SELECT pendiente AS monto, billete ,proveedor, concat(serie,'-',numero) AS unico FROM total_compras WHERE credito='CREDITO' AND letra='NO' AND entregado='SI' AND $query1";
  $sql=mysqli_query($con,$query);
   $datos=array();
   while ($row=mysqli_fetch_object($sql)) {
     $datos[]=$row;
   }
   echo json_encode($datos);

 ?>