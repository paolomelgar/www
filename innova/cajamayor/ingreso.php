<?php
  require_once('../connection.php');
  if(isset($_POST) && !empty($_POST)){
    $fecha = date('Y-m-d', strtotime(str_replace('/', '-', $_POST['fecha'])));
    $sql=mysqli_query($con,"SELECT * FROM ingresos WHERE ingreso='INGRESO' AND fecha='$fecha' AND sesion!='CAJERO'");
    $i=0;
    $dat=array();
    while($row=mysqli_fetch_assoc($sql)){
      $dat[$i][0]=$row['sesion'];
      $dat[$i][1]=$row['tipo'];
      $dat[$i][2]=$row['detalle'];
      $dat[$i][3]=$row['monto'];
      $dat[$i][4]=$row['usuario'];
      $i++;
    }
    echo json_encode($dat);
  }
?>