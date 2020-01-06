<?php 
set_time_limit(1200);
require_once('../connection.php');
$ini = date('Y-m-d', strtotime(str_replace('/', '-', $_POST['inicio'])));
$fin = date('Y-m-d', strtotime(str_replace('/', '-', $_POST['final'])));
$output="<table border='1'><tr style='font-weight:bold;background-color:#428bca;color:white'><td>PRODUCTO</td><td>MARCA</td><td>X/CAJA</td><td>STOCK MIN</td><td>STOCK REAL</td><td>PEDIDO SUGERIDO</td><td>PEDIDO FINAL</td><td>REQUERIMIENTO</td><td>P. COMPRA</td><td>TOTAL</td><td>PROVEEDOR</td><td>P. UNIDAD</td><td>P. MAYOR</td><td>P. ESPECIAL</td><td>UBICACION 1</td><td>UBICACION 2</td><td>CODIGO</td></tr>";

if($_POST['proveedorsistema']!=''){
$sql=mysqli_query($con,"SELECT * FROM producto WHERE activo='SI' AND proveedor='".$_POST['proveedorsistema']."'");
}else{
$sql=mysqli_query($con,"SELECT * FROM producto WHERE activo='SI'");
}

if($_SESSION['mysql']=="prolongacionhuanuco" || $_SESSION['mysql']=="innovaprincipal" || $_SESSION['mysql']=="jauja" || $_SESSION['mysql']=="dorispovez" ){
while($row=mysqli_fetch_assoc($sql)){
    $query="id='".$row['id']."' AND entregado='SI' AND ('$ini' <= fecha AND fecha <= '$fin')";
    $sql1=mysqli_query($con,"SELECT SUM(cantidad),sum(compra),sum(importe) FROM
                                (
                                    (SELECT SUM(cantidad) AS cantidad, SUM(cantidad*compra) AS compra, SUM(importe) AS importe FROM notapedido WHERE $query)
                                    UNION ALL
                                    (SELECT SUM(cantidad) AS cantidad, SUM(cantidad*compra) AS compra, SUM(importe) AS importe FROM proforma WHERE $query)
                                    UNION ALL
                                    (SELECT SUM(cantidad) AS cantidad, SUM(cantidad*compra) AS compra, SUM(importe) AS importe FROM boletaelectronica WHERE $query)
                                    UNION ALL
                                    (SELECT -SUM(cantidad) AS cantidad, -SUM(cantidad*compra) AS compra, -SUM(importe) AS importe FROM devoluciones WHERE $query)
                                )as tb");
    $r1=mysqli_fetch_row($sql1);
    if($r1[1]>0){
        // $x=($r1[2]-$r1[1])*100/$r1[1];
        $output.="<tr><td>".$row['producto']."</td><td>".$row['marca']."</td><td>".$row['cant_caja']."</td><td>".$r1[0]."</td><td>".$row['stock_real']."</td><td> </td><td> </td><td> </td><td>".$row['p_compra']."</td><td> </td><td>".$row['proveedor']."</td><td>".$row['p_unidad']."</td><td>".$row['p_promotor']."</td><td>".$row['p_especial']."</td><td>".$row['ubicacion']."</td><td>".$row['ubicacion2']."</td><td>".$row['codigo']."</td></tr>";
    }else{
        $output.="<tr><td>".$row['producto']."</td><td>".$row['marca']."</td><td>".$row['cant_caja']."</td><td>0</td><td>".$row['stock_real']."</td><td> </td><td> </td><td> </td><td>".$row['p_compra']."</td><td> </td><td>".$row['proveedor']."</td><td>".$row['p_unidad']."</td><td>".$row['p_promotor']."</td><td>".$row['p_especial']."</td><td>".$row['ubicacion']."</td><td>".$row['ubicacion2']."</td><td>".$row['codigo']."</td></tr>";
    }
}
}
else{
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
        // $x=($r1[2]-$r1[1])*100/$r1[1];
        $output.="<tr><td>".$row['producto']."</td><td>".$row['marca']."</td><td>".$row['cant_caja']."</td><td>".$r1[0]."</td><td>".$row['stock_real']."</td><td> </td><td> </td><td> </td><td>".$row['p_compra']."</td><td> </td><td>".$row['proveedor']."</td><td>".$row['p_unidad']."</td><td>".$row['p_promotor']."</td><td>".$row['p_especial']."</td><td>".$row['ubicacion']."</td><td>".$row['ubicacion2']."</td><td>".$row['codigo']."</td></tr>";
    }else{
        $output.="<tr><td>".$row['producto']."</td><td>".$row['marca']."</td><td>".$row['cant_caja']."</td><td>0</td><td>".$row['stock_real']."</td><td> </td><td> </td><td> </td><td>".$row['p_compra']."</td><td> </td><td>".$row['proveedor']."</td><td>".$row['p_unidad']."</td><td>".$row['p_promotor']."</td><td>".$row['p_especial']."</td><td>".$row['ubicacion']."</td><td>".$row['ubicacion2']."</td><td>".$row['codigo']."</td></tr>";
    }
}
}
$output.="</table>";
echo $output;
 ?>