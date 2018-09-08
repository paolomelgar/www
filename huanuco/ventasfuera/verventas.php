<?php
session_start();
  require_once('../connection.php');
  if(isset($_POST) && !empty($_POST)){
    $ini = date('Y-m-d', strtotime(str_replace('/', '-', $_POST['ini'])));
    $fin = date('Y-m-d', strtotime(str_replace('/', '-', $_POST['fin'])));
    $query="('$ini' <= fecha AND fecha <= '$fin')";
    $sql=mysqli_query($con,"SELECT * FROM total_ventas WHERE $query AND documento='NOTA DE PEDIDO' AND cliente='".$_SESSION["nombre"]."' AND entregado='SI' ORDER BY fecha,hora,documento,serieventas");
    $i=0;
    $dat=array();
    while($row=mysqli_fetch_assoc($sql)){
      $dat[$i][0]=$row['serieventas'];
      $dat[$i][1]=date('d/m/Y',strtotime(str_replace('-','/',$row['fecha'])));
      $dat[$i][2]=$row['hora'];
      $dat[$i][3]=$row['cliente'];
      $dat[$i][4]=$row['credito'];
      $dat[$i][5]=$row['total'];
      $i++;
    }
    echo json_encode($dat);
  }
?>