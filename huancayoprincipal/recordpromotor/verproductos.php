<?php 
	require_once('../connection.php');
	if(isset($_POST) && !empty($_POST)){
		$n=0;$n1=0;
		$sql1=mysqli_query($con,"SELECT * FROM notapedido WHERE serienota='".$_POST['serie']."' ORDER BY idnota");
		if (mysqli_num_rows($sql1)>0){
	    	?>
	    	<div style='overflow:auto;height:95%;align:center'>
	    	<table width="100%" border="0" style="border-collapse: collapse;">
            	<tr bgcolor="black" style="color:white; text-align:center;font-size:11px">
                    <th width="5%" style='border: 1px solid black;'>CANT</th>
                    <th width="75%" style='border: 1px solid black;'>PRODUCTO</th>
                    <th width="10%" style='border: 1px solid black;'>P.UNIT</th>
                    <th width="10%" style='border: 1px solid black'>IMPOR</th>
                </tr>
            <?php
		    while($row=mysqli_fetch_assoc($sql1)){
		    	$n+=$row['importe'];
		    	?>
	            <tr class="tr" style='font-size:12px;font-weight:bold'>
	                <td width="5%" align="right" style='border: 1px solid black;'><?php echo $row['cantidad']; ?></td>
	                <td width="75%" align="left" style='border: 1px solid black;'><?php echo $row['producto'] ?></td>
	                <td width="10%" align="right" style='border: 1px solid black;'><?php echo $row['unitario'] ?></td>
	                <td width="10%" align="right" style='border: 1px solid black;'><?php echo $row['importe']; ?></td>
	            </tr>
          <?php
          }
		}
		$sql2=mysqli_query($con,"SELECT * FROM devoluciones WHERE seriedevolucion='".$_POST['serie']."' ORDER BY iddevolucion");
		if (mysqli_num_rows($sql2)>0){
	    	?>
            	<tr style="text-align:center;font-size:11px;font-weight:bold"><td> DEVOLUCIONES</td></tr>
            <?php
		    while($row=mysqli_fetch_assoc($sql2)){
		    	$n1+=$row['importe'];
		    	?>
	            <tr class="tr" style='font-size:12px;font-weight:bold'>
	                <td width="5%" align="right" style='border: 1px solid black;'><?php echo $row['cantidad']; ?></td>
	                <td width="75%" align="left" style='border: 1px solid black;'><?php echo $row['producto'] ?></td>
	                <td width="10%" align="right" style='border: 1px solid black;'><?php echo $row['unitario'] ?></td>
	                <td width="10%" align="right" style='border: 1px solid black;'><?php echo $row['importe']; ?></td>
	            </tr>
          <?php
          }
		}
		?> 
				<tr style='font-size:12px;font-weight:bold'>
					<td width='90%' align='right' style='border: 1px solid black;' colspan='3'>S/.</td>
					<td width='10%' align="right" style='border: 1px solid black;'><?php echo number_format(($n-$n1),2); ?></td>
				</tr>
			</table>
			</div>
		<?php
	}
?>