<?php 
require_once('../connection.php');
  $query1 = "SELECT cliente,vendedor,hora,total,seriepedido FROM total_pedido WHERE entregado='NO' ORDER BY hora";
  $sql=mysqli_query($con,$query1);
   $datos=array();
   while ($row=mysqli_fetch_object($sql)) {
   	 $datos[]=$row;
   }
   echo json_encode($datos);

 ?>