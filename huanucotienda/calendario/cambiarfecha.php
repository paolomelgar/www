<?php 
    require_once('../connection.php');
            if(strlen($_POST['fecha'])==7){
            	$fecha=substr($_POST['fecha'],-4,4)."-".substr($_POST['fecha'],-6,2)."-0".substr($_POST['fecha'],-7,1);
            }else{
            	$fecha=substr($_POST['fecha'],-4,4)."-".substr($_POST['fecha'],-6,2)."-".substr($_POST['fecha'],-8,2);
            }
	$sql=mysqli_query($con,"UPDATE pagoletras SET fecha='$fecha' WHERE id='".$_POST['id']."'");
?>