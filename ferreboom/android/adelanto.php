<?php 
require_once('../connection.php');
  $query = "SELECT fecha,adelanto,encargado FROM adelantos WHERE serie='".$_REQUEST['serie']."'";
  $sql=mysqli_query($con,$query);
   $datos=array();
   while ($row=mysqli_fetch_object($sql)) {
   	 $datos[]=$row;
   }
   echo json_encode($datos);

 ?>