<?php
require_once('../connection.php');
  if(isset($_POST) && !empty($_POST)){
    $search = explode(" ", $_POST['b']);
    $producto = "";
    foreach($search AS $s){
      $producto .= "concat(producto,' ',marca) LIKE '%".mysqli_real_escape_string($con,$s)."%' AND ";
    }
    $producto = substr($producto, 0, -4);
    $query = "SELECT * FROM producto WHERE $producto AND activo!='NO' AND activo!='ANULADO' ORDER BY producto,marca LIMIT 12";
    $result=mysqli_query($con,$query);
    $i=0;
    $dat=array();
    while($row=mysqli_fetch_assoc($result)){
      $dat[$i][0]=$row['id'];
      $dat[$i][1]=$row['producto'];
      $dat[$i][2]=$row['marca'];
      $dat[$i][3]=$row['p_compra'];
      $dat[$i][4]=$row['cant_caja'];
      $dat[$i][5]=$row['stock_real'];
      $dat[$i][6]=$row['p_promotor'];
      $i++;
    }
    echo json_encode($dat);
  }
?>