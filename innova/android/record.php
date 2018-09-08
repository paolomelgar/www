<?php 
require_once('../connectionandroid.php');
  $query="entregado='SI' AND MONTH(fecha)=".($_REQUEST['month']+1)." AND YEAR(fecha)=".$_REQUEST['year']." AND documento='NOTA DE PEDIDO' AND ";
  if(isset($_REQUEST['cliente']) && !empty($_REQUEST['cliente'])){
    $query .= "cliente='".$_REQUEST['cliente']."' AND ";
  }
  $query.="vendedor='".$_REQUEST['vendedor']."'";
  $query1 = "SELECT cliente,fecha,credito,total,pendiente,acuenta,serieventas FROM total_ventas WHERE $query ORDER BY fecha";
  $sql=mysqli_query($con,$query1);
   $datos=array();
   while ($row=mysqli_fetch_object($sql)) {
     $datos[]=$row;
   }
   echo json_encode($datos);

 ?>