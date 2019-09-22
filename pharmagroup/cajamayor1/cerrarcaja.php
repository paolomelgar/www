<?php
  require_once('../connection.php');
  $hoy=date("Y-m-d");
  $inser=mysqli_query($con,"UPDATE dinerodiario SET total='".$_POST['total']."',cajareal='".$_POST['real']."',diferencia='".$_POST['diferencia']."' WHERE fecha='$hoy'");
?>