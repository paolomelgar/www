<?php
  require_once('../connection.php');
  $sql=mysqli_query($con,"UPDATE total_pedido SET imprimir='1' WHERE seriepedido='".$_POST['del']."'");
  $i=0;
  $sql2=mysqli_query($con,"SELECT * FROM pedido WHERE seriepedido='".$_POST['del']."'");
    while($row=mysqli_fetch_assoc($sql2)){
    	$s=mysqli_fetch_row(mysqli_query($con,"SELECT ubicacion FROM producto WHERE id='".$row['id']."'"));
    	$data[$i][0]=$row['producto'];
    	$data[$i][1]=$row['cantidad'];
    	$data[$i][2]=$row['unitario'];
    	$data[$i][3]=$s[0];
    	$i++;
    }
  $sql1=mysqli_query($con,"SELECT * FROM total_pedido WHERE seriepedido='".$_POST['del']."'");
		$row1=mysqli_fetch_assoc($sql1);
	    	$dat[0]=$row1['ruc'];
	    	$dat[1]=$row1['cliente'];
	    	$dat[2]=$row1['direccion'];
	    	$dat[3]=$row1['subtotal'];
	    	$dat[4]=$row1['devolucion'];
	    	$dat[5]=$row1['total'];
	    	$dat[6]=$row1['vendedor'];
	    	$dat[7]=$row1['comentario'];
	    	$dat[8]=$row1['credito'];
	    	$dat[9]=$row1['fecha'];
	    $date=array();
	    $date[0]=$data;
	    $date[1]=$dat;
	    echo json_encode($date);
 ?>