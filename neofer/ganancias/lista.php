<?php
require_once('../connection.php');
  $ini = date('Y-m-d', strtotime(str_replace('/', '-', $_POST['inicio'])));
  $fin = date('Y-m-d', strtotime(str_replace('/', '-', $_POST['final'])));
  $query="('$ini' <= fecha AND fecha <= '$fin')";
  if(isset($_POST['cliente']) && !empty($_POST['cliente'])){
    $query.=" AND cliente='".$_POST['cliente']."'";
  }
  if(isset($_POST['producto']) && !empty($_POST['producto'])){
    $query.=" AND producto='".$_POST['producto']."'";
  }
  if(isset($_POST['marca']) && !empty($_POST['marca'])){
    $z=strlen($_POST['marca'])+1;
    $query.=" AND RIGHT(producto,".$z.") = ' ".$_POST['marca']."'";
  }
  if(isset($_POST['vendedor']) && !empty($_POST['vendedor'])){
    $query.=" AND vendedor='".$_POST['vendedor']."'";
  }
  $query.=" AND entregado='SI'";
  $i=0;
  $dat=array();
  $sql=mysqli_query($con,"SELECT * FROM notapedido WHERE $query UNION SELECT * FROM boleta WHERE $query UNION SELECT * FROM proforma WHERE $query UNION SELECT * FROM facturapaola WHERE $query UNION SELECT iddevolucion,seriedevolucion,documento,id,compra,producto,cantidad,unitario,importe,especial,cliente,fecha,hora,vendedor,entregado FROM devoluciones WHERE $query ORDER BY fecha,hora,idnota");
  while($row=mysqli_fetch_assoc($sql)){
    $dat[$i][0]=$row['serienota'];
    $dat[$i][1]=date('d/m/Y',strtotime(str_replace('-','/',$row['fecha'])));
    $dat[$i][2]=$row['hora'];
    $dat[$i][3]=$row['documento'];
    $dat[$i][4]=$row['cliente'];
    $dat[$i][5]=$row['producto'];
    $dat[$i][6]=number_format($row['cantidad'],0,",","");
    $dat[$i][7]=$row['compra'];
    $dat[$i][8]=number_format($row['unitario'],2,".","");
    $dat[$i][9]=number_format($row['unitario']-$row['compra'],2,".","");
    $dat[$i][10]=number_format($row['cantidad']*($row['unitario']-$row['compra']),2,".","");
    $dat[$i][11]=$row['vendedor'];
    $i++;
  }
  echo json_encode($dat);
?>