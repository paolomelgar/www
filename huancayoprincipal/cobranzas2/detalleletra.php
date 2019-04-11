<?php 
	require_once('../connection.php');
	if(isset($_POST) && !empty($_POST)){
		$q=$_POST['serie'];
		$i=0;
		$sql1=mysqli_query($con,"SELECT * FROM total_ventas WHERE igv='$q' AND documento='NOTA DE PEDIDO' ORDER BY idventas");
		?>
		<div id='acordion'>
			<?php while($row=mysqli_fetch_assoc($sql1)){ 
				$j=0;
				$p=0;
				$i+=$row['total'];
				$sq=mysqli_query($con,"SELECT * FROM notapedido WHERE serienota='".$row['serieventas']."' ORDER BY idnota");
				$sql2=mysqli_query($con,"SELECT * FROM devoluciones WHERE seriedevolucion='".$row['serieventas']."' ORDER BY iddevolucion");
			?>
			<h3 style='border:1px solid #428bca;'><table width="100%"><tr><td width='20%'><?php echo $row['vendedor']; ?></td><td width="15%"><?php echo $row['fecha']; ?></td><td width="50%"><?php echo $row['cliente']; ?></td><td width="15%"><?php echo $row['total']; ?></td></tr></table></h3>
			<div>
				<table width="100%" cellpadding="0" cellspacing="0" border="1" align="center">
					<tr bgcolor="#428bca" style="color:#FFF; text-align:center;font-size:12px">
	                    <th width="5%">CANT</th>
	                    <th width="75%">PRODUCTO</th>
	                    <th width="10%">P.UNIT</th>
	                    <th width="10%">IMPOR</th>
	                </tr>
		    	<?php while($ro=mysqli_fetch_assoc($sq)){ 
		    		$j+=$ro['importe']; ?>
		    		<tr class="tr" style='font-size:12px;'>
		                <td width="5%" align="right"><?php echo $ro['cantidad']; ?></td>
		                <td width="75%" align="left"><?php echo $ro['producto'] ?></td>
		                <td width="10%" align="right"><?php echo $ro['unitario'] ?></td>
		                <td width="10%" align="right"><?php echo $ro['importe']; ?></td>
		            </tr>
		    	<?php } 
		    	if (mysqli_num_rows($sql2)>0){ ?>
		        	<tr style="text-align:center;font-size:11px"><td colspan='4'> DEVOLUCIONES</td></tr>
		        <?php
			    while($row=mysqli_fetch_assoc($sql2)){
			    	$p=$p+$row['importe'];
			    	?>
		            <tr class="tr" style='font-size:12px;'>
		                <td width="5%" align="right"><?php echo $row['cantidad']; ?></td>
		                <td width="75%" align="left"><?php echo $row['producto'] ?></td>
		                <td width="10%" align="right"><?php echo $row['unitario'] ?></td>
		                <td width="10%" align="right"><?php echo $row['importe']; ?></td>
		            </tr>
		        <?php } } ?>
		        	<tr class="tr" style='font-size:12px;'>
		    			<td width="90%" align="right" colspan='3'>TOTAL: </td>
		    			<td width="10%" align="right"><?php echo number_format($j-$p,2); ?></td>
		    		</tr>
		    	</table>
		    </div>
			<?php } ?>
			<h3 style='border:1px solid #428bca;'><table width="100%"><tr><td width="85%" align='right'>TOTAL:</td><td width="15%"><?php echo number_format($i,2); ?></td></tr></table></h3>
		</div>
	<?php } ?>