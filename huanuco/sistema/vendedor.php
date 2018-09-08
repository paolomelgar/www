<?php
require_once('../connection.php');
  $search = explode(" ", $_POST['b']);
  $producto = "";
  foreach($search AS $s){
    $producto .= "nombre LIKE '%".mysqli_real_escape_string($con,$s)."%' AND ";
  }
  $producto = substr($producto, 0, -4);
  $sq=mysqli_query($con,"SELECT nombre,cargo FROM usuario WHERE $producto AND activo='SI'");
  $i=0;
  $dat=array();
  while($row=mysqli_fetch_assoc($sq)){
    $dat[$i][0]=$row['nombre'];
    $dat[$i][1]=$row['cargo'];
    $i++;
  }
  echo json_encode($dat);
?>