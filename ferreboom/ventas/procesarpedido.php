<?php 
require_once('../connection.php');
    $hoy=date("Y-m-d");
    if ($_POST['serie']==0) {
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
        }else{
            $num=1;
        }
    }else{
        $del = mysqli_query($con,"DELETE FROM pedido WHERE seriepedido='".$_POST['serie']."'");
        $del1 = mysqli_query($con,"DELETE FROM devolucion WHERE seriepedido='".$_POST['serie']."'");
        $del2 = mysqli_query($con,"DELETE FROM total_pedido WHERE seriepedido='".$_POST['serie']."'");
        $num1=$_POST['serie'];
        $num=$_POST['nro'];
    }
    if($_POST['str'][1]['value'] !='' AND $_POST['str'][2]['value']!=''){
        $cons=mysqli_query($con,"SELECT * FROM cliente WHERE ruc='".$_POST['str'][1]['value']."' AND cliente='".$_POST['str'][2]['value']."'");
        if(mysqli_num_rows($cons)==0){
            $cliente= mysqli_query($con,"INSERT INTO cliente (ruc,cliente,direccion,tipo,activo) 
                VALUES ('".$_POST['str'][1]['value']."',
                        '".$_POST['str'][2]['value']."',
                        '".$_POST['str'][3]['value']."',
                        'UNIDAD',
                        'SI')");
        }
    }
      
    if(isset($_POST['producto']) && !empty($_POST['producto'])){
        for ($i=0; $i<sizeof($_POST['producto']) ; $i++) {
            $sql= mysqli_query($con,"INSERT INTO pedido (seriepedido,id,compra,producto,cantidad,unitario,importe,especial,ruc,cliente,direccion,fecha,hora,nropedido,vendedor) 
                VALUES ('".$num1."',
                        '".$_POST['id'][$i]."',
                        '".$_POST['compra'][$i]."',
                        '".$_POST['producto'][$i]."',
                		'".$_POST['cantidad'][$i]."',
                		'".$_POST['unitario'][$i]."',
                        '".$_POST['importe'][$i]."',
                		'".$_POST['promotor'][$i]."',
                		'".$_POST['str'][1]['value']."',
                		'".$_POST['str'][2]['value']."',
                		'".$_POST['str'][3]['value']."',
                        NOW(),
                		NOW(),
                		'".$num."',
                		'".$_POST['str'][0]['value']."'
                		)");
        }
    }
    $query= mysqli_query($con,"INSERT INTO total_pedido (nropedido,fecha,hora,seriepedido,ruc,cliente,direccion,entregado,subtotal,devolucion,total,vendedor,comentario,credito) 
                VALUES ('".$num."',
                        NOW(),
                        NOW(),
                        '".$num1."',
                        '".$_POST['str'][1]['value']."',
                        '".$_POST['str'][2]['value']."',
                        '".$_POST['str'][3]['value']."',
                        'NO',
                        '".$_POST['str'][4]['value']."',
                        '".$_POST['str'][5]['value']."',
                        '".$_POST['str'][6]['value']."',
                        '".$_POST['str'][0]['value']."',
                        '".$_POST['str'][7]['value']."',
                        '".$_POST['credito'] ."'
                        )");
    if(isset($_POST['producto1']) && !empty($_POST['producto1'])){
        for ($i=0; $i<sizeof($_POST['producto1']) ; $i++) {
            $sql1= mysqli_query($con,"INSERT INTO devolucion (seriepedido,id,compra,producto,cantidad,unitario,importe,ruc,cliente,direccion,fecha,hora,nropedido,vendedor,estado) 
                VALUES ('".$num1."',
                        '".$_POST['id1'][$i]."',
                        '".$_POST['compra1'][$i]."',
                        '".$_POST['producto1'][$i]."',
                        '".$_POST['cantidad1'][$i]."',
                        '".$_POST['unitario1'][$i]."',
                        '".$_POST['importe1'][$i]."',
                        '".$_POST['str'][1]['value']."',
                        '".$_POST['str'][6]['value']."',
                        '".$_POST['str'][9]['value']."',
                        NOW(),
                        NOW(),
                        '".$num."',
                        '".$_POST['str'][0]['value']."',
                        '".$_POST['estado1'][$i]."'
                        )");
        }
    }
    echo $num;
?>
