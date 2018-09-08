<?php
require_once('../connection.php');
    $ini = date('Y-m-d', strtotime(str_replace('/', '-', $_POST['ini'])));
    $sql=mysqli_query($con,"SELECT * FROM total_pedido WHERE vendedor='".$_SESSION['nombre']."' AND fecha='".$ini."' ORDER BY hora DESC");
    $i=0;
    $dat=array();
    while($row=mysqli_fetch_assoc($sql)){
      $dat[$i][0]=$row['seriepedido'];
      $dat[$i][1]=$row['hora'];
      $dat[$i][2]=$row['cliente'];
      $dat[$i][3]=$row['entregado'];
      $dat[$i][4]=$row['total'];
      $dat[$i][5]=$row['fecha'];
      $i++;
    }
    echo json_encode($dat);
?>