<?php 
session_start();
require_once('../connection.php');
if(isset($_POST) && !empty($_POST)){
	$data = json_decode($_POST['data']);
	$dat=array();
  	for ($i=0; $i < sizeof($data); $i++) { 
  		$query = mysqli_query($con,"SELECT producto,marca,p_promotor FROM producto WHERE id='".$data[$i]."'"); 
		$row = mysqli_fetch_row($query);
		$dat[$i][0]=$row[0]." ".$row[1];
		$dat[$i][1]=$row[2];;
  	}
	echo json_encode($dat);
}
?>