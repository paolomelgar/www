<?php 
  require_once('../connection.php');
  $search = explode(" ", $_REQUEST['cliente']);
  $producto = "";
  if($_REQUEST['tipo']=="ruc"){
    $producto .= "ruc LIKE '%".$_REQUEST['cliente']."%'";
  }else{
    foreach($search AS $s){
      $producto .= "cliente LIKE '%".mysqli_real_escape_string($con,$s)."%' AND ";
    }
    $producto = substr($producto, 0, -4);
  }
  $query = "SELECT ruc,cliente,direccion,telefono,representante,credito,id_cliente,mail,latitud,longitud FROM cliente WHERE $producto AND tipo='FERRETERIA' AND activo!='ANULADO' ORDER BY cliente LIMIT 10";
  $sql=mysqli_query($con,$query);
  $datos=array();
  $i=0;
  while ($row=mysqli_fetch_assoc($sql)) {
    $sql1=mysqli_query($con,"SELECT SUM(pendiente) FROM total_ventas WHERE cliente='".$row["cliente"]."' AND credito='CREDITO' AND entregado='SI'");
    $row1 = mysqli_fetch_row($sql1);
    if(mysqli_num_rows($sql1)>0){
      $datos[$i]["ruc"]=$row["ruc"];
      $datos[$i]["cliente"]=$row["cliente"];
      $datos[$i]["direccion"]=$row["direccion"];
      $datos[$i]["telefono"]=$row["telefono"];
      $datos[$i]["representante"]=$row["representante"];
      $datos[$i]["credito"]=$row["credito"];
      $datos[$i]["id_cliente"]=$row["id_cliente"];
      $datos[$i]["pendiente"]=number_format($row["credito"]-$row1[0],2,".","");
      $datos[$i]["mail"]=$row["mail"];
      $datos[$i]["latitud"]=$row["latitud"];
      $datos[$i]["longitud"]=$row["longitud"];
    }else{
      $datos[$i]["ruc"]=$row["ruc"];
      $datos[$i]["cliente"]=$row["cliente"];
      $datos[$i]["direccion"]=$row["direccion"];
      $datos[$i]["telefono"]=$row["telefono"];
      $datos[$i]["representante"]=$row["representante"];
      $datos[$i]["credito"]=$row["credito"];
      $datos[$i]["id_cliente"]=$row["id_cliente"];
      $datos[$i]["pendiente"]=$row["credito"];
      $datos[$i]["mail"]=$row["mail"];
      $datos[$i]["latitud"]=$row["latitud"];
      $datos[$i]["longitud"]=$row["longitud"];
    }
    $i++;
  }
  echo json_encode($datos);
?>