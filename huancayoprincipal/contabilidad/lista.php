<?php
  require_once('../connection.php');
  $ini = date('Y-m-d', strtotime(str_replace('/', '-', $_POST['inicio'])));
  $fin = date('Y-m-d', strtotime(str_replace('/', '-', $_POST['final'])));
  $query="('$ini' <= fecha AND fecha <= '$fin')";
  $query2="('$ini' <= fechafactura AND fechafactura <= '$fin')";
  $sql=mysqli_query($con,"SELECT * FROM ingresos WHERE $query AND numfactura!='NO' AND ingreso='EGRESO' ORDER BY fechafactura");
  $sql2=mysqli_query($con,"SELECT * FROM total_compras WHERE $query2 AND documento='FACTURA BOOM' ORDER BY fechafactura");
  $i=0;
  $dat=array();
  while($row=mysqli_fetch_assoc($sql)){
    $dat[$i][0]=date('d/m/Y', strtotime(str_replace('-','/',$row['fechafactura'])));
    $dat[$i][1]=$row['ingreso'];
    $dat[$i][2]=$row['tipo'];
    $dat[$i][3]=$row['monto'];
    $dat[$i][4]=$row['detalle'];
    $dat[$i][5]=$row['usuario'];
    $dat[$i][6]='GASTOS EMPRESA';
    $dat[$i][7]=$row['id'];
    $dat[$i][8]="";
    $dat[$i][9]=$row['numfactura'];
    $dat[$i][10]=date('d/m/Y', strtotime(str_replace('-','/',$row['fecha'])));
    $i++;
  }
  while($row=mysqli_fetch_assoc($sql2)){
    $dat[$i][0]=date('d/m/Y', strtotime(str_replace('-','/',$row['fechafactura'])));
    $dat[$i][1]='NADA';
    $dat[$i][2]='NADA';
    $dat[$i][3]=$row['montototal'];
    $dat[$i][4]=$row['proveedor'];
    $dat[$i][5]='NADA';
    $dat[$i][6]='COMPRAS PROVEEDOR';
    $dat[$i][7]='NADA';
    $dat[$i][8]=$row['numero'];
    $dat[$i][9]=$row['serie'];
    $dat[$i][10]=date('d/m/Y', strtotime(str_replace('-','/',$row['fechafactura'])));
    $i++;
  }
  echo json_encode($dat);
?>