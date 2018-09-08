<?php
  require_once('../connection.php');
  $sql1=mysqli_query($con,"UPDATE total_pedido SET entregado='ANULADO' WHERE seriepedido='".$_POST['del']."' ORDER BY nropedido");
?>