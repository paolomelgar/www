<?php 
	require_once('../connection.php');
	    $sql1=mysqli_query($con,"SELECT * FROM producto WHERE fran<=stock_real AND fran>0 ORDER BY producto,marca");
	    $dat=array();
	    $i=0;
		while($row1=mysqli_fetch_assoc($sql1)){
	    	$dat[$i][0]=$row1['fran'];
	    	$dat[$i][1]=$row1['producto']." ".$row1['marca'];
	    	$i++;
	    }
	    echo json_encode($dat);
?>
