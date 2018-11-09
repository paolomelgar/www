<?php
session_start();
    require_once('../connection.php');
    date_default_timezone_set("America/Lima");
    $hoy=date("Y-m-d");
    $hoy1=$hoy;
    if($_POST['str'][6]['value'] !='' AND $_POST['str'][7]['value']!=''){
        $cons=mysqli_query($con,"SELECT * FROM cliente WHERE ruc='".$_POST['str'][6]['value']."' AND cliente='".$_POST['str'][7]['value']."'");
        if(mysqli_num_rows($cons)==0){
            $cliente= mysqli_query($con,"INSERT INTO cliente (ruc,cliente,direccion,tipo,activo) 
                VALUES ('".$_POST['str'][6]['value']."',
                        '".$_POST['str'][7]['value']."',
                        '".$_POST['str'][8]['value']."',
                        'UNIDAD',
                        'SI')");
        }
    }
    if($_POST['seriepedido']!=0){
        $consulta=mysqli_query($con,"UPDATE total_pedido SET entregado='SI' WHERE seriepedido='".$_POST['seriepedido']."'");
    }
if(isset($_POST) && !empty($_POST)){
	switch ($_POST['str'][1]['value']) {
    case 'BOLETA DE VENTA':
        if ($_POST['serieventa']==0) {
            $res = mysqli_query($con,"SELECT MAX(serieventas)+1 FROM total_ventas WHERE documento='BOLETA DE VENTA'"); 
            $row = mysqli_fetch_row($res);
            $num="000000".$row[0];
            $num=substr($num,-7);
            for ($i=0; $i<sizeof($_POST['producto']) ; $i++) {
                $sql= mysqli_query($con,"INSERT INTO boleta (serieboleta,documento,id,compra,producto,cantidad,unitario,importe,especial,ruc,cliente,direccion,fecha,hora,vendedor,entregado) 
                    VALUES ('".$num."',
                            'BOLETA DE VENTA',
                            '".$_POST['id'][$i]."',
                            '".$_POST['compra'][$i]."',
                            '".$_POST['producto'][$i]."',
                            '".$_POST['cantidad'][$i]."',
                            '".$_POST['unitario'][$i]."',
                            '".$_POST['importe'][$i]."',
                            '".$_POST['promotor'][$i]."',
                            '".$_POST['str'][6]['value']."',
                            '".$_POST['str'][7]['value']."',
                            '".$_POST['str'][8]['value']."',
                            NOW(),
                            NOW(),
                            '".$_POST['str'][0]['value']."',
                            '".$_POST['str'][9]['value']."'
                            )");
                if($_POST['str'][9]['value']=='SI'){
                    $inse=mysqli_query($con,"UPDATE producto SET stock_real=(stock_real-".$_POST['cantidad'][$i].") WHERE id='".$_POST['id'][$i]."'");
                }
            }
            $query= mysqli_query($con,"INSERT INTO total_ventas (fecha,hora,serieventas,documento,ruc,cliente,direccion,entregado,subtotal,devolucion,total,vendedor,comentario,credito) 
                        VALUES (NOW(),
                                NOW(),
                                '".$num."',
                                'BOLETA DE VENTA',
                                '".$_POST['str'][6]['value']."',
                                '".$_POST['str'][7]['value']."',
                                '".$_POST['str'][8]['value']."',
                                '".$_POST['str'][9]['value']."',
                                '".$_POST['str'][10]['value']."',
                                '".$_POST['str'][11]['value']."',
                                '".$_POST['str'][12]['value']."',
                                '".$_POST['str'][0]['value']."',
                                '".$_POST['str'][13]['value']."',
                                '".$_POST['str'][2]['value']."'
                                )");
            if($_POST['str'][9]['value']=='SI'){
                if($_SESSION['cargo']=='CAJERO FIERROS'){
                    $inser=mysqli_query($con,"UPDATE dinerodiario1 SET boleta=(boleta+".$_POST['str'][12]['value'].") WHERE fecha='$hoy'");
                }else{
                    $inser=mysqli_query($con,"UPDATE dinerodiario SET boleta=(boleta+".$_POST['str'][12]['value'].") WHERE fecha='$hoy'");
                }
            }
        }else{
            $sqla=mysqli_query($con,"SELECT total,entregado FROM total_ventas WHERE serieventas='".$_POST['serieventa']."' AND documento='BOLETA DE VENTA'");
            $del = mysqli_query($con,"SELECT id,cantidad FROM boleta WHERE serieboleta='".$_POST['serieventa']."'"); 
            $ro=mysqli_fetch_row($sqla);
            if($ro[1]=='SI'){
                if($_SESSION['cargo']=='CAJERO FIERROS'){
                    $inser=mysqli_query($con,"UPDATE dinerodiario1 SET boleta=(boleta-".$ro[0].") WHERE fecha='$hoy'");
                }else{
                    $inser=mysqli_query($con,"UPDATE dinerodiario SET boleta=(boleta-".$ro[0].") WHERE fecha='$hoy'");
                }
                while($row = mysqli_fetch_assoc($del)){
                    $ins=mysqli_query($con,"UPDATE producto SET stock_real=(stock_real+".$row['cantidad'].") WHERE id='".$row['id']."'");
                }
            }
            $del1 = mysqli_query($con,"DELETE FROM boleta WHERE serieboleta='".$_POST['serieventa']."'");
            $del2 = mysqli_query($con,"DELETE FROM total_ventas WHERE serieventas='".$_POST['serieventa']."' AND documento='BOLETA DE VENTA'");
            $num=$_POST['serieventa'];
            for ($i=0; $i<sizeof($_POST['producto']) ; $i++) {
                $sql= mysqli_query($con,"INSERT INTO boleta (serieboleta,documento,id,compra,producto,cantidad,unitario,importe,especial,ruc,cliente,direccion,fecha,hora,vendedor,entregado) 
                    VALUES ('".$num."',
                            'BOLETA DE VENTA',
                            '".$_POST['id'][$i]."',
                            '".$_POST['compra'][$i]."',
                            '".$_POST['producto'][$i]."',
                            '".$_POST['cantidad'][$i]."',
                            '".$_POST['unitario'][$i]."',
                            '".$_POST['importe'][$i]."',
                            '".$_POST['promotor'][$i]."',
                            '".$_POST['str'][6]['value']."',
                            '".$_POST['str'][7]['value']."',
                            '".$_POST['str'][8]['value']."',
                            NOW(),
                            NOW(),
                            '".$_POST['str'][0]['value']."',
                            '".$_POST['str'][9]['value']."'
                            )");
                if($_POST['str'][9]['value']=='SI'){
                    $inse=mysqli_query($con,"UPDATE producto SET stock_real=(stock_real-".$_POST['cantidad'][$i].") WHERE id='".$_POST['id'][$i]."'");
                }
            }
            $query= mysqli_query($con,"INSERT INTO total_ventas (fecha,hora,serieventas,documento,ruc,cliente,direccion,entregado,subtotal,devolucion,total,vendedor,comentario,credito) 
                        VALUES (NOW(),
                                NOW(),
                                '".$num."',
                                'BOLETA DE VENTA',
                                '".$_POST['str'][6]['value']."',
                                '".$_POST['str'][7]['value']."',
                                '".$_POST['str'][8]['value']."',
                                '".$_POST['str'][9]['value']."',
                                '".$_POST['str'][10]['value']."',
                                '".$_POST['str'][11]['value']."',
                                '".$_POST['str'][12]['value']."',
                                '".$_POST['str'][0]['value']."',
                                '".$_POST['str'][13]['value']."',
                                '".$_POST['str'][2]['value']."'
                                )");
            if($_POST['str'][9]['value']=='SI'){
                if($_SESSION['cargo']=='CAJERO FIERROS'){
                    $inser=mysqli_query($con,"UPDATE dinerodiario1 SET boleta=(boleta+".$_POST['str'][12]['value'].") WHERE fecha='$hoy'");
                }else{
                    $inser=mysqli_query($con,"UPDATE dinerodiario SET boleta=(boleta+".$_POST['str'][12]['value'].") WHERE fecha='$hoy'");
                }
            }
        }
	break;
	case 'FACTURA':
		if ($_POST['serieventa']==0) {
            $res = mysqli_query($con,"SELECT MAX(serieventas)+1 FROM total_ventas WHERE documento='FACTURA'"); 
            $row = mysqli_fetch_row($res);
            $num="000000".$row[0];
            $num=substr($num,-7);
            for ($i=0; $i<sizeof($_POST['producto']) ; $i++) {
                $sql= mysqli_query($con,"INSERT INTO factura (seriefactura,documento,id,compra,producto,cantidad,unitario,importe,especial,ruc,cliente,direccion,fecha,hora,vendedor,entregado) 
                    VALUES ('".$num."',
                            'FACTURA',
                            '".$_POST['id'][$i]."',
                            '".$_POST['compra'][$i]."',
                            '".$_POST['producto'][$i]."',
                            '".$_POST['cantidad'][$i]."',
                            '".$_POST['unitario'][$i]."',
                            '".$_POST['importe'][$i]."',
                            '".$_POST['promotor'][$i]."',
                            '".$_POST['str'][6]['value']."',
                            '".$_POST['str'][7]['value']."',
                            '".$_POST['str'][8]['value']."',
                            '".date('Y-m-d', strtotime(str_replace('/', '-', $_POST['str'][5]['value'])))."',
                            NOW(),
                            '".$_POST['str'][0]['value']."',
                            '".$_POST['str'][9]['value']."'
                            )");
                $inse=mysqli_query($con,"UPDATE producto SET stock_con=(stock_con-".$_POST['cantidad'][$i].") WHERE id='".$_POST['id'][$i]."'");
            }
            $query= mysqli_query($con,"INSERT INTO total_ventas (fecha,hora,serieventas,documento,ruc,cliente,direccion,entregado,subtotal,devolucion,total,vendedor,comentario,credito,igv) 
                        VALUES ('".date('Y-m-d', strtotime(str_replace('/', '-', $_POST['str'][5]['value'])))."',
                                NOW(),
                                '".$num."',
                                'FACTURA',
                                '".$_POST['str'][6]['value']."',
                                '".$_POST['str'][7]['value']."',
                                '".$_POST['str'][8]['value']."',
                                'NO',
                                '".$_POST['str'][10]['value']."',
                                '".$_POST['str'][11]['value']."',
                                '".$_POST['str'][12]['value']."',
                                '".$_POST['str'][0]['value']."',
                                '".$_POST['str'][13]['value']."',
                                '".$_POST['str'][2]['value']."',
                                '0.00'
                                )");
        }
        else{
            $del = mysqli_query($con,"SELECT id,cantidad,entregado FROM facturapaola WHERE seriefactura='".$_POST['serieventa']."'"); 
            while($row = mysqli_fetch_assoc($del)){
                if($row['entregado']=='NO' ){
                    $ins=mysqli_query($con,"UPDATE producto SET stock_con=(stock_con+".$row['cantidad'].") WHERE id='".$row['id']."'");
                }
            }
            $del1 = mysqli_query($con,"DELETE FROM factura WHERE seriefactura='".$_POST['serieventa']."'");
            $del2 = mysqli_query($con,"DELETE FROM total_ventas WHERE serieventas='".$_POST['serieventa']."' AND documento='FACTURA'");
            $num=$_POST['serieventa'];
            for ($i=0; $i<sizeof($_POST['producto']) ; $i++) {
                $sql= mysqli_query($con,"INSERT INTO factura (seriefactura,documento,id,compra,producto,cantidad,unitario,importe,especial,ruc,cliente,direccion,fecha,hora,vendedor,entregado) 
                    VALUES ('".$num."',
                            'FACTURA',
                            '".$_POST['id'][$i]."',
                            '".$_POST['compra'][$i]."',
                            '".$_POST['producto'][$i]."',
                            '".$_POST['cantidad'][$i]."',
                            '".$_POST['unitario'][$i]."',
                            '".$_POST['importe'][$i]."',
                            '".$_POST['promotor'][$i]."',
                            '".$_POST['str'][6]['value']."',
                            '".$_POST['str'][7]['value']."',
                            '".$_POST['str'][8]['value']."',
                            '".date('Y-m-d', strtotime(str_replace('/', '-', $_POST['str'][5]['value'])))."',
                            NOW(),
                            '".$_POST['str'][0]['value']."',
                            '".$_POST['str'][9]['value']."'
                            )");
                $inse=mysqli_query($con,"UPDATE producto SET stock_con=(stock_con-".$_POST['cantidad'][$i].") WHERE id='".$_POST['id'][$i]."'");
            }
            $query= mysqli_query($con,"INSERT INTO total_ventas (fecha,hora,serieventas,documento,ruc,cliente,direccion,entregado,subtotal,devolucion,total,vendedor,comentario,credito,igv) 
                        VALUES ('".date('Y-m-d', strtotime(str_replace('/', '-', $_POST['str'][5]['value'])))."',
                                NOW(),
                                '".$num."',
                                'FACTURA',
                                '".$_POST['str'][6]['value']."',
                                '".$_POST['str'][7]['value']."',
                                '".$_POST['str'][8]['value']."',
                                'NO',
                                '".$_POST['str'][10]['value']."',
                                '".$_POST['str'][11]['value']."',
                                '".$_POST['str'][12]['value']."',
                                '".$_POST['str'][0]['value']."',
                                '".$_POST['str'][13]['value']."',
                                '".$_POST['str'][2]['value']."',
                                '0.00'
                                )");
        }
    break;
	case 'NOTA DE PEDIDO':
		if ($_POST['serieventa']==0) {
            $res = mysqli_query($con,"SELECT MAX(serieventas)+1 FROM total_ventas WHERE documento='NOTA DE PEDIDO'"); 
            $row = mysqli_fetch_row($res);
            $num="000000".$row[0];
            $num=substr($num,-7);
            if(isset($_POST['producto']) && !empty($_POST['producto'])){
                for ($i=0; $i<sizeof($_POST['producto']) ; $i++) {
                    $sql= mysqli_query($con,"INSERT INTO notapedido (serienota,documento,id,compra,producto,cantidad,unitario,importe,especial,ruc,cliente,direccion,fecha,hora,vendedor,entregado) 
                        VALUES ('".$num."',
                                'NOTA DE PEDIDO',
                                '".$_POST['id'][$i]."',
                                '".$_POST['compra'][$i]."',
                                '".$_POST['producto'][$i]."',
                                '".$_POST['cantidad'][$i]."',
                                '".$_POST['unitario'][$i]."',
                                '".$_POST['importe'][$i]."',
                                '".$_POST['promotor'][$i]."',
                                '".$_POST['str'][6]['value']."',
                                '".$_POST['str'][7]['value']."',
                                '".$_POST['str'][8]['value']."',
                                '".$hoy."',
                                NOW(),
                                '".$_POST['str'][0]['value']."',
                                '".$_POST['str'][9]['value']."'
                                )");
                    $inse=mysqli_query($con,"UPDATE producto SET stock_real=(stock_real-".$_POST['cantidad'][$i].") WHERE id='".$_POST['id'][$i]."'");
                }
            }
            $resta=$_POST['str'][12]['value']-$_POST['str'][4]['value'];
            $query= mysqli_query($con,"INSERT INTO total_ventas (fecha,hora,serieventas,documento,ruc,cliente,direccion,entregado,subtotal,devolucion,total,vendedor,comentario,credito,acuenta,fechapago,pendiente) 
                        VALUES ('".$hoy."',
                                NOW(),
                                '".$num."',
                                'NOTA DE PEDIDO',
                                '".$_POST['str'][6]['value']."',
                                '".$_POST['str'][7]['value']."',
                                '".$_POST['str'][8]['value']."',
                                '".$_POST['str'][9]['value']."',
                                '".$_POST['str'][10]['value']."',
                                '".$_POST['str'][11]['value']."',
                                '".$_POST['str'][12]['value']."',
                                '".$_POST['str'][0]['value']."',
                                '".$_POST['str'][13]['value']."',
                                '".$_POST['str'][2]['value']."',
                                '".$_POST['str'][4]['value']."',
                                '".date('Y-m-d', strtotime(str_replace('/', '-', $_POST['str'][3]['value'])))."',
                                '".$resta."'
                                )");
            if($_POST['str'][2]['value']=='CONTADO'){
                if($_SESSION['cargo']=='CAJERO FIERROS'){
                    $inser=mysqli_query($con,"UPDATE dinerodiario1 SET nota=(nota+".$_POST['str'][12]['value'].") WHERE fecha='$hoy'");
                }else{
                    $inser=mysqli_query($con,"UPDATE dinerodiario SET nota=(nota+".$_POST['str'][12]['value'].") WHERE fecha='$hoy'");
                }
            }
            if(isset($_POST['producto1']) && !empty($_POST['producto1'])){
                for ($i=0; $i<sizeof($_POST['producto1']) ; $i++) {
                    $sql1= mysqli_query($con,"INSERT INTO devoluciones (seriedevolucion,documento,id,compra,producto,cantidad,unitario,importe,especial,ruc,cliente,direccion,fecha,hora,vendedor,estado,entregado) 
                        VALUES ('".$num."',
                                'DEVOLUCION',
                                '".$_POST['id1'][$i]."',
                                '".$_POST['compra1'][$i]."',
                                '".$_POST['producto1'][$i]."',
                                '".$_POST['cantidad1'][$i]."',
                                '".$_POST['unitario1'][$i]."',
                                '".$_POST['importe1'][$i]."',
                                '',
                                '".$_POST['str'][6]['value']."',
                                '".$_POST['str'][7]['value']."',
                                '".$_POST['str'][8]['value']."',
                                '".$hoy."',
                                NOW(),
                                '".$_POST['str'][0]['value']."',
                                '".$_POST['estado1'][$i]."',
                                '".$_POST['str'][9]['value']."'
                                )");
                    if($_POST['estado1'][$i]=='BUENO'){
                        $inse=mysqli_query($con,"UPDATE producto SET stock_real=(stock_real+".$_POST['cantidad1'][$i].") WHERE id='".$_POST['id1'][$i]."'");
                    }
                }
            }
            if($_POST['str'][4]['value']!=0 && $hoy1==date('Y-m-d', strtotime(str_replace('/', '-', $_POST['str'][5]['value'])))){
                $que=mysqli_query($con,"INSERT INTO adelantos (serie,adelanto,encargado,fecha,forma,cliente,sesion) 
                    VALUES ('".$num."',
                            '".$_POST['str'][4]['value']."',
                            '".$_POST['str'][0]['value']."',
                            NOW(),
                            'EFECTIVO',
                            '".$_POST['str'][7]['value']."',
                            '".$_SESSION['cargo']."'
                        )");
                if($_SESSION['cargo']=='CAJERO FIERROS'){
                    $insertt=mysqli_query($con,"UPDATE dinerodiario1 SET creditos=(creditos+".$_POST['str'][4]['value'].") WHERE fecha='$hoy'");
                }else{
                    $insertt=mysqli_query($con,"UPDATE dinerodiario SET creditos=(creditos+".$_POST['str'][4]['value'].") WHERE fecha='$hoy'");
                }
            }
        }
        else{
            $sqla=mysqli_query($con,"SELECT total,credito,entregado,acuenta FROM total_ventas WHERE serieventas='".$_POST['serieventa']."' AND documento='NOTA DE PEDIDO'");
            $ro=mysqli_fetch_row($sqla);
            if($ro[1]=='CONTADO' && $ro[2]=='SI'){
                if($_SESSION['cargo']=='CAJERO FIERROS'){
                    $inser=mysqli_query($con,"UPDATE dinerodiario1 SET nota=(nota-".$ro[0].") WHERE fecha='$hoy'");
                }else{
                    $inser=mysqli_query($con,"UPDATE dinerodiario SET nota=(nota-".$ro[0].") WHERE fecha='$hoy'");
                }
            }
            $d = mysqli_query($con,"SELECT id,cantidad,entregado FROM notapedido WHERE serienota='".$_POST['serieventa']."'"); 
            while($row = mysqli_fetch_assoc($d)){
                if($row['entregado']=='SI' ){
                    $ins=mysqli_query($con,"UPDATE producto SET stock_real=(stock_real+".$row['cantidad'].") WHERE id='".$row['id']."'");
                }
            }
            $c = mysqli_query($con,"SELECT id,cantidad,estado FROM devoluciones WHERE seriedevolucion='".$_POST['serieventa']."'"); 
            while($row = mysqli_fetch_assoc($c)){
                if($row['estado']=='BUENO' ){
                    $ins=mysqli_query($con,"UPDATE producto SET stock_real=(stock_real-".$row['cantidad'].") WHERE id='".$row['id']."'");
                }
            }
            $del = mysqli_query($con,"DELETE FROM notapedido WHERE serienota='".$_POST['serieventa']."'");
            $del1 = mysqli_query($con,"DELETE FROM devoluciones WHERE seriedevolucion='".$_POST['serieventa']."'");
            $del2 = mysqli_query($con,"DELETE FROM total_ventas WHERE serieventas='".$_POST['serieventa']."' AND documento='NOTA DE PEDIDO'");
            $num=$_POST['serieventa'];
            if($ro[3]>0 && $hoy==date('Y-m-d', strtotime(str_replace('/', '-', $_POST['str'][5]['value'])))){
                $quee=mysqli_query($con,"DELETE FROM adelantos WHERE serie='".$_POST['serieventa']."'");
                if($_SESSION['cargo']=='CAJERO FIERROS'){
                    $insertt=mysqli_query($con,"UPDATE dinerodiario1 SET creditos=(creditos-".$ro[3].") WHERE fecha='".$hoy."'");
                }else{
                    $insertt=mysqli_query($con,"UPDATE dinerodiario SET creditos=(creditos-".$ro[3].") WHERE fecha='".$hoy."'");
                }
            }
            $hoy=date('Y-m-d', strtotime(str_replace('/', '-', $_POST['str'][5]['value'])));
            if(isset($_POST['producto']) && !empty($_POST['producto'])){
                for ($i=0; $i<sizeof($_POST['producto']) ; $i++) {
                    $sql= mysqli_query($con,"INSERT INTO notapedido (serienota,documento,id,compra,producto,cantidad,unitario,importe,especial,ruc,cliente,direccion,fecha,hora,vendedor,entregado) 
                        VALUES ('".$num."',
                                'NOTA DE PEDIDO',
                                '".$_POST['id'][$i]."',
                                '".$_POST['compra'][$i]."',
                                '".$_POST['producto'][$i]."',
                                '".$_POST['cantidad'][$i]."',
                                '".$_POST['unitario'][$i]."',
                                '".$_POST['importe'][$i]."',
                                '".$_POST['promotor'][$i]."',
                                '".$_POST['str'][6]['value']."',
                                '".$_POST['str'][7]['value']."',
                                '".$_POST['str'][8]['value']."',
                                '".$hoy."',
                                NOW(),
                                '".$_POST['str'][0]['value']."',
                                '".$_POST['str'][9]['value']."'
                                )");
                    $inse=mysqli_query($con,"UPDATE producto SET stock_real=(stock_real-".$_POST['cantidad'][$i].") WHERE id='".$_POST['id'][$i]."'");
                }
            }
            $resta=$_POST['str'][12]['value']-$_POST['str'][4]['value'];
            $query= mysqli_query($con,"INSERT INTO total_ventas (fecha,hora,serieventas,documento,ruc,cliente,direccion,entregado,subtotal,devolucion,total,vendedor,comentario,credito,acuenta,fechapago,pendiente) 
                        VALUES ('".$hoy."',
                                NOW(),
                                '".$num."',
                                'NOTA DE PEDIDO',
                                '".$_POST['str'][6]['value']."',
                                '".$_POST['str'][7]['value']."',
                                '".$_POST['str'][8]['value']."',
                                '".$_POST['str'][9]['value']."',
                                '".$_POST['str'][10]['value']."',
                                '".$_POST['str'][11]['value']."',
                                '".$_POST['str'][12]['value']."',
                                '".$_POST['str'][0]['value']."',
                                '".$_POST['str'][13]['value']."',
                                '".$_POST['str'][2]['value']."',
                                '".$_POST['str'][4]['value']."',
                                '".date('Y-m-d', strtotime(str_replace('/', '-', $_POST['str'][3]['value'])))."',
                                '".$resta."'
                                )");
            if($_POST['str'][2]['value']=='CONTADO'){
                if($_SESSION['cargo']=='CAJERO FIERROS'){
                    $inser=mysqli_query($con,"UPDATE dinerodiario1 SET nota=(nota+".$_POST['str'][12]['value'].") WHERE fecha='$hoy'");
                }else{
                    $inser=mysqli_query($con,"UPDATE dinerodiario SET nota=(nota+".$_POST['str'][12]['value'].") WHERE fecha='$hoy'");
                }
            }
            if(isset($_POST['producto1']) && !empty($_POST['producto1'])){
                for ($i=0; $i<sizeof($_POST['producto1']) ; $i++) {
                    $sql1= mysqli_query($con,"INSERT INTO devoluciones (seriedevolucion,documento,id,compra,producto,cantidad,unitario,importe,especial,ruc,cliente,direccion,fecha,hora,vendedor,estado,entregado) 
                        VALUES ('".$num."',
                                'DEVOLUCION',
                                '".$_POST['id1'][$i]."',
                                '".$_POST['compra1'][$i]."',
                                '".$_POST['producto1'][$i]."',
                                '".$_POST['cantidad1'][$i]."',
                                '".$_POST['unitario1'][$i]."',
                                '".$_POST['importe1'][$i]."',
                                '',
                                '".$_POST['str'][6]['value']."',
                                '".$_POST['str'][7]['value']."',
                                '".$_POST['str'][8]['value']."',
                                '".$hoy."',
                                NOW(),
                                '".$_POST['str'][0]['value']."',
                                '".$_POST['estado1'][$i]."',
                                '".$_POST['str'][9]['value']."'
                                )");
                    if($_POST['estado1'][$i]=='BUENO'){
                        $inse=mysqli_query($con,"UPDATE producto SET stock_real=(stock_real+".$_POST['cantidad1'][$i].") WHERE id='".$_POST['id1'][$i]."'");
                    }
                }
            }
            if($_POST['str'][4]['value']!=0 && $hoy1==date('Y-m-d', strtotime(str_replace('/', '-', $_POST['str'][5]['value'])))){
                $que=mysqli_query($con,"INSERT INTO adelantos (serie,adelanto,encargado,fecha,forma,cliente,sesion) 
                    VALUES ('".$num."',
                            '".$_POST['str'][4]['value']."',
                            '".$_POST['str'][0]['value']."',
                            NOW(),
                            'EFECTIVO',
                            '".$_POST['str'][7]['value']."',
                            '".$_SESSION['cargo']."'
                        )");
                if($_SESSION['cargo']=='CAJERO FIERROS'){
                    $insertt=mysqli_query($con,"UPDATE dinerodiario1 SET creditos=(creditos+".$_POST['str'][4]['value'].") WHERE fecha='$hoy'");
                }else{
                    $insertt=mysqli_query($con,"UPDATE dinerodiario SET creditos=(creditos+".$_POST['str'][4]['value'].") WHERE fecha='$hoy'");
                }
                
            }
        }
	break;
    case 'GUIA DE REMISION':
        if ($_POST['serieventa']==0) {
            $res = mysqli_query($con,"SELECT MAX(serieventas)+1 FROM total_ventas WHERE documento='GUIA DE REMISION'"); 
            $row = mysqli_fetch_row($res);
            $num="000000".$row[0];
            $num=substr($num,-7);
            for ($i=0; $i<sizeof($_POST['producto']) ; $i++) {
                $sql= mysqli_query($con,"INSERT INTO guiaderemision (serieguia,id,compra,producto,cantidad,unitario,importe,especial,ruc,cliente,direccion,fecha,hora,vendedor) 
                    VALUES ('".$num."',
                            '".$_POST['id'][$i]."',
                            '".$_POST['compra'][$i]."',
                            '".$_POST['producto'][$i]."',
                            '".$_POST['cantidad'][$i]."',
                            '".$_POST['unitario'][$i]."',
                            '".$_POST['importe'][$i]."',
                            '".$_POST['promotor'][$i]."',
                            '".$_POST['str'][6]['value']."',
                            '".$_POST['str'][7]['value']."',
                            '".$_POST['str'][8]['value']."',
                            '".date('Y-m-d', strtotime(str_replace('/', '-', $_POST['str'][5]['value'])))."',
                            NOW(),
                            '".$_POST['str'][0]['value']."'
                            )");
            }
            $query= mysqli_query($con,"INSERT INTO total_ventas (fecha,hora,serieventas,documento,ruc,cliente,direccion,entregado,subtotal,devolucion,total,vendedor,comentario,credito) 
                        VALUES ('".date('Y-m-d', strtotime(str_replace('/', '-', $_POST['str'][5]['value'])))."',
                                NOW(),
                                '".$num."',
                                'GUIA DE REMISION',
                                '".$_POST['str'][6]['value']."',
                                '".$_POST['str'][7]['value']."',
                                '".$_POST['str'][8]['value']."',
                                'NO',
                                '".$_POST['str'][10]['value']."',
                                '".$_POST['str'][11]['value']."',
                                '".$_POST['str'][12]['value']."',
                                '".$_POST['str'][0]['value']."',
                                '".$_POST['str'][13]['value']."',
                                '".$_POST['str'][2]['value']."'
                                )");
        }
        else{
            $del = mysqli_query($con,"DELETE FROM guiaderemision WHERE serieguia='".$_POST['serieventa']."'");
            $del1 = mysqli_query($con,"DELETE FROM total_ventas WHERE serieventas='".$_POST['serieventa']."' AND documento='GUIA DE REMISION'");
            $num=$_POST['serieventa'];
            for ($i=0; $i<sizeof($_POST['producto']) ; $i++) {
                $sql= mysqli_query($con,"INSERT INTO guiaderemision (serieguia,id,compra,producto,cantidad,unitario,importe,especial,ruc,cliente,direccion,fecha,hora,vendedor) 
                    VALUES ('".$num."',
                            '".$_POST['id'][$i]."',
                            '".$_POST['compra'][$i]."',
                            '".$_POST['producto'][$i]."',
                            '".$_POST['cantidad'][$i]."',
                            '".$_POST['unitario'][$i]."',
                            '".$_POST['importe'][$i]."',
                            '".$_POST['promotor'][$i]."',
                            '".$_POST['str'][6]['value']."',
                            '".$_POST['str'][7]['value']."',
                            '".$_POST['str'][8]['value']."',
                            '".date('Y-m-d', strtotime(str_replace('/', '-', $_POST['str'][5]['value'])))."',
                            NOW(),
                            '".$_POST['str'][0]['value']."'
                            )");
            }
            $query= mysqli_query($con,"INSERT INTO total_ventas (fecha,hora,serieventas,documento,ruc,cliente,direccion,entregado,subtotal,devolucion,total,vendedor,comentario,credito) 
                        VALUES ('".date('Y-m-d', strtotime(str_replace('/', '-', $_POST['str'][5]['value'])))."',
                                NOW(),
                                '".$num."',
                                'GUIA DE REMISION',
                                '".$_POST['str'][6]['value']."',
                                '".$_POST['str'][7]['value']."',
                                '".$_POST['str'][8]['value']."',
                                'NO',
                                '".$_POST['str'][10]['value']."',
                                '".$_POST['str'][11]['value']."',
                                '".$_POST['str'][12]['value']."',
                                '".$_POST['str'][0]['value']."',
                                '".$_POST['str'][13]['value']."',
                                '".$_POST['str'][2]['value']."'
                                )");
        }
    break;
	case 'COTIZACION':
		if ($_POST['serieventa']==0) {
            $res = mysqli_query($con,"SELECT MAX(serieventas)+1 FROM total_ventas WHERE documento='COTIZACION'"); 
            $row = mysqli_fetch_row($res);
            $num="000000".$row[0];
            $num=substr($num,-7);
            for ($i=0; $i<sizeof($_POST['producto']) ; $i++) {
                $sql= mysqli_query($con,"INSERT INTO cotizacion (seriecotizacion,id,compra,producto,cantidad,unitario,importe,especial,ruc,cliente,direccion,fecha,hora,vendedor) 
                    VALUES ('".$num."',
                            '".$_POST['id'][$i]."',
                            '".$_POST['compra'][$i]."',
                            '".$_POST['producto'][$i]."',
                            '".$_POST['cantidad'][$i]."',
                            '".$_POST['unitario'][$i]."',
                            '".$_POST['importe'][$i]."',
                            '".$_POST['promotor'][$i]."',
                            '".$_POST['str'][6]['value']."',
                            '".$_POST['str'][7]['value']."',
                            '".$_POST['str'][8]['value']."',
                            NOW(),
                            NOW(),
                            '".$_POST['str'][0]['value']."'
                            )");
            }
            $query= mysqli_query($con,"INSERT INTO total_ventas (fecha,hora,serieventas,documento,ruc,cliente,direccion,entregado,subtotal,devolucion,total,vendedor,comentario,credito) 
                        VALUES (NOW(),
                                NOW(),
                                '".$num."',
                                'COTIZACION',
                                '".$_POST['str'][6]['value']."',
                                '".$_POST['str'][7]['value']."',
                                '".$_POST['str'][8]['value']."',
                                'NO',
                                '".$_POST['str'][10]['value']."',
                                '".$_POST['str'][11]['value']."',
                                '".$_POST['str'][12]['value']."',
                                '".$_POST['str'][0]['value']."',
                                '".$_POST['str'][13]['value']."',
                                '".$_POST['str'][2]['value']."'
                                )");
        }
        else{
            $del = mysqli_query($con,"DELETE FROM cotizacion WHERE seriecotizacion='".$_POST['serieventa']."'");
            $del1 = mysqli_query($con,"DELETE FROM total_ventas WHERE serieventas='".$_POST['serieventa']."' AND documento='COTIZACION'");
            $num=$_POST['serieventa'];
            for ($i=0; $i<sizeof($_POST['producto']) ; $i++) {
                $sql= mysqli_query($con,"INSERT INTO cotizacion (seriecotizacion,id,compra,producto,cantidad,unitario,importe,especial,ruc,cliente,direccion,fecha,hora,vendedor) 
                    VALUES ('".$num."',
                            '".$_POST['id'][$i]."',
                            '".$_POST['compra'][$i]."',
                            '".$_POST['producto'][$i]."',
                            '".$_POST['cantidad'][$i]."',
                            '".$_POST['unitario'][$i]."',
                            '".$_POST['importe'][$i]."',
                            '".$_POST['promotor'][$i]."',
                            '".$_POST['str'][6]['value']."',
                            '".$_POST['str'][7]['value']."',
                            '".$_POST['str'][8]['value']."',
                            NOW(),
                            NOW(),
                            '".$_POST['str'][0]['value']."'
                            )");
            }
            $query= mysqli_query($con,"INSERT INTO total_ventas (fecha,hora,serieventas,documento,ruc,cliente,direccion,entregado,subtotal,devolucion,total,vendedor,comentario,credito) 
                        VALUES (NOW(),
                                NOW(),
                                '".$num."',
                                'COTIZACION',
                                '".$_POST['str'][6]['value']."',
                                '".$_POST['str'][7]['value']."',
                                '".$_POST['str'][8]['value']."',
                                'NO',
                                '".$_POST['str'][10]['value']."',
                                '".$_POST['str'][11]['value']."',
                                '".$_POST['str'][12]['value']."',
                                '".$_POST['str'][0]['value']."',
                                '".$_POST['str'][13]['value']."',
                                '".$_POST['str'][2]['value']."'
                                )");
        }
	break;
	}
}
echo $num;
?>