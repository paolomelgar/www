<?php
  require_once('../connection.php');
  if(isset($_POST) && !empty($_POST)){
    $fecha = date('Y-m-d', strtotime(str_replace('/', '-', $_POST['fecha'])));
    $sql=mysqli_query($con,"SELECT * FROM adelantoscompras WHERE mediopago='EFECTIVO' AND fecha='$fecha' ORDER BY fecha");
    $sql1=mysqli_query($con,"SELECT * FROM adelantosletra WHERE mediopago='EFECTIVO' AND fechapago='$fecha' ORDER BY fechapago");
    $i=0;
    $dat=array();
    while($row=mysqli_fetch_assoc($sql)){
      $dat[$i][0]=$row['forma'];
      $dat[$i][1]=$row['banco'];
      $dat[$i][2]=$row['nro'];
      $dat[$i][3]=$row['proveedor'];
      $dat[$i][4]=$row['adelanto'];
      $dat[$i][5]=$row['cambio'];
      $dat[$i][6]=$row['encargadocompra'];
      $dat[$i][7]=$row['fechapago'];
      $dat[$i][8]=$row['mediopago'];
      $i++;
    }
    while($row=mysqli_fetch_assoc($sql1)){
      $dat[$i][0]="LETRA";
      $dat[$i][1]="N° UNICO";
      $dat[$i][2]=$row['unico'];
      $dat[$i][3]=$row['proveedor'];
      $dat[$i][4]=$row['adelanto'];
      $dat[$i][5]=$row['cambio'];
      $dat[$i][6]=$row['encargadocompra'];
      $dat[$i][7]=$row['fechapagoletra'];
      $dat[$i][8]=$row['mediopago'];
      $i++;
    }
    echo json_encode($dat);
  }
?>