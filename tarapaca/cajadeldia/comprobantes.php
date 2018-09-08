<?php
  require_once('../connection.php');
  if(isset($_POST) && !empty($_POST)){
    $fecha = date('Y-m-d', strtotime(str_replace('/', '-', $_POST['fecha'])));
    $sql=mysqli_query($con,"SELECT * FROM total_ventas WHERE fecha='$fecha' AND credito='CONTADO' ORDER BY hora");
    $i=0;
    $dat=array();
    while($row=mysqli_fetch_assoc($sql)){
      $dat[$i][0]=$row['serieventas'];
      $dat[$i][1]=$row['hora'];
      $dat[$i][2]=$row['documento'];
      $dat[$i][3]=$row['cliente'];
      $dat[$i][4]=$row['total'];
      $dat[$i][5]=$row['entregado'];
      $i++;
    }
    echo json_encode($dat);
  }
?>