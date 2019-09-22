<?php 
require_once('../connection.php');
	if(isset($_POST) && !empty($_POST)){
		$q=$_POST['value'];
		$sql1=mysqli_query($con,"SELECT * FROM compras WHERE value='$q' ORDER BY id");
		$n=0;
		if (mysqli_num_rows($sql1)>0){
	    	?>
	    	<table width="100%" class='table table-bordered table-condensed'>
            	<tr style="background-color:#428bca;color:white;font-weight:bold">
                    <th width="5%" style='text-align:center'>CAN</th>
                    <th width="75%" style='text-align:center'>PRODUCTO</th>
                    <th width="10%" style='text-align:center'>P.UNIT</th>
                    <th width="10%" style='text-align:center'>IMPOR</th>
                </tr>
            <?php
		    while($row=mysqli_fetch_assoc($sql1)){
		    	$n+=$row['importe'];
		    	?>
	            <tr class="fila" style='font-size:12px;font-weight:bold'>
	                <td width="5%" style='text-align:right'><?php echo $row['cantidad']; ?></td>
	                <td width="75%"><?php echo $row['producto'] ?></td>
	                <td width="10%" style='text-align:right'><?php echo $row['unitario'] ?></td>
	                <td width="10%" style='text-align:right'><?php echo $row['importe']; ?></td>
	            </tr>
          <?php
            }
		?> 
				<tr style='font-size:12px;background-color:white;font-weight:bold'>
					<td width='90%' colspan='3'></td>
					<td width='10%' style='text-align:right'><?php echo number_format($n,2); ?></td>
				</tr>
			</table>
		<?php
		}
	}
?>