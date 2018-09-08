<?php
  $con =  mysqli_connect('localhost','root','','prueba');
  mysqli_query ($con,"SET NAMES 'utf8'");
    $sql=mysqli_query($con,"SELECT * FROM producto WHERE id='".$_POST['id']."'");
    $i=0;
    $dat=array();
    while($row=mysqli_fetch_assoc($sql)){
      $q = mysqli_query($con,"SELECT id FROM marca WHERE marca='".$row['marca']."'");
      $d = mysqli_fetch_row($q);
      $dat[0]=$row['producto'];
      $dat[1]=$d[0];
      $dat[2]=$row['categoria'];
      $dat[3]=$row['grupo'];
      $dat[4]=$row['c1'];
      $dat[5]=$row['p1'];
      $dat[6]=$row['c2'];
      $dat[7]=$row['p2'];
      $dat[8]=$row['c3'];
      $dat[9]=$row['p3'];
      $dat[10]=$row['caja'];
      $dat[11]=$row['cajamaster'];
      $i++;
    }
    echo json_encode($dat);
?>