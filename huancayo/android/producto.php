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
    $query = "SELECT producto,marca,p_promotor,p_compra,stock_real,id,cant_caja,activo FROM producto WHERE $producto AND activo!='NO' ORDER BY producto LIMIT 12";
  }else if($_REQUEST['cargo']=='CLIENTE'){
    $query = "SELECT producto,marca,p_promotor,p_especial,stock_real,id,cant_caja,activo FROM producto WHERE $producto AND activo!='NO' AND foto='SI' ORDER BY producto LIMIT $n,12";
  }else{
    $query = "SELECT producto,marca,p_promotor,p_especial,stock_real,id,cant_caja,activo FROM producto WHERE $producto AND activo!='NO' ORDER BY producto LIMIT 12";
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
    $datos[$i]["p_promotor"]=$row["p_promotor"];
    if($_REQUEST['cargo']=='ADMIN'){
      $datos[$i]["p_especial"]=$row["p_compra"];
    }else{
      $datos[$i]["p_especial"]=$row["p_especial"];
    }
    $datos[$i]["stock_real"]=$row["stock_real"];
    $datos[$i]["id"]=$row["id"];
    $datos[$i]["cant_caja"]=$row["cant_caja"];
    $datos[$i]["activo"]=$row["activo"];
    $i++;
  }
  echo json_encode($datos);

 ?>