<?php 
	require_once('../connection.php');
	if(isset($_POST) && !empty($_POST)){
		$q=$_POST['ver'];
	    $sql=mysqli_query($con,"SELECT * FROM pedido WHERE seriepedido='".$q."' ORDER BY id_pedido");
	    if (mysqli_num_rows($sql)>0){
	    	$i=0;
		    while($row=mysqli_fetch_assoc($sql)){
		    	$s=mysqli_fetch_row(mysqli_query($con,"SELECT stock_real,porcentaje,codigo,cant_caja FROM producto WHERE id='".$row['id']."'"));
		    	$data[$i][0]=$row['producto'];
		    	$data[$i][1]=$row['cantidad'];
		    	$data[$i][2]=$s[2];
		    	$data[$i][3]=$s[0];
		    	$data[$i][4]=$s[1];
		    	$data[$i][5]=$row['cliente'];
		    	$data[$i][6]=$s[3];
		    	$data[$i][7]=substr($s[1],0,-2);
		    	$i++;
		    }
		}
		else{
			$data='';
		}
	    
	    $date=array();
	    $date[0]=$data;
	    echo json_encode($date);
	}
?>
