<?php
require_once('../connection.php');
  if(isset($_POST) && !empty($_POST)){
    $search = explode(" ", $_POST['b']);
    $producto = "";
    foreach($search AS $s){
      $producto .= "concat(ruc,cliente) LIKE '%".mysqli_real_escape_string($con,$s)."%' AND ";
    }
    $producto = substr($producto, 0, -4);
    $query = "SELECT * FROM cliente WHERE $producto AND activo!='ANULADO' ORDER BY cliente LIMIT 10";
    $result=mysqli_query($con,$query);
    $i=0;
    $dat=array();
    while($row=mysqli_fetch_assoc($result)){
      $dat[$i][0]=$row['ruc'];
      $dat[$i][1]=$row['cliente'];
      $dat[$i][2]=$row['direccion'];
      $i++;
    }
    echo json_encode($dat);
  }
?>