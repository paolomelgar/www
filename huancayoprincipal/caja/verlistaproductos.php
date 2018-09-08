<?php 
	require_once('../connection.php');
	if(isset($_POST) && !empty($_POST)){
		$q=$_POST['serie'];
		$r=$_POST['com'];
		$n=0;
		$n1=0;
		switch ($r) {
			case 'BOLETA DE VENTA':
	    		$sql=mysqli_query($con,"SELECT * FROM boleta WHERE serieboleta='$q' ORDER BY idboleta");
			break;
			case 'FACTURA PAUL':
	    		$sql=mysqli_query($con,"SELECT * FROM facturapaul WHERE seriefactura='$q' ORDER BY idfactura");
			break;
			case 'FACTURA BOOM':
	    		$sql=mysqli_query($con,"SELECT * FROM facturaboom WHERE seriefactura='$q' ORDER BY idfactura");
			break;
			case 'PROFORMA':
	    		$sql=mysqli_query($con,"SELECT * FROM proforma WHERE serieproforma='$q' ORDER BY idproforma");
			break;
			case 'NOTA DE PEDIDO':
	    		$sql=mysqli_query($con,"SELECT * FROM notapedido WHERE serienota='$q' ORDER BY idnota");
	    		$sql2=mysqli_query($con,"SELECT * FROM devoluciones WHERE seriedevolucion='$q' ORDER BY iddevolucion");
			break;
			case 'GUIA DE REMISION':
	    		$sql=mysqli_query($con,"SELECT * FROM guiaderemision WHERE serieguia='$q' ORDER BY idguia");
			break;
			case 'COTIZACION':
	    		$sql=mysqli_query($con,"SELECT * FROM cotizacion WHERE seriecotizacion='$q' ORDER BY idcotizacion");
			break;
		}
		if (mysqli_num_rows($sql)>0){ ?>
	    	<table width="100%" class='table table-condensed table-bordered'>
            	<tr style="background-color:#428bca;color:white;font-weight:bold;">
                    <th width="5%" style='text-align:center'>CANT</th>
                    <th width="75%" style='text-align:center'>PRODUCTO</th>
                    <th width="10%" style='text-align:center'>P.UNIT</th>
                    <th width="10%" style='text-align:center'>IMPOR</th>
                </tr>
            <?php
		    while($row=mysqli_fetch_assoc($sql)){
		    	$n+=$row['importe']; ?>
	            <tr class="fila" style='font-size:12px;font-weight:bold'>
	                <td style='text-align:right'><?php echo $row['cantidad']; ?></td>
	                <td><?php echo $row['producto'] ?></td>
	                <td style='text-align:right'><?php echo $row['unitario'] ?></td>
	                <td style='text-align:right'><?php echo $row['importe']; ?></td>
	            </tr>
            <?php }
		} 
		if ($_POST['com']=='NOTA DE PEDIDO' && mysqli_num_rows($sql2)>0){ ?>
            <tr><td colspan='4' style="text-align:center;font-size:11px;font-weight:bold"> DEVOLUCIONES</td></tr>
            <?php
		    while($row=mysqli_fetch_assoc($sql2)){
		    	$n1+=$row['importe'];
		    	?>
	            <tr class="tr" style='font-size:12px;font-weight:bold'>
	                <td style='text-align:right'><?php echo $row['cantidad']; ?></td>
	                <td><?php echo $row['producto'] ?></td>
	                <td style='text-align:right'><?php echo $row['unitario'] ?></td>
	                <td style='text-align:right'><?php echo $row['importe']; ?></td>
	            </tr>
          	<?php }
		}?>
	        <tr style='font-size:12px;font-weight:bold'>
				<td style='text-align:right' colspan='3'>S/</td>
				<td style='text-align:right'><?php echo number_format(($n-$n1),2); ?></td>
			</tr>
		</table>
	    <?php
	}
?>