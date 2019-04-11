<?php 
	require_once('../connection.php');
		$q=$_POST['serie'];
  		$sql=mysqli_query($con,"SELECT * FROM letraclientes WHERE pendiente='SI' AND value='$q' ORDER BY fechapago");
  		$a=0;
  		$da=array();
  		while($row2=mysqli_fetch_assoc($sql)){
	    	$da[$a][0]=$row2['factura'];
	    	$da[$a][1]=$row2['total'];
	    	$da[$a][2]=$row2['unico'];
	    	$da[$a][3]=date('d/m/Y', strtotime(str_replace('-', '/', $row2['fechapago'])));
	    	$a++;
	    }
	echo json_encode($da);
?>