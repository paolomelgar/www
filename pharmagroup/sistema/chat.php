<?php
  $con =  mysqli_connect('localhost','root','','paolo');
  mysqli_query ($con,"SET NAMES 'utf8'");
  $m=$_POST['i']*30;
  $sql=mysqli_query($con,"SELECT * FROM chat WHERE (emisor='".$_POST['emisor']."' AND receptor='".$_POST['receptor']."') OR (emisor='".$_POST['receptor']."' AND receptor='".$_POST['emisor']."') ORDER BY id DESC LIMIT ".$m.",30");
  $i=0;
  $dat=array();
  while($row=mysqli_fetch_assoc($sql)){
    $dat[$i][0]=$row['emisor'];
    $dat[$i][1]=$row['receptor'];
    $dat[$i][2]=$row['mensaje'];
    $dat[$i][3]=$row['fecha'];
    $dat[$i][4]=$row['hora'];
    $dat[$i][5]=$row['visto'];
    $i++;
  }
  echo json_encode($dat);
?>