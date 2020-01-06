<?php
  require_once('../connection.php');
    if(isset($_POST) && !empty($_POST)){
      $a=mysqli_query($con,"SELECT sum(adelanto) FROM adelantos WHERE forma='EFECTIVO' AND fecha='".date('Y-m-d', strtotime(str_replace('/', '-', $_POST['fecha'])))."' AND sesion!='CAJERO'");
      $b=mysqli_query($con,"SELECT sum(monto) FROM ingresos WHERE ingreso='INGRESO' AND mediopago='EFECTIVO' AND fecha='".date('Y-m-d', strtotime(str_replace('/', '-', $_POST['fecha'])))."' AND sesion!='CAJERO'");
      $c=mysqli_query($con,"SELECT sum(montototal) FROM total_compras WHERE fechafactura='".date('Y-m-d', strtotime(str_replace('/', '-', $_POST['fecha'])))."' AND credito='CONTADO' AND entregado='SI'");
      $d=mysqli_query($con,"SELECT sum(adelanto) FROM adelantoscompras WHERE mediopago='EFECTIVO' AND fecha='".date('Y-m-d', strtotime(str_replace('/', '-', $_POST['fecha'])))."' AND cambio=' '");


      $d5=mysqli_query($con,"SELECT sum(adelanto*cambio) FROM adelantoscompras WHERE mediopago='EFECTIVO' AND fecha='".date('Y-m-d', strtotime(str_replace('/', '-', $_POST['fecha'])))."' AND cambio>0");


      $d6=mysqli_query($con,"SELECT sum(adelanto*cambio) FROM adelantosletra WHERE mediopago='EFECTIVO' AND fechapago='".date('Y-m-d', strtotime(str_replace('/', '-', $_POST['fecha'])))."' AND cambio>0");


      $e=mysqli_query($con,"SELECT sum(adelanto) FROM adelantosletra WHERE mediopago='EFECTIVO' AND fechapago='".date('Y-m-d', strtotime(str_replace('/', '-', $_POST['fecha'])))."' AND cambio=' '");
      $f=mysqli_query($con,"SELECT sum(monto) FROM ingresos WHERE ingreso='EGRESO' AND mediopago='EFECTIVO' AND fecha='".date('Y-m-d', strtotime(str_replace('/', '-', $_POST['fecha'])))."' AND sesion!='CAJERO'");
      $a1=mysqli_fetch_row($a);
      $b1=mysqli_fetch_row($b);
      $c1=mysqli_fetch_row($c);
      $d1=mysqli_fetch_row($d);
      $d2=mysqli_fetch_row($d5);
      $d3=mysqli_fetch_row($d6);
      $e1=mysqli_fetch_row($e);
      $f1=mysqli_fetch_row($f);
      $resul=mysqli_query($con,"SELECT * FROM dinerodiario WHERE fecha='".date('Y-m-d', strtotime(str_replace('/', '-', $_POST['fecha'])))."'");
      $row1 = mysqli_fetch_row($resul);
      $ar=array();
      $ar[0]=number_format($row1[2]+0, 2, '.', '');
      $ar[1]=number_format($a1[0]+0, 2, '.', '');
      $ar[2]=number_format($b1[0]+0, 2, '.', '');
      $ar[3]=number_format($c1[0]+0, 2, '.', '');
      $ar[4]=number_format($d1[0]+$d2[0]+$e1[0]+$d3[0]+0, 2, '.', '');
      $ar[5]=number_format($f1[0]+0, 2, '.', '');
      echo json_encode($ar);
    }
?>