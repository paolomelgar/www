<?php
  require_once('../connection.php');
  $search = explode(" ", $_GET['term']);
  $producto = "";
  foreach($search AS $s){
    $producto .= "proveedor LIKE '%".mysqli_real_escape_string($con,$s)."%' AND ";
  }
  $producto = substr($producto, 0, -4);
  $query = "SELECT DISTINCT(proveedor) FROM producto WHERE $producto ORDER BY proveedor LIMIT 15";
  $sql=mysqli_query($con,$query);
  while($row=mysqli_fetch_assoc($sql)){
    $arr[]=array('value'=> $row["proveedor"]);
  }
  echo json_encode($arr);
?>