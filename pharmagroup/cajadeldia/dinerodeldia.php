<?php
  require_once('../connection.php');
    if(isset($_POST) && !empty($_POST)){
      $resul=mysqli_query($con,"SELECT * FROM dinerodiario WHERE fecha='".date('Y-m-d', strtotime(str_replace('/', '-', $_POST['fecha'])))."'");
      $row1 = mysqli_fetch_row($resul);
      $ar=array();
    	$ar[0]=$row1[1]+$row1[2]+$row1[3];
    	$ar[1]=$row1[5];
    	$ar[2]=$row1[6];
      $ar[3]=$row1[7];
      $ar[4]=$row1[9];
    	$ar[5]=$row1[10];
    	echo json_encode($ar);
    }
?>