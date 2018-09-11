<?php 
require_once('connection.php');
    $sql=mysqli_query($con,"SELECT id FROM producto");
    while($row=mysqli_fetch_assoc($sql)){
    	$sq=mysqli_fetch_row(mysqli_query($con,"SELECT fecha FROM compras WHERE idproducto='".$row['id']."' AND entregado='SI' ORDER BY fecha DESC LIMIT 1"));
    	$s=mysqli_query($con,"UPDATE producto SET antiguedad='".$sq[0]."' WHERE id='".$row['id']."'");
    }
 ?>