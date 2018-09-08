<?php
require_once('../connection.php');
  $i=0;
  $dat=array();
  $sql=mysqli_query($con,"SELECT * FROM alerta WHERE estado='SI' ORDER BY fecha");
  while($row=mysqli_fetch_assoc($sql)){
    $dat[$i][0]=$row['tipo'];
    $dat[$i][1]=$row['concepto'];
    $dat[$i][2]=$row['fecha'];
    $dat[$i][3]=$row['usuario'];
    $dat[$i][4]=$row['estado'];
    $i++;
  }
  echo json_encode($dat);
?>