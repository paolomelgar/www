<?php
require_once('../connection.php');
  if(isset($_POST) && !empty($_POST)){
    $ini = date('Y-m-d', strtotime(str_replace('/', '-', $_POST['ini'])));
    $fin = date('Y-m-d', strtotime(str_replace('/', '-', $_POST['fin'])));
    $query="('$ini' <= fecha AND fecha <= '$fin')";
    if(isset($_POST['cliente']) && !empty($_POST['cliente'])){
      $query.=" AND cliente='".$_POST['cliente']."'";
    }
    $sql=mysqli_query($con,"SELECT * FROM total_pedido WHERE $query AND vendedor='".$_POST['ven']."' ORDER BY seriepedido");
    $i=0;
    $dat=array();
    while($row=mysqli_fetch_assoc($sql)){
      $dat[$i][0]=$row['seriepedido'];
      $dat[$i][1]=date('d/m/Y',strtotime(str_replace('-','/',$row['fecha'])));
      $dat[$i][2]=$row['hora'];
      $dat[$i][3]=$row['vendedor'];
      $dat[$i][4]=$row['cliente'];
      $dat[$i][5]=$row['nropedido'];
      $dat[$i][6]=$row['entregado'];
      $dat[$i][7]=$row['total'];
      $i++;
    }
    echo json_encode($dat);
  }
?>