<?php 
require_once('../connection.php');
  $search = explode(" ", $_REQUEST['producto']);
  $producto = "";
  foreach($search AS $s){
    $producto .= "concat(producto,marca) LIKE '%".mysqli_real_escape_string($con,$s)."%' AND ";
  }
  $producto = substr($producto, 0, -4);
  $n=0;
  if(isset($_REQUEST['familia']) && !empty($_REQUEST['familia'])){
    if($_REQUEST['familia']!="Todas las Categorias"){
    $producto .=" AND familia='".$_REQUEST['familia']."'";}
  }
  if(isset($_REQUEST['page'])){
    $n = $_REQUEST['page']*12;
  }
  if($_REQUEST['cargo']=='ADMIN'){
    $query = "SELECT producto,marca,p_promotor,p_compra,stock_real,id,p_mayor,cant_caja,activo,codigo,antiguedad FROM producto WHERE ($producto AND activo!='NO' AND activo!='UNIDAD' AND activo!='ANULADO') OR codigo='".$_REQUEST['producto']."' ORDER BY producto LIMIT 12";
  }else if($_REQUEST['cargo']=='CLIENTE'){
    $query = "SELECT producto,marca,p_promotor,p_5,stock_real,id,p_mayor,cant_caja,activo,codigo,antiguedad FROM producto WHERE ($producto AND activo!='NO' AND activo!='UNIDAD' AND activo!='ANULADO' AND foto!='NO') OR codigo='".$_REQUEST['producto']."' ORDER BY producto LIMIT $n,12";
  }else if($_REQUEST['cargo']=='CLIENTE PROVINCIA'){
    $query = "SELECT producto,marca,p_promotor,p_5,stock_real,id,p_mayor,cant_caja,activo,codigo,antiguedad FROM producto WHERE ($producto AND activo!='NO' AND activo!='UNIDAD' AND activo!='ANULADO' AND foto!='NO') OR codigo='".$_REQUEST['producto']."' ORDER BY producto LIMIT $n,12";
  }else{
    $query = "SELECT producto,marca,p_promotor,p_5,stock_real,id,p_mayor,cant_caja,activo,codigo,antiguedad FROM producto WHERE ($producto AND activo!='NO' AND activo!='UNIDAD' AND activo!='ANULADO') OR codigo='".$_REQUEST['producto']."' ORDER BY producto LIMIT 12";
  }
  $sql=mysqli_query($con,$query);
  $datos=array();
  $i=0;
  while ($row=mysqli_fetch_assoc($sql)) {
    $sql1=mysqli_query($con,"SELECT id,foto FROM marca WHERE marca='".$row["marca"]."'");
    $row1 = mysqli_fetch_row($sql1);
    $datos[$i]["producto"]=$row["producto"];
    if($row1[1]=='SI' && $_REQUEST['cargo']=='CLIENTE'){$datos[$i]["marca"]=$row1[0];}
    else{$datos[$i]["marca"]=$row["marca"];}
    if($_REQUEST['cargo']=='VENDEDOR'){
      $datos[$i]["p_promotor"]=$row["p_promotor"];
      $datos[$i]["p_especial"]=$row["p_promotor"];
    }else if($_REQUEST['cargo']=='VENDEDOR PROVINCIA'){
      $datos[$i]["p_promotor"]=$row["p_mayor"];
      $datos[$i]["p_especial"]=$row["p_mayor"];
    }else if($_REQUEST['cargo']=='ADMIN'){
      $datos[$i]["p_promotor"]=$row["p_promotor"];
      $datos[$i]["p_especial"]=$row["p_compra"];
    }else{
      $datos[$i]["p_promotor"]=$row["p_promotor"];
      $datos[$i]["p_especial"]=$row["p_promotor"];
    }
    $datos[$i]["stock_real"]=$row["stock_real"];
    $datos[$i]["id"]=$row["id"];
    $datos[$i]["cant_caja"]=$row["cant_caja"];
    $datos[$i]["activo"]=$row["activo"];
    $datos[$i]["codigo"]=$row["codigo"];
    $datos[$i]["antiguedad"]=$row["antiguedad"];
    $i++;
     //$datos[]=$row;
  }
  echo json_encode($datos);

 ?>