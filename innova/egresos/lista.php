<?php
  require_once('../connection.php');
  $ini = date('Y-m-d', strtotime(str_replace('/', '-', $_POST['inicio'])));
  $fin = date('Y-m-d', strtotime(str_replace('/', '-', $_POST['final'])));
  $query="('$ini' <= fecha AND fecha <= '$fin')";
  if($_POST['change']=='TODOS'){
    $query.="";
  }
  else{
    $query.=" AND ingreso='".$_POST['change']."'";
  }
  $sql=mysqli_query($con,"SELECT * FROM ingresos WHERE $query ORDER BY fecha");
  $i=0;
  $dat=array();
  while($row=mysqli_fetch_assoc($sql)){
    $dat[$i][0]=date('d/m/Y', strtotime(str_replace('-','/',$row['fecha'])));
    $dat[$i][1]=$row['ingreso'];
    $dat[$i][2]=$row['tipo'];
    $dat[$i][3]=$row['monto'];
    $dat[$i][4]=$row['detalle'];
    $dat[$i][5]=$row['usuario'];
    $dat[$i][6]=$row['sesion'];
    $dat[$i][7]=$row['id'];
    $dat[$i][8]=$row['mediopago'];
    $i++;
  }
  echo json_encode($dat);
?>