<?php
  require_once('../connection.php');
  $q=mysqli_query($con,"SELECT MAX(serie) FROM letraclientes");
  $qq=mysqli_query($con,"SELECT MAX(value) FROM letra");
  $row = mysqli_fetch_row($q);
  $row1 = mysqli_fetch_row($qq);
  $num1=$row1[0]+1;
  $num1="0000".$num1;
  $num1=substr($num1,-5);
  $num = $row[0]+1;
  $num="00000".$num;
  $num=substr($num,-6);
  $data=array();
  $qq=mysqli_query($con,"SELECT cliente,direccion FROM cliente WHERE ruc='".$_POST['ruc']."' LIMIT 1");
  $rr=mysqli_fetch_row($qq);
  for ($i=0; $i<sizeof($_POST['monto']) ; $i++) {
  	$sql=mysqli_query($con,"INSERT INTO letraclientes (serie,ruc,cliente,direccion,fechagiro,fechapago,total,factura,value,pendiente,unico)
  	              VALUES ('".$num."',
  	              		  '".$_POST['ruc']."',
                        '".$rr[0]."',
                        '".$rr[1]."',
  	              		  NOW(),
  	              		  '".date('Y-m-d', strtotime(str_replace('/', '-', $_POST['fecha'][$i])))."',
  	              		  '".$_POST['monto'][$i]."',
  	              		  '".$_POST['factura'][$i]."',
                        '".$num1."',
                        'SI',
                        '')");
  	$num++;
  	$num="00000".$num;
  	$num=substr($num,-6);
  }
  ///////////////////////////////////////////////////////////////////////////////////////////////
  $sqll=mysqli_query($con,"INSERT INTO letra (cliente,value,fecha,total,pendiente,adelanto,credito)
                          VALUES ('".$rr[0]."',
                                '".$num1."',
                                NOW(),
                                '".$_POST['total']."',
                                '".$_POST['total']."',
                                '0.00',
                                'CREDITO')");
  ///////////////////////////////////////////////////////////////////////////////////////////////
  for ($i=0; $i<sizeof($_POST['serie']) ; $i++) {
    $s=mysqli_query($con,"UPDATE total_ventas SET credito='LETRA',igv='".$num1."' WHERE serieventas='".$_POST['serie'][$i]."' AND documento='NOTA DE PEDIDO'");
  }
