<?php 
set_time_limit(600);
require_once('../connection.php');
$ini = date('Y-m-d', strtotime(str_replace('/', '-', $_POST['inicio'])));
$fin = date('Y-m-d', strtotime(str_replace('/', '-', $_POST['final'])));
$output="<table border='1'><tr style='font-weight:bold;background-color:#428bca;color:white'><td>PRODUCTO</td><td>MARCA</td><td>CATEGORIA</td><td>CANTIDAD</td><td>P. COMPRA</td><td>P. VENTA</td><td>GANANCIA</td><td>PORCENTAJE</td></tr>";
$sql=mysqli_query($con,"SELECT * FROM producto WHERE activo='SI'");
while($row=mysqli_fetch_assoc($sql)){
    $query="id='".$row['id']."' AND entregado='SI' AND ('$ini' <= fecha AND fecha <= '$fin')";
    $sql1=mysqli_query($con,"SELECT SUM(cantidad),sum(compra),sum(importe) FROM
								(
								    (SELECT SUM(cantidad) AS cantidad, SUM(cantidad*compra) AS compra, SUM(importe) AS importe FROM notapedido WHERE $query)
								    UNION ALL
								    (SELECT SUM(cantidad) AS cantidad, SUM(cantidad*compra) AS compra, SUM(importe) AS importe FROM proforma WHERE $query)
								    UNION ALL
								    (SELECT SUM(cantidad) AS cantidad, SUM(cantidad*compra) AS compra, SUM(importe) AS importe FROM boleta WHERE $query)
								    UNION ALL
								    (SELECT -SUM(cantidad) AS cantidad, -SUM(cantidad*compra) AS compra, -SUM(importe) AS importe FROM devoluciones WHERE $query)
								)as tb");
    $r1=mysqli_fetch_row($sql1);
    if($r1[1]>0){
    	$x=($r1[2]-$r1[1])*100/$r1[1];
    	$output.="<tr><td>".$row['producto']."</td><td>".$row['marca']."</td><td>".$row['familia']."</td><td>".$r1[0]."</td><td>".$r1[1]."</td><td>".$r1[2]."</td><td>".($r1[2]-$r1[1])."</td><td>".$x."%</td></tr>";
    }else{
    	$output.="<tr><td>".$row['producto']."</td><td>".$row['marca']."</td><td>".$row['familia']."</td><td>0</td><td>0</td><td>0</td><td>0</td><td>0%</td></tr>";
    }
}
$output.="</table>";
echo $output;
 ?>