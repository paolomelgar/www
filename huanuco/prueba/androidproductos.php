<?php 
	require_once('../connection.php');
		$q=$_REQUEST['id'];
	    $sql=mysqli_query($con,"SELECT * FROM pedido WHERE seriepedido='".$q."' ORDER BY id_pedido");
		$data=array();
		$i=0;
		while ($row=mysqli_fetch_assoc($sql)) {
		    $s=mysqli_fetch_row(mysqli_query($con,"SELECT stock_real,porcentaje,codigo,cant_caja FROM producto WHERE id='".$row['id']."'"));
		    $data[$i]["producto"]=$row['producto'];
	    	$data[$i]["cantidad"]=$row['cantidad'];
	    	$data[$i]["codigo"]=$s[2];
	    	$data[$i]["stock"]=$s[0];
	    	$data[$i]["ubicacion"]=$s[1];
	    	$data[$i]["cliente"]=$row['cliente'];
	    	$data[$i]["caja"]=$s[3];
	    	$data[$i]["a"]=substr($s[1],0,-2);
	    	$data[$i]["b"]=substr($s[1],-1,1);
		    $i++;
		}
		function sortByOrder($a, $b) {
		    $c = $a["a"] - $b["a"];
		    $c .= strcmp($a["b"],$b["b"]);
		    return $c;
		}

		usort($data, 'sortByOrder');
		$sql1=mysqli_query($con,"UPDATE pedido SET entregado='pendiente' WHERE seriepedido='".$q."'");
		echo json_encode($data);
?>