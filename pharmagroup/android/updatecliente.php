<?php 
require_once('../connection.php');
    $sql=mysqli_query($con,"INSERT INTO updatecliente (ruc,cliente,direccion,telefono,representante,idcliente) VALUES ('".$_REQUEST['ruc']."','".$_REQUEST['cliente']."','".$_REQUEST['direccion']."','".$_REQUEST['telefono']."','".$_REQUEST['representante']."','".$_REQUEST['id']."')");
  if(isset($_REQUEST['imagen']) && !empty($_REQUEST['imagen'])){
    $data = base64_decode($_REQUEST['imagen']);
    $image = imagecreatefromstring($data);
    header('Content-Type: image/jpeg');
    imagejpeg($image,'../fotos/nuevocliente/a'.$_REQUEST['id'].'.jpg');
    imagedestroy($image);
  }
?>