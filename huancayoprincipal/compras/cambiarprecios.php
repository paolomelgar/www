<?php 
require_once('../connection.php');
if(isset($_POST) && !empty($_POST)){
  switch ($_POST['pos']) {
    case '3':
    $sql=mysqli_query($con,"UPDATE producto SET p_franquicia='".$_POST['val']."' WHERE id='".$_POST['id']."'");
    break;
    case '4':
    $sql=mysqli_query($con,"UPDATE producto SET p_promotor='".$_POST['val']."' WHERE id='".$_POST['id']."'");
    break;
    case '5':
    $sql=mysqli_query($con,"UPDATE producto SET p_mayor='".$_POST['val']."' WHERE id='".$_POST['id']."'");
    break;
    case '6':
    $sql=mysqli_query($con,"UPDATE producto SET p_1='".$_POST['val']."' WHERE id='".$_POST['id']."'");
    break;
    case '7':
    $sql=mysqli_query($con,"UPDATE producto SET p_2='".$_POST['val']."' WHERE id='".$_POST['id']."'");
    break;
    case '8':
    $sql=mysqli_query($con,"UPDATE producto SET p_3='".$_POST['val']."' WHERE id='".$_POST['id']."'");
    break;
    case '9':
    $sql=mysqli_query($con,"UPDATE producto SET p_4='".$_POST['val']."' WHERE id='".$_POST['id']."'");
    break;
    case '10':
    $sql=mysqli_query($con,"UPDATE producto SET p_5='".$_POST['val']."' WHERE id='".$_POST['id']."'");
    break;
  }
}