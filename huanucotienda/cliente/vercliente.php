<?php 
require_once('../connection.php');
$query = "SELECT * FROM cliente WHERE cliente='".$_POST['a']."'";
$a=mysqli_num_rows(mysqli_query($con,$query)
if($_POST['b']=='edit'){
	$a--;
}
echo $a;
?>