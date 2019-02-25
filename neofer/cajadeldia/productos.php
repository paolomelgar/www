<?php 
	require_once('../connection.php');
	if(isset($_POST) && !empty($_POST)){
		$q=$_POST['serie'];
		$i=0;
		$j=0;
		if($_POST['doc']=='NOTA DE PEDIDO'){
			$sql1=mysqli_query($con,"SELECT * FROM notapedido WHERE serienota='$q' ORDER BY idnota");
			?> <table width="100%" cellpadding="0" cellspacing="0" border="1" align="center"><?php
			if (mysqli_num_rows($sql1)>0){
		    	?>
	            	<tr bgcolor="#428bca" style="color:white; text-align:center;font-size:11px">
	                    <th width="5%" style='border: 1px solid #428bca;'>CANT</th>
	                    <th width="75%" style='border: 1px solid #428bca;'>PRODUCTO</th>
	                    <th width="10%" style='border: 1px solid #428bca;'>P.UNIT</th>
	                    <th width="10%" style='border: 1px solid #428bca'>IMPOR</th>
	                </tr>
	            <?php
			    while($row=mysqli_fetch_assoc($sql1)){
			    	$i=$i+$row['importe'];
			    	?>
		            <tr class="tr" style='font-size:12px;'>
		                <td width="5%" align="right"><?php echo $row['cantidad']; ?></td>
		                <td width="75%" align="left"><?php echo $row['producto'] ?></td>
		                <td width="10%" align="right"><?php echo $row['unitario'] ?></td>
		                <td width="10%" align="right"><?php echo $row['importe']; ?></td>
		            </tr>
	          <?php
	          }
			}
			$sql2=mysqli_query($con,"SELECT * FROM devoluciones WHERE seriedevolucion='$q' ORDER BY iddevolucion");
			if (mysqli_num_rows($sql2)>0){
		    	?>
	            	<tr style="text-align:center;font-size:10px"><td colspan='4'> DEVOLUCIONES</td></tr>
	            <?php
			    while($row=mysqli_fetch_assoc($sql2)){
			    	$j=$j+$row['importe'];
			    	?>
		            <tr class="tr" style='font-size:12px;'>
		                <td width="5%" align="right"><?php echo $row['cantidad']; ?></td>
		                <td width="75%" align="left"><?php echo $row['producto'] ?></td>
		                <td width="10%" align="right"><?php echo $row['unitario'] ?></td>
		                <td width="10%" align="right"><?php echo $row['importe']; ?></td>
		            </tr>
	          <?php
	          }
			}
			?><tr style="font-size:12px"><td colspan='2'><td width="20%" align="right" colspan='2'><?php echo "S/. ".number_format($i-$j,2);?></td></tr></table><?php
		}
		elseif($_POST['doc']=='FACTURA'){
			$sql1=mysqli_query($con,"SELECT * FROM facturapaola WHERE seriefactura='$q' ORDER BY idfactura");
			?> <table width="100%" cellpadding="0" cellspacing="0" border="1" align="center"><?php
			if (mysqli_num_rows($sql1)>0){
		    	?>
	            	<tr bgcolor="#428bca" style="color:white; text-align:center;font-size:11px">
	                    <th width="5%">CANT</th>
	                    <th width="75%">PRODUCTO</th>
	                    <th width="10%">P.UNIT</th>
	                    <th width="10%">IMPOR</th>
	                </tr>
	            <?php
			    while($row=mysqli_fetch_assoc($sql1)){
			    	$i=$i+$row['importe'];
			    	?>
		            <tr class="tr" style='font-size:12px;'>
		                <td width="5%" align="right"><?php echo $row['cantidad']; ?></td>
		                <td width="75%" align="left"><?php echo $row['producto'] ?></td>
		                <td width="10%" align="right"><?php echo $row['unitario'] ?></td>
		                <td width="10%" align="right"><?php echo $row['importe']; ?></td>
		            </tr>
	          <?php
	          }
			}
			?><tr style="font-size:12px"><td colspan='2'><td width="20%" align="right" colspan='2'><?php echo "S/. ".number_format($i,2);?></td></tr></table><?php
		}elseif($_POST['doc']=='PROFORMA'){
			$sql1=mysqli_query($con,"SELECT * FROM proforma WHERE serieproforma='$q' ORDER BY idproforma");
			?> <table width="100%" cellpadding="0" cellspacing="0" border="1" align="center"><?php
			if (mysqli_num_rows($sql1)>0){
		    	?>
	            	<tr bgcolor="#428bca" style="color:white; text-align:center;font-size:11px">
	                    <th width="5%">CANT</th>
	                    <th width="75%">PRODUCTO</th>
	                    <th width="10%">P.UNIT</th>
	                    <th width="10%">IMPOR</th>
	                </tr>
	            <?php
			    while($row=mysqli_fetch_assoc($sql1)){
			    	$i=$i+$row['importe'];
			    	?>
		            <tr class="tr" style='font-size:12px;'>
		                <td width="5%" align="right"><?php echo $row['cantidad']; ?></td>
		                <td width="75%" align="left"><?php echo $row['producto'] ?></td>
		                <td width="10%" align="right"><?php echo $row['unitario'] ?></td>
		                <td width="10%" align="right"><?php echo $row['importe']; ?></td>
		            </tr>
	          <?php
	          }
			}
			?><tr style="font-size:12px"><td colspan='2'><td width="20%" align="right" colspan='2'><?php echo "S/. ".number_format($i,2);?></td></tr></table><?php
		}else{
			$sql1=mysqli_query($con,"SELECT * FROM boleta WHERE serieboleta='$q' ORDER BY idboleta");
			?> <table width="100%" cellpadding="0" cellspacing="0" border="1" align="center"><?php
			if (mysqli_num_rows($sql1)>0){
		    	?>
	            	<tr bgcolor="#428bca" style="color:white; text-align:center;font-size:11px">
	                    <th width="5%">CANT</th>
	                    <th width="75%">PRODUCTO</th>
	                    <th width="10%">P.UNIT</th>
	                    <th width="10%">IMPOR</th>
	                </tr>
	            <?php
			    while($row=mysqli_fetch_assoc($sql1)){
			    	$i=$i+$row['importe'];
			    	?>
		            <tr class="tr" style='font-size:12px;'>
		                <td width="5%" align="right"><?php echo $row['cantidad']; ?></td>
		                <td width="75%" align="left"><?php echo $row['producto'] ?></td>
		                <td width="10%" align="right"><?php echo $row['unitario'] ?></td>
		                <td width="10%" align="right"><?php echo $row['importe']; ?></td>
		            </tr>
	          <?php
	          }
			}
			?><tr style="font-size:12px"><td colspan='2'><td width="20%" align="right" colspan='2'><?php echo "S/. ".number_format($i,2);?></td></tr></table><?php
		}
	}