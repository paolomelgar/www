<?php 
require_once('../connection.php');
    date_default_timezone_set("America/Lima");
    $hoy=date("Y-m-d");
    $res = mysqli_query($con,"SELECT MAX(seriepedido) FROM total_pedido"); 
    $row = mysqli_fetch_row($res);
    $num = $row[0]+1;
    $num = "000000".$num;
    $num = substr($num,-7);
    $res1 = mysqli_query($con,"SELECT ruc,direccion,credito FROM cliente WHERE cliente='".$_POST['cliente']."'"); 
    $row5=mysqli_fetch_assoc($res1);
    if(isset($_POST['producto']) && !empty($_POST['producto'])){
        for ($i=0; $i<sizeof($_POST['producto']) ; $i++) {
            $query=mysqli_query($con,"SELECT p_promotor,p_compra FROM producto WHERE id='".$_POST['id'][$i]."'");
            $row=mysqli_fetch_row($query);
            $sql= mysqli_query($con,"INSERT INTO pedido (seriepedido,id,compra,producto,cantidad,unitario,importe,especial,ruc,cliente,direccion,fecha,hora,nropedido,vendedor) 
                VALUES ('".$num."',
                        '".$_POST['id'][$i]."',
                        '".$row[1]."',
                        '".$_POST['producto'][$i]."',
                        '".$_POST['cantidad'][$i]."',
                        '".$_POST['unitario'][$i]."',
                        '".$_POST['importe'][$i]."',
                        '".$row[0]."',
                        '".$row5['ruc']."',
                        '".$_POST['cliente']."',
                        '".$row5['direccion']."',
                        NOW(),
                        NOW(),
                        '',
                        'VENTAS ONLINE'
                        )");
        }
    }
    $query= mysqli_query($con,"INSERT INTO total_pedido (nropedido,fecha,hora,seriepedido,ruc,cliente,direccion,entregado,subtotal,devolucion,total,vendedor,comentario,credito) 
                VALUES ('',
                        NOW(),
                        NOW(),
                        '".$num."',
                        '".$row5['ruc']."',
                        '".$_POST['cliente']."',
                        '".$row5['direccion']."',
                        'NO',
                        '".substr($_POST['total'],3)."',
                        '0.00',
                        '".substr($_POST['total'],3)."',
                        'VENTAS ONLINE',
                        '".$_POST['comentario']."',
                        '".$row5['credito']."'
                        )");
?>
