<?php 
require_once('../connection.php');
$query = "SELECT * FROM notapedido WHERE serienota='".$_REQUEST['serie']."'";
$sql=mysqli_query($con,$query);
$datos=array();
$i=0;
while ($row=mysqli_fetch_assoc($sql)) {
    $datos[$i]["cantidad"]=$row["cantidad"];
    $datos[$i]["producto"]=$row["producto"];
    $datos[$i]["unitario"]=$row["unitario"];
    $datos[$i]["importe"]=$row["importe"];
    $datos[$i]["id"]=$row["id"];
    $datos[$i]["estado"]="normal";
    $i++;
}
$query1 = "SELECT * FROM devoluciones WHERE seriedevolucion='".$_REQUEST['serie']."'";
$sql1=mysqli_query($con,$query1);
while ($row1=mysqli_fetch_assoc($sql1)) {
    $datos[$i]["cantidad"]=$row1["cantidad"];
    $datos[$i]["producto"]=$row1["producto"];
    $datos[$i]["unitario"]=$row1["unitario"];
    $datos[$i]["importe"]=$row1["importe"];
    $datos[$i]["id"]=$row1["id"];
    $datos[$i]["estado"]="devolucion";
    $i++;
}
echo json_encode($datos);
?>