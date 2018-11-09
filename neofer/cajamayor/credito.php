<?php
  require_once('../connection.php');
  if(isset($_POST) && !empty($_POST)){
    $fecha = date('Y-m-d', strtotime(str_replace('/', '-', $_POST['fecha'])));
    $sql=mysqli_query($con,"SELECT * FROM adelantos WHERE fecha='$fecha' AND sesion='ADMIN'");
    $i=0;
    $dat=array();
    while($row=mysqli_fetch_assoc($sql)){
      $dat[$i][0]=$row['serie'];
      $dat[$i][1]=$row['encargado'];
      $dat[$i][2]=$row['cliente'];
      $dat[$i][3]=$row['adelanto'];
      $i++;
    }
    echo json_encode($dat);
  }
?>