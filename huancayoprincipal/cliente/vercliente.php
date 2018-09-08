<?php 
require_once('../connection.php');
$query = "SELECT * FROM cliente WHERE cliente='".$_POST['a']."'";
echo mysqli_num_rows(mysqli_query($con,$query));
?>