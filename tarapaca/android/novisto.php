<?php 
require_once('../connection.php');
    $sql=mysqli_query($con,'SELECT emisor,mensaje,fecha,hora,visto FROM chat WHERE (visto="MEDIO" OR visto="FIN") AND receptor="'.$_POST['usuario'].'"');
    $datos=array();
   while ($row=mysqli_fetch_object($sql)) {
   	 $datos[]=$row;
   }
   echo json_encode($datos);
?>