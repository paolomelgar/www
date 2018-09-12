<?php 
	require_once('../connection.php');
	if(isset($_POST) && !empty($_POST)){
		$q=$_POST['value'];
		$i=0;
		$sql1=mysqli_query($con,"SELECT * FROM compras WHERE value='$q' ORDER BY id");
		?><table width="100%" cellpadding="0" cellspacing="0" border="1" align="center"><?php
		if (mysqli_num_rows($sql1)>0){
	    	?>
            	<tr bgcolor="#428bca" style="color:#FFF; text-align:center;font-size:12px">
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
		?><tr style="font-size:12px"><td colspan='3'><td width="10%" align="right"><?php echo number_format($i,2);?></td></tr></table><?php
	}