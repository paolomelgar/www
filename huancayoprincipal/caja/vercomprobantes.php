<?php 
	require_once('../connection.php');
	if(isset($_POST) && !empty($_POST)){
		$q=$_POST['serie'];
		$r=$_POST['com'];
		switch ($r) {
			case 'BOLETA DE VENTA':
	    		$sql=mysqli_query($con,"SELECT * FROM boleta WHERE serieboleta='$q' ORDER BY idboleta");
	    		$da='';
			break;
			case 'FACTURA PAUL':
	    		$sql=mysqli_query($con,"SELECT * FROM facturapaul WHERE seriefactura='$q' ORDER BY idfactura");
	    		$da='';
			break;
			case 'FACTURA BOOM':
	    		$sql=mysqli_query($con,"SELECT * FROM facturaboom WHERE seriefactura='$q' ORDER BY idfactura");
	    		$da='';
			break;
			case 'FACTURA ELECTRONICA PAUL':
	    		$sql=mysqli_query($con,"SELECT * FROM facturaelectronicapaul WHERE seriefactura='$q' ORDER BY idfactura");
	    		$da='';
			break;
			case 'FACTURA ELECTRONICA BOOM':
	    		$sql=mysqli_query($con,"SELECT * FROM facturaelectronicaboom WHERE seriefactura='$q' ORDER BY idfactura");
	    		$da='';
			break;
			case 'NOTA DE PEDIDO':
	    		$sql=mysqli_query($con,"SELECT * FROM notapedido WHERE serienota='$q' ORDER BY idnota");
	    		$sql2=mysqli_query($con,"SELECT * FROM devoluciones WHERE seriedevolucion='$q' ORDER BY iddevolucion");
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
			break;
			case 'COTIZACION':
	    		$sql=mysqli_query($con,"SELECT * FROM cotizacion WHERE seriecotizacion='$q' ORDER BY idcotizacion");
	    		$da='';
			break;
			case 'GUIA DE REMISION':
	    		$sql=mysqli_query($con,"SELECT * FROM guiaderemision WHERE serieguia='$q' ORDER BY idguia");
	    		$da='';
			break;
		}
	    if (mysqli_num_rows($sql)>0){
	    	$i=0;
		    while($row=mysqli_fetch_assoc($sql)){
		    	$s=mysqli_fetch_row(mysqli_query($con,"SELECT stock_real,ubicacion FROM producto WHERE id='".$row['id']."'"));
		    	$data[$i][0]=$row['producto'];
		    	$data[$i][1]=$row['cantidad'];
		    	$data[$i][2]=$row['unitario'];
		    	$data[$i][3]=$row['importe'];
		    	$data[$i][4]=$row['id'];
		    	$data[$i][5]=$row['compra'];
		    	$data[$i][6]=$row['especial'];
		    	$data[$i][7]=$s[0];
		    	$data[$i][8]=$s[1];
		    	$i++;
		    }
		}
		else{
			$data='';
		}
	    
	    $sql1=mysqli_query($con,"SELECT * FROM total_ventas WHERE serieventas='$q' AND documento='$r'");
		$row1=mysqli_fetch_assoc($sql1);
		$sql2=mysqli_query($con,"SELECT credito FROM cliente WHERE cliente='".$row1['cliente']."' AND ruc='".$row1['ruc']."'");
		$row3=mysqli_fetch_row($sql2);
	    	$dat[0]=$row1['ruc'];
	    	$dat[1]=$row1['cliente'];
	    	$dat[2]=$row1['direccion'];
	    	$dat[3]=$row1['subtotal'];
	    	$dat[4]=$row1['devolucion'];
	    	$dat[5]=$row1['total'];
	    	$dat[6]=$row1['vendedor'];
	    	$dat[7]=$row1['comentario'];
	    	$dat[8]=$row1['documento'];
	    	$dat[9]=$row1['credito'];
	    	$dat[10]=$row1['acuenta'];
	    	$dat[11]=date('d/m/Y', strtotime(str_replace('-', '/', $row1['fechapago'])));
	    	$dat[12]=date('d/m/Y', strtotime(str_replace('-', '/', $row1['fecha'])));
	    	$dat[13]=$row1['serieventas'];
	    	$dat[14]=$row1['entregado'];
	    	$dat[15]=$row1['igv'];
	    	$dat[16]=$row3[0];
	    $date=array();
	    $date[0]=$data;
	    $date[1]=$dat;
	    $date[2]=$da;
	    echo json_encode($date);
	}
?>
