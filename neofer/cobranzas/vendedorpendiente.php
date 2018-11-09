<?php
require_once('../connection.php');
	$query = "SELECT DISTINCT(vendedor) FROM acuenta WHERE pendiente='SI'";
    $result=mysqli_query($con,$query);
    $data=array();
    $i=0;
    while($row=mysqli_fetch_assoc($result)){
    	$data[$i]=$row['vendedor'];
    	$i++;
    }
    echo json_encode($data);
?>