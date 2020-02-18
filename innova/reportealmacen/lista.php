<?php
  require_once('../connection.php');
  $ini = date('Y-m-d', strtotime(str_replace('/', '-', $_POST['inicio'])));
  $fin = date('Y-m-d', strtotime(str_replace('/', '-', $_POST['final'])));
  $query="('$ini' <= fecha AND fecha <= '$fin')";
  $sql=mysqli_query($con,"SELECT * FROM reportealmacen WHERE $query ORDER BY fecha,hora");
  $i=0;
  $dat=array();
  while($row=mysqli_fetch_assoc($sql)){
    $dat[$i][0]=$row['seriedevolucion'];
    $dat[$i][1]=date('d/m/Y', strtotime(str_replace('-','/',$row['fecha'])));
    $dat[$i][2]=$row['producto'];
    $dat[$i][3]=number_format($row['cantidad'],0);
    $dat[$i][4]=$row['compra'];
    $dat[$i][5]=number_format($row['cantidad']*$row['compra'],2);
    $dat[$i][6]=$row['estado'];
    $dat[$i][7]=$row['iddevolucion'];
    $dat[$i][8]=$row['usuario'];
    $i++;
  }
  echo json_encode($dat);
?>