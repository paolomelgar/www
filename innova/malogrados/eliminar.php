<?php
  require_once('../connection.php');
  if(isset($_POST) && !empty($_POST)){
    $ins=mysqli_query($con,"UPDATE producto SET stock_real=(stock_real+".$_POST['cant'].") WHERE CONCAT(producto,' ',marca)='".$_POST['prod']."'");
    $ins=mysqli_query($con,"DELETE FROM devoluciones WHERE iddevolucion='".$_POST['id']."'");
  }
?>