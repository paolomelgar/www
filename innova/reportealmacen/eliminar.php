<?php
  require_once('../connection.php');
  if(isset($_POST) && !empty($_POST)){
    $ins=mysqli_query($con,"UPDATE producto SET stock_almacen=(stock_almacen-".$_POST['cant'].") WHERE CONCAT(producto,' ',marca)='".$_POST['prod']."'");    
    $p=mysqli_query($con,"UPDATE reportealmacen SET estado='ANULADO' WHERE iddevolucion='".$_POST['id']."'");
  }
?>