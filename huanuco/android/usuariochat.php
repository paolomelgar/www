<?php 
require_once('../connection.php');
  $query='';
  if($_REQUEST['cargo']=='ADMIN'){
  $query = "SELECT nombre,cargo FROM usuario WHERE activo='SI'";
  }else{
  $query = "SELECT nombre,cargo FROM usuario WHERE activo='SI' AND cargo!='CLIENTE'";
  }
  $sql=mysqli_query($con,$query);
   $datos=array();
   while ($row=mysqli_fetch_object($sql)) {
   	 $datos[]=$row;
   }
   echo json_encode($datos);

 ?>