<?php
require_once('../connection.php');
date_default_timezone_set("America/Lima");
$ini = date('Y-m-d', strtotime(str_replace('/', '-', $_POST['fechaini'])));
$fin = date('Y-m-d', strtotime(str_replace('/', '-', $_POST['fechafin'])));
$query="";
if($_POST['estado']=='CANCELADO'){
  $query.="('$ini' <= fecha AND fecha <= '$fin') AND credito='CANCELADO'";
}
else{
  $query.="credito='CREDITO'";
}
if(isset($_POST['cliente']) && !empty($_POST['cliente'])){
  $query.=" AND cliente='".$_POST['cliente']."'";
}
$sql=mysqli_query($con,"SELECT * FROM total_ventas WHERE $query AND entregado='SI' ORDER BY fecha");
$i=0;
$dat=array();
while($row=mysqli_fetch_assoc($sql)){
  $dif=intval((strtotime(date("Y-m-d"))-strtotime($row['fecha']))/60/60/24);
  $dat[$i][0]=$row['vendedor'];
  $dat[$i][1]=$row['serieventas'];
  $dat[$i][2]=$row['cliente'];
  $dat[$i][3]=$row['total'];
  $dat[$i][4]=$row['pendiente'];
  $dat[$i][5]=$row['acuenta'];
  $dat[$i][6]=$row['fecha'];
  $dat[$i][7]="0";
  $dat[$i][8]=$dif;
  $i++;
}
echo json_encode($dat);
?>