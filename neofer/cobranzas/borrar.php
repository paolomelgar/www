<?php 
  require_once('../connection.php');
    $sql1=mysqli_query($con,"DELETE FROM acuenta WHERE id='".$_POST['id']."'");
?>