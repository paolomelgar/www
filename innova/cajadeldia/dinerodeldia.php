<?php
  require_once('../connection.php');
    if(isset($_POST) && !empty($_POST)){
      /*$f=array();
      $g=array();
      $i=0;
      $h=mysqli_query($con,"SELECT DISTINCT(vendedor) FROM total_ventas WHERE fecha='".date('Y-m-d', strtotime(str_replace('/', '-', $_POST['fecha'])))."' AND credito='CONTADO' AND entregado='SI'");
        while($r=mysqli_fetch_assoc($h){
          $quer = mysqli_query($con,"SELECT SUM(total) FROM total_ventas WHERE vendedor='".$r['vendedor']."' AND fecha='".date('Y-m-d', strtotime(str_replace('/', '-', $_POST['fecha'])))."' AND credito='CONTADO' AND entregado='SI'");
          $rr=mysqli_fetch_row($quer);
          $f[$i]=$rr[0];
          $g[$i]=$r['vendedor'];
          $i++;
        } */
      $a=mysqli_query($con,"SELECT sum(total) FROM total_ventas WHERE fecha='".date('Y-m-d', strtotime(str_replace('/', '-', $_POST['fecha'])))."' AND credito='CONTADO' AND entregado='SI'");
      $e=mysqli_query($con,"SELECT count(*) FROM total_ventas WHERE fecha='".date('Y-m-d', strtotime(str_replace('/', '-', $_POST['fecha'])))."' AND credito='CONTADO' AND entregado='SI'");
      $b=mysqli_query($con,"SELECT sum(adelanto) FROM adelantos WHERE fecha='".date('Y-m-d', strtotime(str_replace('/', '-', $_POST['fecha'])))."' AND sesion='CAJERO'");
      $c=mysqli_query($con,"SELECT sum(monto) FROM ingresos WHERE ingreso='INGRESO' AND fecha='".date('Y-m-d', strtotime(str_replace('/', '-', $_POST['fecha'])))."' AND sesion='CAJERO'");
      $d=mysqli_query($con,"SELECT sum(monto) FROM ingresos WHERE ingreso='EGRESO' AND fecha='".date('Y-m-d', strtotime(str_replace('/', '-', $_POST['fecha'])))."' AND sesion='CAJERO'");
      $a1=mysqli_fetch_row($a);
      $b1=mysqli_fetch_row($b);
      $c1=mysqli_fetch_row($c);
      $d1=mysqli_fetch_row($d);
      $e1=mysqli_fetch_row($e);
      $resul=mysqli_query($con,"SELECT * FROM dinerodiario WHERE fecha='".date('Y-m-d', strtotime(str_replace('/', '-', $_POST['fecha'])))."'");
      $row1 = mysqli_fetch_row($resul);
      $ar=array();
    	$ar[0]=number_format($a1[0]+0, 2, '.', '');
      $ar[1]=number_format($b1[0]+0, 2, '.', '');
      $ar[2]=number_format($c1[0]+0, 2, '.', '');
    	$ar[3]=number_format($d1[0]+0, 2, '.', '');
      $ar[4]=$row1[2];
    	$ar[5]=$row1[3];
      $ar[7]=$row1[5];
      $ar[6]=number_format($e1[0]+0, 0, '.', '');
    	echo json_encode($ar);
    }
?>
