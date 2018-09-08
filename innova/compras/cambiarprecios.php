<?php 
require_once('../connection.php');
if(isset($_POST) && !empty($_POST)){
  switch ($_POST['pos']) {
    case '3':
    $sql=mysqli_query($con,"UPDATE producto SET p_unidad='".$_POST['val']."' WHERE id='".$_POST['id']."'");
    break;
    case '4':
    $sql=mysqli_query($con,"UPDATE producto SET p_promotor='".$_POST['val']."' WHERE id='".$_POST['id']."'");
    break;
    case '5':
    $sql=mysqli_query($con,"UPDATE producto SET p_especial='".$_POST['val']."' WHERE id='".$_POST['id']."'");
    break;
  }
}