<?php 
require_once('../connection.php');
	if(isset($_POST) && !empty($_POST)){
		$q=$_POST['value'];
	    $sql=mysqli_query($con,"SELECT * FROM compras WHERE value='$q' ORDER BY id");
	    if (mysqli_num_rows($sql)>0){
	    	$i=0;
		    while($row=mysqli_fetch_assoc($sql)){
		    	$data[$i][0]=$row['producto'];
		    	$data[$i][1]=$row['cantidad'];
		    	$data[$i][2]=$row['unitario'];
		    	$data[$i][3]=$row['importe'];
		    	$data[$i][4]=$row['idproducto'];
		    	$i++;
		    }
		}
	    $sql1=mysqli_query($con,"SELECT * FROM total_compras WHERE value='$q'");
		$row1=mysqli_fetch_assoc($sql1);
	    	$dat[0]=$row1['ruc'];
	    	$dat[1]=$row1['proveedor'];
	    	$dat[2]=$row1['direccion'];
	    	$dat[3]=$row1['subtotal'];
	    	$dat[4]=$row1['igv'];
	    	$dat[5]=$row1['total'];
	    	$dat[6]=$row1['percepcion'];
	    	$dat[7]=$row1['montototal'];
	    	$dat[8]=$row1['documento'] ;
	    	$dat[9]=$row1['credito'];
	    	$dat[10]=$row1['serie'];
	    	$dat[11]=$row1['numero'];
	    	$dat[12]=date('d/m/Y', strtotime(str_replace('-', '/', $row1['fechapago'])));
	    	$dat[13]=date('d/m/Y', strtotime(str_replace('-', '/', $row1['fechafactura'])));
	    	$dat[14]=$row1['comentario'];
	    	$dat[15]=$row1['billete'];
	    	$dat[16]=$row1['cambio'];
	    	$dat[17]=$row1['entregado'];
	    $date=array();
	    $date[0]=$data;
	    $date[1]=$dat;
	    echo json_encode($date);
	}
?>
