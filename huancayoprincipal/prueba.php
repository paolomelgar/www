<?php 
require_once('connection.php');
    $sql=mysqli_query($con,"SELECT id FROM producto");
    while($row=mysqli_fetch_assoc($sql)){
    	$sq=mysqli_fetch_row(mysqli_query($con,"SELECT MAX(codigo)+1 FROM producto"));
    	$s=mysqli_query($con,"UPDATE producto SET codigo='".$sq[0]."' WHERE id='".$row['id']."'");
    }
?>