<?php
require_once('../connection.php');
  $search = explode(" ", $_GET['term']);
  $producto = "";
  foreach($search AS $s){
    $producto .= "cliente LIKE '%".mysqli_real_escape_string($con,$s)."%' AND ";
  }
  $producto = substr($producto, 0, -4);
  $query = "SELECT * FROM cliente WHERE $producto ORDER BY cliente LIMIT 10";
  $sql=mysqli_query($con,$query);
  while($row=mysqli_fetch_assoc($sql)){
    $arr[]=array('value'=> $row["cliente"]);
  }
  echo json_encode($arr);
?>