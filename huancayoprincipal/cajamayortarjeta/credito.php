<?php
  require_once('../connection.php');
  if(isset($_POST) && !empty($_POST)){
    $fecha = date('Y-m-d', strtotime(str_replace('/', '-', $_POST['fecha'])));
    $sql=mysqli_query($con,"SELECT * FROM adelantos WHERE fecha='$fecha' AND forma='DEPOSITO' AND sesion!='CAJERO'");
    $sql2=mysqli_query($con,"SELECT * FROM cobroletras WHERE fechapago='$fecha'");
    $i=0;
    $dat=array();
    while($row=mysqli_fetch_assoc($sql)){
      $dat[$i][0]=$row['serie'];
      $dat[$i][1]=$row['encargado'];
      $dat[$i][2]=$row['cliente'];
      $dat[$i][3]=$row['adelanto'];
      $dat[$i][4]=$row['banco'];
      $dat[$i][5]=$row['nro'];
      $dat[$i][6]=$row['fechapagooo'];
      $dat[$i][7]=$row['forma'];
      $i++;
    }
    while($row=mysqli_fetch_assoc($sql2)){
      $dat[$i][0]="S/N";
      $dat[$i][1]="COBRO LETRAS";
      $dat[$i][2]=$row['cliente'];
      $dat[$i][3]=$row['adelanto'];
      $dat[$i][4]="BCP";
      $dat[$i][5]=$row['monto'];
      $dat[$i][6]=$row['fechapago'];
      $dat[$i][7]="DEPOSITO";
      $i++;
    }
    echo json_encode($dat);
  }
?>