<?php
session_start();
require_once('../connection.php');
date_default_timezone_set("America/Lima");
$ini = date('Y-m-d', strtotime(str_replace('/', '-', $_POST['fechaini'])));
$fin = date('Y-m-d', strtotime(str_replace('/', '-', $_POST['fechafin'])));
$query="";
if($_POST['estado']=='CANCELADO'){
  $query.="('$ini' <= fechafactura AND fechafactura <= '$fin') AND credito='CANCELADO'";
}
else{
  $query.="credito='CREDITO'";
}
if(isset($_POST['proveedor']) && !empty($_POST['proveedor'])){
  $query.=" AND proveedor='".$_POST['proveedor']."'";
}
$sql=mysqli_query($con,"SELECT * FROM total_compras WHERE $query AND entregado='SI' ORDER BY fechafactura");
$i=0;
$dat=array();
while($row=mysqli_fetch_assoc($sql)){
  $sqll=mysqli_query($con,"SELECT fecha FROM pagoletras WHERE value='".$row['value']."' AND pendiente='SI' ORDER BY fecha LIMIT 1");
  $f=mysqli_fetch_row($sqll);
  if(mysqli_num_rows($sqll)>0){$fechapago=$f[0];}
  else{$fechapago=$row['fechapago'];}
  $interval=strtotime($fechapago)-strtotime(date("Y-m-d"));
  $diferencia=intval($interval/60/60/24);
  $dif=intval((strtotime(date("Y-m-d"))-strtotime($row['fechafactura']))/60/60/24);
  if($row['documento']=='FACTURA'){
    $dat[$i][0]="FACTURA ".$row['serie']."-".$row['numero'];
  }else{
    $dat[$i][0]=$row['serie']."-".$row['numero'];
  }
  $dat[$i][1]=$row['proveedor'];
  $dat[$i][2]=$row['montototal'];
  $dat[$i][3]=$row['pendiente'];
  $dat[$i][4]=$row['acuenta'];
  $dat[$i][5]=$row['fechafactura'];
  $dat[$i][6]=$fechapago;
  $dat[$i][7]=$diferencia;
  if($row['letra']=='SI'){
    $dat[$i][8]="LETRA";
  }else{
    $dat[$i][8]="DETALLES";
  }
  $dat[$i][9]=$row['value'];
  $dat[$i][10]=$row['billete'];
  $i++;
}
echo json_encode($dat);
?>