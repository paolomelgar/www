<?php 
require_once('../connection.php');
$q=mysqli_query($con,"SELECT latitud,longitud FROM cliente WHERE cliente='".$_POST['b']."'");
$row=mysqli_fetch_row($q);
$a=array();
$a[0]=$row[0];
$a[1]=$row[1];
echo json_encode($a);
?>