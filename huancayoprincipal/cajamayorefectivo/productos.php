<?php 
	require_once('../connection.php');
	if(isset($_POST) && !empty($_POST)){
		$sql1=mysqli_query($con,"SELECT * FROM compras WHERE value='".$_POST['value']."' ORDER BY id");
		?><table width="100%" cellpadding="0" cellspacing="0" border="1" align="center">
        	<tr bgcolor="black" style="color:white;text-align:center;font-size:12px">
                <th width="5%">CANT</th>
                <th width="70%">PRODUCTO</th>
                <th width="10%">P.UNIT</th>
                <th width="15%">IMPOR</th>
            </tr>
            <?php
		    while($row=mysqli_fetch_assoc($sql1)){
		    	?>
	            <tr style='font-size:12px;'>
	                <td width="5%" align="right"><?php echo $row['cantidad']; ?></td>
	                <td width="70%" align="left"><?php echo $row['producto'] ?></td>
	                <td width="10%" align="right"><?php echo $row['unitario'] ?></td>
	                <?php if($row['billete']=='SOLES'){ ?>
	                <td width="15%" align="right"><?php echo "S/. ".$row['importe']; ?></td>
	                <?php }else{ ?>
	                <td width="15%" align="right"><?php echo "$. ".$row['importe']; ?></td>
	                <?php } ?>
	            </tr>
            <?php
            }
        ?></table><?php
	}