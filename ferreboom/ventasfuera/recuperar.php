<?php 
session_start();
require_once('../connection.php');
if(isset($_POST) && !empty($_POST)){
	$data = json_decode($_POST['data']);
	$dat=array();
  	for ($i=0; $i < sizeof($data); $i++) { 
  		$query = mysqli_query($con,"SELECT producto,marca,p_promotor,p_compra FROM producto WHERE id='".$data[$i]."'"); 
		$row = mysqli_fetch_row($query);
		$dat[$i][0]=$row[0]." ".$row[1];
		if($_SESSION['nombre']!='GRUPO FERRETERO INNOVA S.R.L.'){
			$dat[$i][1]=$row[2];
		}else{
			$dat[$i][1]=round($row[3]*1.05,2);
		}
  	}
	echo json_encode($dat);
}
?>