<?php 
require_once('../connection.php');
  $data = base64_decode($_REQUEST['imagen']);
  $sql=mysqli_query($con,"INSERT INTO cliente (ruc,cliente,direccion,telefono,representante,tipo,activo,foto,credito,latitud,longitud) VALUES ('".$_REQUEST['ruc']."','".$_REQUEST['cliente']."','".$_REQUEST['direccion']."','".$_REQUEST['telefono']."','".$_REQUEST['representante']."','FERRETERIA','SI','SI','0','".$_REQUEST['latitud']."','".$_REQUEST['longitud']."')");
  $res = mysqli_query($con,"SELECT MAX(id_cliente) AS id_cliente FROM cliente");
   $datos=array();
   while ($row=mysqli_fetch_assoc($res)) {
      $datos[0]["id_cliente"]=$row["id_cliente"];
      $image = imagecreatefromstring($data);
	  header('Content-Type: image/jpeg');
	  imagejpeg($image,'../fotos/cliente/a'.$row['id_cliente'].'.jpg');
	  imagedestroy($image);
   }
   echo json_encode($datos);
?>