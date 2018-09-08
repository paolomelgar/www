<?php
  require_once('../connection.php');
  $search = explode(" ", $_GET['term']);
  $producto = "";
  foreach($search AS $s){
    $producto .= "concat(producto,marca) LIKE '%".mysqli_real_escape_string($con,$s)."%' AND ";
  }
  $producto = substr($producto, 0, -4);
  $query = "SELECT * FROM producto WHERE $producto ORDER BY producto LIMIT 10";
  $sql=mysqli_query($con,$query);
  while($row=mysqli_fetch_assoc($sql)){
    $arr[]=array('value'=> $row["producto"]." ".$row['marca']);
  }
  echo json_encode($arr);
?>