<?php
    require_once('../connection.php');
    $sql=mysqli_query($con,"SELECT * FROM total_pedido WHERE entregado='NO'");
    $count=mysqli_num_rows($sql);
	echo $count;
?>