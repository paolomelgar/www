<?php 
	require_once('../connection.php');
	if(isset($_POST) && !empty($_POST)){
		$q=$_POST['serie'];
		$n=0;
		$n1=0;
		$sql=mysqli_query($con,"SELECT * FROM notapedido WHERE serienota='$q' ORDER BY idnota");
		$sql2=mysqli_query($con,"SELECT * FROM devoluciones WHERE seriedevolucion='$q' ORDER BY iddevolucion");
	    ?> <table width="100%" style='border-collapse: collapse;'> <?php
		if (mysqli_num_rows($sql)>0){ ?>
            	<tr style="background-color:#428bca;color:white;font-weight:bold;">
                    <th width="5%" style='text-align:center;border:1px solid grey'>CANT</th>
                    <th width="75%" style='text-align:center;border:1px solid grey'>PRODUCTO</th>
                    <th width="10%" style='text-align:center;border:1px solid grey'>P.UNIT</th>
                    <th width="10%" style='text-align:center;border:1px solid grey'>IMPOR</th>
                </tr>
            <?php
		    while($row=mysqli_fetch_assoc($sql)){
		    	$n+=$row['importe']; ?>
	            <tr class="fila" style='font-size:12px;font-weight:bold;border:1px solid grey'>
	                <td style='text-align:right'><?php echo $row['cantidad']; ?></td>
	                <td style='border:1px solid grey'><?php echo $row['producto'] ?></td>
	                <td style='text-align:right;border:1px solid grey'><?php echo $row['unitario'] ?></td>
	                <td style='text-align:right;border:1px solid grey'><?php echo $row['importe']; ?></td>
	            </tr>
            <?php }
		} 
		if (mysqli_num_rows($sql2)>0){ ?>
            <tr style="background-color:#428bca;color:white;font-weight:bold;"><td colspan='4' style="text-align:center;font-size:11px;font-weight:bold"> DEVOLUCIONES</td></tr>
            <?php
		    while($row=mysqli_fetch_assoc($sql2)){
		    	$n1+=$row['importe'];
		    	?>
	            <tr class="tr" style='font-size:12px;font-weight:bold;border:1px solid grey'>
	                <td style='text-align:right'><?php echo $row['cantidad']; ?></td>
	                <td style='border:1px solid grey'><?php echo $row['producto'] ?></td>
	                <td style='text-align:right;border:1px solid grey'><?php echo $row['unitario'] ?></td>
	                <td style='text-align:right;border:1px solid grey'><?php echo $row['importe']; ?></td>
	            </tr>
          	<?php }
		}?>
	        <tr style='font-size:12px;font-weight:bold;'>
				<td style='text-align:right;border:1px solid grey' colspan='3'>S/</td>
				<td style='text-align:right;border:1px solid grey'><?php echo number_format(($n-$n1),2); ?></td>
			</tr>
		</table>
	    <?php
	}
?>