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
		    	$data[$i][8]=substr($s[1],-1,1);
		    	$i++;
		    }
		}
		else{
			$data='';
		}
	   function sortByOrder($a, $b) {
    $c = $a[7] - $b[7];
    $c .= strcmp($a[8],$b[8]);
    return $c;
}

usort($data, 'sortByOrder');
	    $date=array();
	    $date[0]=$data;
	    echo json_encode($date);
	}
?>
