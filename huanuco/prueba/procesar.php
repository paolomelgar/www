<?php 
	require_once('../connection.php');
	if(isset($_POST) && !empty($_POST)){
		$q=$_POST['ver'];
	    $sql=mysqli_query($con,"SELECT * FROM pedido WHERE seriepedido='".$q."' ORDER BY id_pedido");
	    if (mysqli_num_rows($sql)>0){
	    	$i=0;
		    while($row=mysqli_fetch_assoc($sql)){
		    	$s=mysqli_fetch_row(mysqli_query($con,"SELECT stock_real,porcentaje,codigo FROM producto WHERE id='".$row['id']."'"));
		    	$data[$i][0]=$row['producto'];
		    	$data[$i][1]=$row['cantidad'];
		    	$data[$i][2]=$s[2];
		    	$data[$i][3]=$s[0];
		    	$data[$i][4]=$s[1];
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
