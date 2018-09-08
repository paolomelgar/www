<?php 
require_once('../connectionandroid.php');
  $query="month(fecha)='".$_REQUEST['month']."' AND year(fecha)='".$_REQUEST['year']."'";
  $query1="month(fechapago)='".$_REQUEST['month']."' AND year(fechapago)='".$_REQUEST['year']."'";
  $query = "SELECT monto,billete,fecha FROM pagoletras WHERE pendiente='SI' AND $query UNION SELECT pendiente AS monto,billete AS billete,fechapago AS fecha FROM total_compras WHERE credito='CREDITO' AND letra='NO' AND entregado='SI' AND $query1";
  $sql=mysqli_query($con,$query);
   $datos=array();
   while ($row=mysqli_fetch_object($sql)) {
     $datos[]=$row;
   }
   echo json_encode($datos);

 ?>