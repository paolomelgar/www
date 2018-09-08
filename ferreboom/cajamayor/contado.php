<?php
  require_once('../connection.php');
  if(isset($_POST) && !empty($_POST)){
    $fecha = date('Y-m-d', strtotime(str_replace('/', '-', $_POST['fecha'])));
    $sql=mysqli_query($con,"SELECT * FROM total_compras WHERE fechafactura='$fecha' AND credito='CONTADO' AND entregado='SI' ORDER BY documento,serie");
    $i=0;
    $dat=array();
    while($row=mysqli_fetch_assoc($sql)){
      $dat[$i][0]=$row['serie']."-".$row['numero'];
      $dat[$i][1]=$row['hora'];
      $dat[$i][2]=$row['documento'];
      $dat[$i][3]=$row['proveedor'];
      $dat[$i][4]=$row['montototal'];
      $dat[$i][5]=$row['cambio'];
      $i++;
    }
    echo json_encode($dat);
  }
?>