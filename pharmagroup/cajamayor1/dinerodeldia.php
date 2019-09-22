<?php
  require_once('../connection.php');
    if(isset($_POST) && !empty($_POST)){
      $fecha=date("Y-m-d");
      $res=mysqli_query($con,"SELECT fecha FROM cajamayor WHERE id=(SELECT max(id) FROM cajamayor)");
      $row = mysqli_fetch_row($res);
      if($fecha!=$row[0]){
        $ins=mysqli_query($con,"INSERT INTO cajamayor (cajatienda,creditos,ingresos,contados,proveedor,egresos,totaldia,total,fecha) VALUES ('0','0','0','0','0','0','0','0','$fecha')");
      }
      $resul=mysqli_query($con,"SELECT * FROM cajamayor WHERE fecha='".date('Y-m-d', strtotime(str_replace('/', '-', $_POST['fecha'])))."'");
      $row1 = mysqli_fetch_row($resul);
      $ar=array();
    	$ar[0]=$row1[1];
    	$ar[1]=$row1[2];
    	$ar[2]=$row1[3];
      $ar[3]=$row1[4];
      $ar[4]=$row1[5];
      $ar[5]=$row1[6];
      $ar[6]=$row1[7];
    	$ar[7]=$row1[8];
    	echo json_encode($ar);
    }
?>