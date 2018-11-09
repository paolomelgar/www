<?php 
require_once('../connection.php');
	if(isset($_POST) && !empty($_POST)){
		$q=$_POST['ver'];
	    $sql=mysqli_query($con,"SELECT * FROM pedido WHERE seriepedido='".$q."' ORDER BY id_pedido");
	    if (mysqli_num_rows($sql)>0){
	    	$i=0;
		    while($row=mysqli_fetch_assoc($sql)){
		    	$data[$i][0]=$row['producto'];
		    	$data[$i][1]=$row['cantidad'];
		    	$data[$i][2]=$row['unitario'];
		    	$data[$i][3]=$row['importe'];
		    	$data[$i][4]=$row['id'];
		    	$data[$i][5]=$row['compra'];
		    	$data[$i][6]=$row['especial'];
		    	$i++;
		    }
		}
		else{
			$data='';
		}
	    $sql2=mysqli_query($con,"SELECT * FROM devolucion WHERE seriepedido='".$q."' ORDER BY id_devolucion");
		if (mysqli_num_rows($sql2)>0){
		    $a=0;
		    while($row2=mysqli_fetch_assoc($sql2)){
		    	$da[$a][0]=$row2['producto'];
		    	$da[$a][1]=$row2['cantidad'];
		    	$da[$a][2]=$row2['unitario'];
		    	$da[$a][3]=$row2['importe'];
		    	$da[$a][4]=$row2['id'];
		    	$da[$a][5]=$row2['compra'];
		    	$da[$a][6]=$row2['estado'];
		    	$a++;
		    }
		}
		else{
			$da='';
		}
	    $sql1=mysqli_query($con,"SELECT * FROM total_pedido WHERE seriepedido='".$q."'");
		$row1=mysqli_fetch_assoc($sql1);
	    	$dat[0]=$row1['ruc'];
	    	$dat[1]=$row1['cliente'];
	    	$dat[2]=$row1['direccion'];
	    	$dat[3]=$row1['subtotal'];
	    	$dat[4]=$row1['devolucion'];
	    	$dat[5]=$row1['total'];
	    	$dat[6]=$row1['vendedor'];
	    	$dat[7]=$row1['comentario'];
	    	$dat[8]=$row1['seriepedido'];
	    	$dat[9]=$row1['nropedido'];
	    	
	    $date=array();
	    $date[0]=$data;
	    $date[1]=$dat;
	    $date[2]=$da;
	    echo json_encode($date);
	}
?>
