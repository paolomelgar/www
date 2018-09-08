<?php 
require_once('../connection.php');
date_default_timezone_set("America/Lima");
    $hoy=date("Y-m-d");
    $res = mysqli_query($con,"SELECT MAX(seriepedido) FROM total_pedido"); 
    $row = mysqli_fetch_row($res);
    $num1 = $row[0]+1;
    $num1 = "000000".$num1;
    $num1 = substr($num1,-7);
    $query = mysqli_query($con,"SELECT * FROM total_pedido WHERE seriepedido='".$row[0]."'");
    $row1=mysqli_fetch_assoc($query);
    $fecha = $row1['fecha'];
    $num=$row1['nropedido'];
    if($hoy==$fecha){
        $num = $num+1;
    }
    else{
        $num=1;
    }
    $res1="";
    if($_REQUEST['vendedor']=='VENTAS ANDROID'){
        $res1 = mysqli_query($con,"SELECT ruc,cliente,direccion,credito FROM cliente WHERE cliente='".$_REQUEST['cliente']."'"); 
    }else{
        $res1 = mysqli_query($con,"SELECT ruc,cliente,direccion,credito FROM cliente WHERE id_cliente='".$_REQUEST['cliente']."'"); 
    }
    $row5=mysqli_fetch_assoc($res1);
    $query= mysqli_query($con,"INSERT INTO total_pedido (nropedido,fecha,hora,seriepedido,ruc,cliente,direccion,entregado,subtotal,devolucion,total,vendedor,comentario,credito) 
                VALUES ('".$num."',
                        NOW(),
                        NOW(),
                        '".$num1."',
                        '".$row5['ruc']."',
                        '".$row5['cliente']."',
                        '".$row5['direccion']."',
                        'NO',
                        '".$_REQUEST['total']."',
                        '0.00',
                        '".$_REQUEST['total']."',
                        '".$_REQUEST['vendedor']."',
                        '".$_REQUEST['observacion']."',
                        '".$row5['credito']."'
                        )");
    for ($i=$_REQUEST['size']-1; $i>=0 ; $i--) {
        $resss = mysqli_query($con,"SELECT producto,marca,p_compra,p_promotor FROM producto WHERE id='".$_REQUEST['id'.$i]."'"); 
        $roww=mysqli_fetch_assoc($resss);
        $sql= mysqli_query($con,"INSERT INTO pedido (seriepedido,id,compra,producto,cantidad,unitario,importe,especial,ruc,cliente,direccion,fecha,hora,nropedido,vendedor) 
                VALUES ('".$num1."',
                        '".$_REQUEST['id'.$i]."',
                        '".$roww['p_compra']."',
                        '".$roww['producto']." ".$roww['marca']."',
                        '".$_REQUEST['stock'.$i]."',
                        '".$_REQUEST['unit'.$i]."',
                        '".($_REQUEST['stock'.$i]*$_REQUEST['unit'.$i])."',
                        '".$roww['p_promotor']."',
                        '".$row5['ruc']."',
                        '".$row5['cliente']."',
                        '".$row5['direccion']."',
                        NOW(),
                        NOW(),
                        '".$num."',
                        '".$_REQUEST['vendedor']."'
                        )");
    }

 ?>