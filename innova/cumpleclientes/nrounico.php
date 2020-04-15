<?php 
    require_once('../connection.php');
    $sql=mysqli_query($con,"UPDATE pagoletras SET unico='".$_POST['num']."' WHERE id='".$_POST['id']."'");
?>