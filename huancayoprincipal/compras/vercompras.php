<?php
require_once('../connection.php');
  if(isset($_POST) && !empty($_POST)){
    $ini = date('Y-m-d', strtotime(str_replace('/', '-', $_POST['ini'])));
    $fin = date('Y-m-d', strtotime(str_replace('/', '-', $_POST['fin'])));
    $query="('$ini' <= fechafactura AND fechafactura <= '$fin')";
    if(isset($_POST['proveedor']) && !empty($_POST['proveedor'])){
      $query.=" AND proveedor='".$_POST['proveedor']."'";
    }
    $sql=mysqli_query($con,"SELECT * FROM total_compras WHERE $query ORDER BY fechafactura,hora,documento");
    $i=0;
    $dat=array();
    while($row=mysqli_fetch_assoc($sql)){
      $dat[$i][0]=$row['serie']."-".$row['numero'];
      $dat[$i][1]=date('d/m/Y',strtotime(str_replace('-','/',$row['fechafactura'])));
      $dat[$i][2]=$row['hora'];
      $dat[$i][3]=$row['documento'];
      $dat[$i][4]=$row['proveedor'];
      $dat[$i][5]=$row['credito'];
      $dat[$i][6]=$row['entregado'];
      $dat[$i][7]=$row['montototal'];
      $dat[$i][8]=$row['value'];
      $dat[$i][9]=$row['billete'];
      $dat[$i][10]=$row['usuario'];
      $i++;
    }
    echo json_encode($dat);
  }
?>