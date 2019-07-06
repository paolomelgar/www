<?php
    require_once('../connection.php');
    $hoy=date("Y-m-d");
    $hoy1=$hoy;
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
                            '".addslashes($_POST['str'][7]['value'])."',
                            '".addslashes($_POST['str'][8]['value'])."',
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
                                '".addslashes($_POST['str'][7]['value'])."',
                                '".addslashes($_POST['str'][8]['value'])."',
                                '".$_POST['str'][9]['value']."',
                                '".$_POST['str'][10]['value']."',
                                '".$_POST['str'][11]['value']."',
                                '".$_POST['str'][12]['value']."',
                                '".$_POST['str'][0]['value']."',
                                '".$_POST['str'][13]['value']."',
                                '".$_POST['str'][2]['value']."'
                                )");
            if($_POST['str'][9]['value']=='SI'){
                $inser=mysqli_query($con,"UPDATE dinerodiario SET boleta=(boleta+".$_POST['str'][12]['value'].") WHERE fecha='$hoy'");
            }
        }else{
            $sqla=mysqli_query($con,"SELECT total,entregado FROM total_ventas WHERE serieventas='".$_POST['serieventa']."' AND documento='BOLETA DE VENTA'");
            $del = mysqli_query($con,"SELECT id,cantidad FROM boleta WHERE serieboleta='".$_POST['serieventa']."'"); 
            $ro=mysqli_fetch_row($sqla);
            if($ro[1]=='SI'){
                $inser=mysqli_query($con,"UPDATE dinerodiario SET boleta=(boleta-".$ro[0].") WHERE fecha='$hoy'");
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
                            '".addslashes($_POST['str'][7]['value'])."',
                            '".addslashes($_POST['str'][8]['value'])."',
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
                                '".addslashes($_POST['str'][7]['value'])."',
                                '".addslashes($_POST['str'][8]['value'])."',
                                '".$_POST['str'][9]['value']."',
                                '".$_POST['str'][10]['value']."',
                                '".$_POST['str'][11]['value']."',
                                '".$_POST['str'][12]['value']."',
                                '".$_POST['str'][0]['value']."',
                                '".$_POST['str'][13]['value']."',
                                '".$_POST['str'][2]['value']."'
                                )");
            if($_POST['str'][9]['value']=='SI'){
                $inser=mysqli_query($con,"UPDATE dinerodiario SET boleta=(boleta+".$_POST['str'][12]['value'].") WHERE fecha='$hoy'");
            }
        }
    break;
    case 'FACTURA ELECTRONICA INNOVA':
        if ($_POST['serieventa']==0) {
            $res = mysqli_query($con,"SELECT MAX(serieventas) FROM total_ventas WHERE documento='FACTURA ELECTRONICA INNOVA'"); 
            $row = mysqli_fetch_row($res);
            $mm=$row[0]+1;
            $num="000000".$mm;
            $num=substr($num,-7);
            $archivo1 = fopen("C:/Users/FERREBOOM/Dropbox/20601765641/20601765641-01-F002-".$num.".DET", "w");
            for ($i=0; $i<sizeof($_POST['producto']) ; $i++) {
                $sql= mysqli_query($con,"INSERT INTO facturaelectronicapaul (seriefactura,documento,id,compra,producto,cantidad,unitario,importe,especial,ruc,cliente,direccion,fecha,hora,vendedor,entregado) 
                    VALUES ('".$num."',
                            'FACTURA ELECTRONICA INNOVA',
                            '".$_POST['id'][$i]."',
                            '".$_POST['compra'][$i]."',
                            '".$_POST['producto'][$i]."',
                            '".$_POST['cantidad'][$i]."',
                            '".$_POST['unitario'][$i]."',
                            '".$_POST['importe'][$i]."',
                            '".$_POST['promotor'][$i]."',
                            '".$_POST['str'][6]['value']."',
                            '".addslashes($_POST['str'][7]['value'])."',
                            '".addslashes($_POST['str'][8]['value'])."',
                            '".date('Y-m-d', strtotime(str_replace('/', '-', $_POST['str'][5]['value'])))."',
                            NOW(),
                            '".$_POST['str'][0]['value']."',
                            '".$_POST['str'][9]['value']."'
                            )");
                $inse=mysqli_query($con,"UPDATE producto SET stock_con=(stock_con-".$_POST['cantidad'][$i].") WHERE id='".$_POST['id'][$i]."'");
                $a1=number_format($_POST['unitario'][$i]/1.18,2,'.','');
                $b1=number_format($_POST['unitario'][$i]-$a1,2,'.','');
                $a11=number_format($_POST['importe'][$i]/1.18,2,'.','');
                $b11=number_format($_POST['importe'][$i]-$a11,2,'.','');
                if($i>0){
                    fwrite($archivo1,PHP_EOL ."NIU|".$_POST['cantidad'][$i]."||-|".$_POST['producto'][$i]."|".$a1."|".$b11."|1000|".$b11."|".$a1*$_POST['cantidad'][$i]."|IGV|VAT|10|18|-|0|0|||-|0|-|0|0|||0|".$_POST['importe'][$i]."|".$a1*$_POST['cantidad'][$i]."|0|");
                }else{
                    fwrite($archivo1,"NIU|".$_POST['cantidad'][$i]."||-|".$_POST['producto'][$i]."|".$a1."|".$b11."|1000|".$b11."|".$a1*$_POST['cantidad'][$i]."|IGV|VAT|10|18|-|0|0|||-|0|-|0|0|||0|".$_POST['importe'][$i]."|".$a1*$_POST['cantidad'][$i]."|0|");
                }
            }
            fclose($archivo1);
            $query= mysqli_query($con,"INSERT INTO total_ventas (fecha,hora,serieventas,documento,ruc,cliente,direccion,entregado,subtotal,devolucion,total,vendedor,comentario,credito,igv) 
                        VALUES ('".date('Y-m-d', strtotime(str_replace('/', '-', $_POST['str'][5]['value'])))."',
                                NOW(),
                                '".$num."',
                                'FACTURA ELECTRONICA INNOVA',
                                '".$_POST['str'][6]['value']."',
                                '".addslashes($_POST['str'][7]['value'])."',
                                '".addslashes($_POST['str'][8]['value'])."',
                                'NO',
                                '".$_POST['str'][10]['value']."',
                                '".$_POST['str'][11]['value']."',
                                '".$_POST['str'][12]['value']."',
                                '".$_POST['str'][0]['value']."',
                                '".$_POST['str'][13]['value']."',
                                '".$_POST['str'][2]['value']."',
                                '1'
                                )");
            $a=number_format($_POST['str'][12]['value']/1.18,2,'.','');
            $b=number_format($_POST['str'][12]['value']-$a,2,'.','');
            $archivo = fopen("C:/Users/FERREBOOM/Dropbox/20601765641/20601765641-01-F002-".$num.".CAB", "w");
            fwrite($archivo, "0101|".date('Y-m-d', strtotime(str_replace('/', '-', $_POST['str'][5]['value'])))."|".date("h:i:s")."|-|000|6|".$_POST['str'][6]['value']."|".trim(addslashes($_POST['str'][7]['value']))."|PEN|".$b."|".$a."|".$_POST['str'][12]['value']."|0.00|0.00|0.00|".$_POST['str'][12]['value']."|2.1|2|");
            fclose($archivo);
            $archivo2 = fopen("C:/Users/FERREBOOM/Dropbox/20601765641/20601765641-01-F002-".$num.".TRI", "w");
            fwrite($archivo2, "1000|IGV|VAT|".$a."|".$b."|");
            fclose($archivo2);
        }
        else{
            $del = mysqli_query($con,"SELECT id,cantidad,entregado FROM facturaelectronicapaul WHERE seriefactura='".$_POST['serieventa']."'"); 
            while($row = mysqli_fetch_assoc($del)){
                if($row['entregado']=='NO' ){
                    $ins=mysqli_query($con,"UPDATE producto SET stock_con=(stock_con+".$row['cantidad'].") WHERE id='".$row['id']."'");
                }
            }
            $del1 = mysqli_query($con,"DELETE FROM facturaelectronicapaul WHERE seriefactura='".$_POST['serieventa']."'");
            $del2 = mysqli_query($con,"DELETE FROM total_ventas WHERE serieventas='".$_POST['serieventa']."' AND documento='FACTURA ELECTRONICA INNOVA'");
            $num=$_POST['serieventa'];
            $archivo1 = fopen("C:/Users/FERREBOOM/Dropbox/20601765641/20601765641-01-F002-".$num.".DET", "w");
            for ($i=0; $i<sizeof($_POST['producto']) ; $i++) {
                $sql= mysqli_query($con,"INSERT INTO facturaelectronicapaul (seriefactura,documento,id,compra,producto,cantidad,unitario,importe,especial,ruc,cliente,direccion,fecha,hora,vendedor,entregado) 
                    VALUES ('".$num."',
                            'FACTURA ELECTRONICA INNOVA',
                            '".$_POST['id'][$i]."',
                            '".$_POST['compra'][$i]."',
                            '".$_POST['producto'][$i]."',
                            '".$_POST['cantidad'][$i]."',
                            '".$_POST['unitario'][$i]."',
                            '".$_POST['importe'][$i]."',
                            '".$_POST['promotor'][$i]."',
                            '".$_POST['str'][6]['value']."',
                            '".addslashes($_POST['str'][7]['value'])."',
                            '".addslashes($_POST['str'][8]['value'])."',
                            '".date('Y-m-d', strtotime(str_replace('/', '-', $_POST['str'][5]['value'])))."',
                            NOW(),
                            '".$_POST['str'][0]['value']."',
                            '".$_POST['str'][9]['value']."'
                            )");
                $inse=mysqli_query($con,"UPDATE producto SET stock_con=(stock_con-".$_POST['cantidad'][$i].") WHERE id='".$_POST['id'][$i]."'");
                $a1=number_format($_POST['unitario'][$i]/1.18,2,'.','');
                $b1=number_format($_POST['unitario'][$i]-$a1,2,'.','');
                $a11=number_format($_POST['importe'][$i]/1.18,2,'.','');
                $b11=number_format($_POST['importe'][$i]-$a11,2,'.','');
                if($i>0){
                    fwrite($archivo1,PHP_EOL ."NIU|".$_POST['cantidad'][$i]."||-|".$_POST['producto'][$i]."|".$a1."|".$b11."|1000|".$b11."|".$a1*$_POST['cantidad'][$i]."|IGV|VAT|10|18|-|0|0|||-|0|-|0|0|||0|".$_POST['importe'][$i]."|".$a1*$_POST['cantidad'][$i]."|0|");
                }else{
                    fwrite($archivo1,"NIU|".$_POST['cantidad'][$i]."||-|".$_POST['producto'][$i]."|".$a1."|".$b11."|1000|".$b11."|".$a1*$_POST['cantidad'][$i]."|IGV|VAT|10|18|-|0|0|||-|0|-|0|0|||0|".$_POST['importe'][$i]."|".$a1*$_POST['cantidad'][$i]."|0|");
                }
            }
            fclose($archivo1);
            $query= mysqli_query($con,"INSERT INTO total_ventas (fecha,hora,serieventas,documento,ruc,cliente,direccion,entregado,subtotal,devolucion,total,vendedor,comentario,credito,igv) 
                        VALUES ('".date('Y-m-d', strtotime(str_replace('/', '-', $_POST['str'][5]['value'])))."',
                                NOW(),
                                '".$num."',
                                'FACTURA ELECTRONICA INNOVA',
                                '".$_POST['str'][6]['value']."',
                                '".addslashes($_POST['str'][7]['value'])."',
                                '".addslashes($_POST['str'][8]['value'])."',
                                'NO',
                                '".$_POST['str'][10]['value']."',
                                '".$_POST['str'][11]['value']."',
                                '".$_POST['str'][12]['value']."',
                                '".$_POST['str'][0]['value']."',
                                '".$_POST['str'][13]['value']."',
                                '".$_POST['str'][2]['value']."',
                                '1'
                                )");
            $a=number_format($_POST['str'][12]['value']/1.18,2,'.','');
            $b=number_format($_POST['str'][12]['value']-$a,2,'.','');
            $archivo = fopen("C:/Users/FERREBOOM/Dropbox/20601765641/20601765641-01-F002-".$num.".CAB", "w");
            fwrite($archivo, "0101|".date('Y-m-d', strtotime(str_replace('/', '-', $_POST['str'][5]['value'])))."|".date("h:i:s")."|-|000|6|".$_POST['str'][6]['value']."|".trim(addslashes($_POST['str'][7]['value']))."|PEN|".$b."|".$a."|".$_POST['str'][12]['value']."|0.00|0.00|0.00|".$_POST['str'][12]['value']."|2.1|2|");
            fclose($archivo);
            $archivo2 = fopen("C:/Users/FERREBOOM/Dropbox/20601765641/20601765641-01-F002-".$num.".TRI", "w");
            fwrite($archivo2, "1000|IGV|VAT|".$a."|".$b."|");
            fclose($archivo2);
        }
    break;



    case 'FACTURA ELECTRONICA INNOVA':
        if ($_POST['serieventa']==0) {
            $res = mysqli_query($con,"SELECT MAX(serieventas) FROM total_ventas WHERE documento='FACTURA ELECTRONICA INNOVA'"); 
            $row = mysqli_fetch_row($res);
            $mm=$row[0]+1;
            $num="000000".$mm;
            $num=substr($num,-7);
            $archivo1 = fopen("C:/Users/FERREBOOM/Dropbox/20601765641/20601765641-01-F002-".$num.".DET", "w");
            for ($i=0; $i<sizeof($_POST['producto']) ; $i++) {
                $sql= mysqli_query($con,"INSERT INTO facturaelectronicapaul (seriefactura,documento,id,compra,producto,cantidad,unitario,importe,especial,ruc,cliente,direccion,fecha,hora,vendedor,entregado) 
                    VALUES ('".$num."',
                            'FACTURA ELECTRONICA INNOVA',
                            '".$_POST['id'][$i]."',
                            '".$_POST['compra'][$i]."',
                            '".$_POST['producto'][$i]."',
                            '".$_POST['cantidad'][$i]."',
                            '".$_POST['unitario'][$i]."',
                            '".$_POST['importe'][$i]."',
                            '".$_POST['promotor'][$i]."',
                            '".$_POST['str'][6]['value']."',
                            '".addslashes($_POST['str'][7]['value'])."',
                            '".addslashes($_POST['str'][8]['value'])."',
                            '".date('Y-m-d', strtotime(str_replace('/', '-', $_POST['str'][5]['value'])))."',
                            NOW(),
                            '".$_POST['str'][0]['value']."',
                            '".$_POST['str'][9]['value']."'
                            )");
                $inse=mysqli_query($con,"UPDATE producto SET stock_con=(stock_con-".$_POST['cantidad'][$i].") WHERE id='".$_POST['id'][$i]."'");
                $a1=number_format($_POST['unitario'][$i]/1.18,2,'.','');
                $b1=number_format($_POST['unitario'][$i]-$a1,2,'.','');
                $a11=number_format($_POST['importe'][$i]/1.18,2,'.','');
                $b11=number_format($_POST['importe'][$i]-$a11,2,'.','');
                if($i>0){
                    fwrite($archivo1,PHP_EOL ."NIU|".$_POST['cantidad'][$i]."||-|".$_POST['producto'][$i]."|".$a1."|".$b11."|1000|".$b11."|".$a1*$_POST['cantidad'][$i]."|IGV|VAT|10|18|-|0|0|||-|0|-|0|0|||0|".$_POST['importe'][$i]."|".$a1*$_POST['cantidad'][$i]."|0|");
                }else{
                    fwrite($archivo1,"NIU|".$_POST['cantidad'][$i]."||-|".$_POST['producto'][$i]."|".$a1."|".$b11."|1000|".$b11."|".$a1*$_POST['cantidad'][$i]."|IGV|VAT|10|18|-|0|0|||-|0|-|0|0|||0|".$_POST['importe'][$i]."|".$a1*$_POST['cantidad'][$i]."|0|");
                }
            }
            fclose($archivo1);
            $query= mysqli_query($con,"INSERT INTO total_ventas (fecha,hora,serieventas,documento,ruc,cliente,direccion,entregado,subtotal,devolucion,total,vendedor,comentario,credito,igv) 
                        VALUES ('".date('Y-m-d', strtotime(str_replace('/', '-', $_POST['str'][5]['value'])))."',
                                NOW(),
                                '".$num."',
                                'FACTURA ELECTRONICA INNOVA',
                                '".$_POST['str'][6]['value']."',
                                '".addslashes($_POST['str'][7]['value'])."',
                                '".addslashes($_POST['str'][8]['value'])."',
                                'NO',
                                '".$_POST['str'][10]['value']."',
                                '".$_POST['str'][11]['value']."',
                                '".$_POST['str'][12]['value']."',
                                '".$_POST['str'][0]['value']."',
                                '".$_POST['str'][13]['value']."',
                                '".$_POST['str'][2]['value']."',
                                '1'
                                )");
            $a=number_format($_POST['str'][12]['value']/1.18,2,'.','');
            $b=number_format($_POST['str'][12]['value']-$a,2,'.','');
            $archivo = fopen("C:/Users/FERREBOOM/Dropbox/20601765641/20601765641-01-F002-".$num.".CAB", "w");
            fwrite($archivo, "0101|".date('Y-m-d', strtotime(str_replace('/', '-', $_POST['str'][5]['value'])))."|".date("h:i:s")."|-|000|6|".$_POST['str'][6]['value']."|".trim(addslashes($_POST['str'][7]['value']))."|PEN|".$b."|".$a."|".$_POST['str'][12]['value']."|0.00|0.00|0.00|".$_POST['str'][12]['value']."|2.1|2|");
            fclose($archivo);
            $archivo2 = fopen("C:/Users/FERREBOOM/Dropbox/20601765641/20601765641-01-F002-".$num.".TRI", "w");
            fwrite($archivo2, "1000|IGV|VAT|".$a."|".$b."|");
            fclose($archivo2);
        }
        else{
            $del = mysqli_query($con,"SELECT id,cantidad,entregado FROM facturaelectronicapaul WHERE seriefactura='".$_POST['serieventa']."'"); 
            while($row = mysqli_fetch_assoc($del)){
                if($row['entregado']=='NO' ){
                    $ins=mysqli_query($con,"UPDATE producto SET stock_con=(stock_con+".$row['cantidad'].") WHERE id='".$row['id']."'");
                }
            }
            $del1 = mysqli_query($con,"DELETE FROM facturaelectronicapaul WHERE seriefactura='".$_POST['serieventa']."'");
            $del2 = mysqli_query($con,"DELETE FROM total_ventas WHERE serieventas='".$_POST['serieventa']."' AND documento='FACTURA ELECTRONICA INNOVA'");
            $num=$_POST['serieventa'];
            $archivo1 = fopen("C:/Users/FERREBOOM/Dropbox/20601765641/20601765641-01-F002-".$num.".DET", "w");
            for ($i=0; $i<sizeof($_POST['producto']) ; $i++) {
                $sql= mysqli_query($con,"INSERT INTO facturaelectronicapaul (seriefactura,documento,id,compra,producto,cantidad,unitario,importe,especial,ruc,cliente,direccion,fecha,hora,vendedor,entregado) 
                    VALUES ('".$num."',
                            'FACTURA ELECTRONICA INNOVA',
                            '".$_POST['id'][$i]."',
                            '".$_POST['compra'][$i]."',
                            '".$_POST['producto'][$i]."',
                            '".$_POST['cantidad'][$i]."',
                            '".$_POST['unitario'][$i]."',
                            '".$_POST['importe'][$i]."',
                            '".$_POST['promotor'][$i]."',
                            '".$_POST['str'][6]['value']."',
                            '".addslashes($_POST['str'][7]['value'])."',
                            '".addslashes($_POST['str'][8]['value'])."',
                            '".date('Y-m-d', strtotime(str_replace('/', '-', $_POST['str'][5]['value'])))."',
                            NOW(),
                            '".$_POST['str'][0]['value']."',
                            '".$_POST['str'][9]['value']."'
                            )");
                $inse=mysqli_query($con,"UPDATE producto SET stock_con=(stock_con-".$_POST['cantidad'][$i].") WHERE id='".$_POST['id'][$i]."'");
                $a1=number_format($_POST['unitario'][$i]/1.18,2,'.','');
                $b1=number_format($_POST['unitario'][$i]-$a1,2,'.','');
                $a11=number_format($_POST['importe'][$i]/1.18,2,'.','');
                $b11=number_format($_POST['importe'][$i]-$a11,2,'.','');
                if($i>0){
                    fwrite($archivo1,PHP_EOL ."NIU|".$_POST['cantidad'][$i]."||-|".$_POST['producto'][$i]."|".$a1."|".$b11."|1000|".$b11."|".$a1*$_POST['cantidad'][$i]."|IGV|VAT|10|18|-|0|0|||-|0|-|0|0|||0|".$_POST['importe'][$i]."|".$a1*$_POST['cantidad'][$i]."|0|");
                }else{
                    fwrite($archivo1,"NIU|".$_POST['cantidad'][$i]."||-|".$_POST['producto'][$i]."|".$a1."|".$b11."|1000|".$b11."|".$a1*$_POST['cantidad'][$i]."|IGV|VAT|10|18|-|0|0|||-|0|-|0|0|||0|".$_POST['importe'][$i]."|".$a1*$_POST['cantidad'][$i]."|0|");
                }
            }
            fclose($archivo1);
            $query= mysqli_query($con,"INSERT INTO total_ventas (fecha,hora,serieventas,documento,ruc,cliente,direccion,entregado,subtotal,devolucion,total,vendedor,comentario,credito,igv) 
                        VALUES ('".date('Y-m-d', strtotime(str_replace('/', '-', $_POST['str'][5]['value'])))."',
                                NOW(),
                                '".$num."',
                                'FACTURA ELECTRONICA INNOVA',
                                '".$_POST['str'][6]['value']."',
                                '".addslashes($_POST['str'][7]['value'])."',
                                '".addslashes($_POST['str'][8]['value'])."',
                                'NO',
                                '".$_POST['str'][10]['value']."',
                                '".$_POST['str'][11]['value']."',
                                '".$_POST['str'][12]['value']."',
                                '".$_POST['str'][0]['value']."',
                                '".$_POST['str'][13]['value']."',
                                '".$_POST['str'][2]['value']."',
                                '1'
                                )");
            $a=number_format($_POST['str'][12]['value']/1.18,2,'.','');
            $b=number_format($_POST['str'][12]['value']-$a,2,'.','');
            $archivo = fopen("C:/Users/FERREBOOM/Dropbox/20601765641/20601765641-01-F002-".$num.".CAB", "w");
            fwrite($archivo, "0101|".date('Y-m-d', strtotime(str_replace('/', '-', $_POST['str'][5]['value'])))."|".date("h:i:s")."|-|000|6|".$_POST['str'][6]['value']."|".trim(addslashes($_POST['str'][7]['value']))."|PEN|".$b."|".$a."|".$_POST['str'][12]['value']."|0.00|0.00|0.00|".$_POST['str'][12]['value']."|2.1|2|");
            fclose($archivo);
            $archivo2 = fopen("C:/Users/FERREBOOM/Dropbox/20601765641/20601765641-01-F002-".$num.".TRI", "w");
            fwrite($archivo2, "1000|IGV|VAT|".$a."|".$b."|");
            fclose($archivo2);
        }
    break;
    case 'FACTURA BOOM':
        if ($_POST['serieventa']==0) {
            $res = mysqli_query($con,"SELECT MAX(serieventas)+1 FROM total_ventas WHERE documento='FACTURA BOOM'"); 
            $row = mysqli_fetch_row($res);
            $num="000000".$row[0];
            $num=substr($num,-7);
            for ($i=0; $i<sizeof($_POST['producto']) ; $i++) {
                $sql= mysqli_query($con,"INSERT INTO facturaboom (seriefactura,documento,id,compra,producto,cantidad,unitario,importe,especial,ruc,cliente,direccion,fecha,hora,vendedor,entregado) 
                    VALUES ('".$num."',
                            'FACTURA BOOM',
                            '".$_POST['id'][$i]."',
                            '".$_POST['compra'][$i]."',
                            '".$_POST['producto'][$i]."',
                            '".$_POST['cantidad'][$i]."',
                            '".$_POST['unitario'][$i]."',
                            '".$_POST['importe'][$i]."',
                            '".$_POST['promotor'][$i]."',
                            '".$_POST['str'][6]['value']."',
                            '".addslashes($_POST['str'][7]['value'])."',
                            '".addslashes($_POST['str'][8]['value'])."',
                            '".date('Y-m-d', strtotime(str_replace('/', '-', $_POST['str'][5]['value'])))."',
                            NOW(),
                            '".$_POST['str'][0]['value']."',
                            '".$_POST['str'][9]['value']."'
                            )");
            }
            $query= mysqli_query($con,"INSERT INTO total_ventas (fecha,hora,serieventas,documento,ruc,cliente,direccion,entregado,subtotal,devolucion,total,vendedor,comentario,credito,igv) 
                        VALUES ('".date('Y-m-d', strtotime(str_replace('/', '-', $_POST['str'][5]['value'])))."',
                                NOW(),
                                '".$num."',
                                'FACTURA BOOM',
                                '".$_POST['str'][6]['value']."',
                                '".addslashes($_POST['str'][7]['value'])."',
                                '".addslashes($_POST['str'][8]['value'])."',
                                'NO',
                                '".$_POST['str'][10]['value']."',
                                '".$_POST['str'][11]['value']."',
                                '".$_POST['str'][12]['value']."',
                                '".$_POST['str'][0]['value']."',
                                '".$_POST['str'][13]['value']."',
                                '".$_POST['str'][2]['value']."',
                                '1'
                                )");
        }
        else{
            $del = mysqli_query($con,"SELECT id,cantidad,entregado FROM facturaboom WHERE seriefactura='".$_POST['serieventa']."'"); 
            while($row = mysqli_fetch_assoc($del)){
                if($row['entregado']=='NO' ){
                    $ins=mysqli_query($con,"UPDATE producto SET stock_con1=(stock_con1+".$row['cantidad'].") WHERE id='".$row['id']."'");
                }
            }
            $del1 = mysqli_query($con,"DELETE FROM facturaboom WHERE seriefactura='".$_POST['serieventa']."'");
            $del2 = mysqli_query($con,"DELETE FROM total_ventas WHERE serieventas='".$_POST['serieventa']."' AND documento='FACTURA BOOM'");
            $num=$_POST['serieventa'];
            for ($i=0; $i<sizeof($_POST['producto']) ; $i++) {
                $sql= mysqli_query($con,"INSERT INTO facturaboom (seriefactura,documento,id,compra,producto,cantidad,unitario,importe,especial,ruc,cliente,direccion,fecha,hora,vendedor,entregado) 
                    VALUES ('".$num."',
                            'FACTURA BOOM',
                            '".$_POST['id'][$i]."',
                            '".$_POST['compra'][$i]."',
                            '".$_POST['producto'][$i]."',
                            '".$_POST['cantidad'][$i]."',
                            '".$_POST['unitario'][$i]."',
                            '".$_POST['importe'][$i]."',
                            '".$_POST['promotor'][$i]."',
                            '".$_POST['str'][6]['value']."',
                            '".addslashes($_POST['str'][7]['value'])."',
                            '".addslashes($_POST['str'][8]['value'])."',
                            '".date('Y-m-d', strtotime(str_replace('/', '-', $_POST['str'][5]['value'])))."',
                            NOW(),
                            '".$_POST['str'][0]['value']."',
                            '".$_POST['str'][9]['value']."'
                            )");
            }
            $query= mysqli_query($con,"INSERT INTO total_ventas (fecha,hora,serieventas,documento,ruc,cliente,direccion,entregado,subtotal,devolucion,total,vendedor,comentario,credito,igv) 
                        VALUES ('".date('Y-m-d', strtotime(str_replace('/', '-', $_POST['str'][5]['value'])))."',
                                NOW(),
                                '".$num."',
                                'FACTURA BOOM',
                                '".$_POST['str'][6]['value']."',
                                '".addslashes($_POST['str'][7]['value'])."',
                                '".addslashes($_POST['str'][8]['value'])."',
                                'NO',
                                '".$_POST['str'][10]['value']."',
                                '".$_POST['str'][11]['value']."',
                                '".$_POST['str'][12]['value']."',
                                '".$_POST['str'][0]['value']."',
                                '".$_POST['str'][13]['value']."',
                                '".$_POST['str'][2]['value']."',
                                '1'
                                )");
        }
    break;
    case 'FACTURA ELECTRONICA BOOM':
        if ($_POST['serieventa']==0) {
            $res = mysqli_query($con,"SELECT MAX(serieventas) FROM total_ventas WHERE documento='FACTURA ELECTRONICA BOOM'"); 
            $row = mysqli_fetch_row($res);
            $mm=$row[0]+1;
            $num="000000".$mm;
            $num=substr($num,-7);
            $archivo1 = fopen("C:/Users/FERREBOOM/Dropbox/20600996968/20600996968-01-F001-".$num.".DET", "w");
            for ($i=0; $i<sizeof($_POST['producto']) ; $i++) {
                $sql= mysqli_query($con,"INSERT INTO facturaelectronicaboom (seriefactura,documento,id,compra,producto,cantidad,unitario,importe,especial,ruc,cliente,direccion,fecha,hora,vendedor,entregado) 
                    VALUES ('".$num."',
                            'FACTURA ELECTRONICA BOOM',
                            '".$_POST['id'][$i]."',
                            '".$_POST['compra'][$i]."',
                            '".$_POST['producto'][$i]."',
                            '".$_POST['cantidad'][$i]."',
                            '".$_POST['unitario'][$i]."',
                            '".$_POST['importe'][$i]."',
                            '".$_POST['promotor'][$i]."',
                            '".$_POST['str'][6]['value']."',
                            '".addslashes($_POST['str'][7]['value'])."',
                            '".addslashes($_POST['str'][8]['value'])."',
                            '".date('Y-m-d', strtotime(str_replace('/', '-', $_POST['str'][5]['value'])))."',
                            NOW(),
                            '".$_POST['str'][0]['value']."',
                            '".$_POST['str'][9]['value']."'
                            )");
                $a1=number_format($_POST['unitario'][$i]/1.18,2,'.','');
                $b1=number_format($_POST['unitario'][$i]-$a1,2,'.','');
                $a11=number_format($_POST['importe'][$i]/1.18,2,'.','');
                $b11=number_format($_POST['importe'][$i]-$a11,2,'.','');
                $inse=mysqli_query($con,"UPDATE producto SET stock_con1=(stock_con1-".$_POST['cantidad'][$i].") WHERE id='".$_POST['id'][$i]."'");
                if($i>0){
                    fwrite($archivo1,PHP_EOL ."NIU|".$_POST['cantidad'][$i]."||-|".$_POST['producto'][$i]."|".$a1."|".$b11."|1000|".$b11."|".$a1*$_POST['cantidad'][$i]."|IGV|VAT|10|18|-|0|0|||-|0|-|0|0|||0|".$_POST['importe'][$i]."|".$a1*$_POST['cantidad'][$i]."|0|");
                }else{
                    fwrite($archivo1,"NIU|".$_POST['cantidad'][$i]."||-|".$_POST['producto'][$i]."|".$a1."|".$b11."|1000|".$b11."|".$a1*$_POST['cantidad'][$i]."|IGV|VAT|10|18|-|0|0|||-|0|-|0|0|||0|".$_POST['importe'][$i]."|".$a1*$_POST['cantidad'][$i]."|0|");
                }
                
            }
            fclose($archivo1);
            $query= mysqli_query($con,"INSERT INTO total_ventas (fecha,hora,serieventas,documento,ruc,cliente,direccion,entregado,subtotal,devolucion,total,vendedor,comentario,credito,igv) 
                        VALUES ('".date('Y-m-d', strtotime(str_replace('/', '-', $_POST['str'][5]['value'])))."',
                                NOW(),
                                '".$num."',
                                'FACTURA ELECTRONICA BOOM',
                                '".$_POST['str'][6]['value']."',
                                '".addslashes($_POST['str'][7]['value'])."',
                                '".addslashes($_POST['str'][8]['value'])."',
                                'NO',
                                '".$_POST['str'][10]['value']."',
                                '".$_POST['str'][11]['value']."',
                                '".$_POST['str'][12]['value']."',
                                '".$_POST['str'][0]['value']."',
                                '".$_POST['str'][13]['value']."',
                                '".$_POST['str'][2]['value']."',
                                '1'
                                )");
            $a=number_format($_POST['str'][12]['value']/1.18,2,'.','');
            $b=number_format($_POST['str'][12]['value']-$a,2,'.','');
            $archivo = fopen("C:/Users/FERREBOOM/Dropbox/20600996968/20600996968-01-F001-".$num.".CAB", "w");
            fwrite($archivo, "0101|".date('Y-m-d', strtotime(str_replace('/', '-', $_POST['str'][5]['value'])))."|".date("h:i:s")."|-|000|6|".$_POST['str'][6]['value']."|".trim(addslashes($_POST['str'][7]['value']))."|PEN|".$b."|".$a."|".$_POST['str'][12]['value']."|0.00|0.00|0.00|".$_POST['str'][12]['value']."|2.1|2|");
            fclose($archivo);
            $archivo2 = fopen("C:/Users/FERREBOOM/Dropbox/20600996968/20600996968-01-F001-".$num.".TRI", "w");
            fwrite($archivo2, "1000|IGV|VAT|".$a."|".$b."|");
            fclose($archivo2);
        }
        else{
            $del = mysqli_query($con,"SELECT id,cantidad,entregado FROM facturaelectronicaboom WHERE seriefactura='".$_POST['serieventa']."'"); 
            while($row = mysqli_fetch_assoc($del)){
                if($row['entregado']=='NO' ){
                    $ins=mysqli_query($con,"UPDATE producto SET stock_con1=(stock_con1+".$row['cantidad'].") WHERE id='".$row['id']."'");
                }
            }
            $del1 = mysqli_query($con,"DELETE FROM facturaelectronicaboom WHERE seriefactura='".$_POST['serieventa']."'");
            $del2 = mysqli_query($con,"DELETE FROM total_ventas WHERE serieventas='".$_POST['serieventa']."' AND documento='FACTURA ELECTRONICA BOOM'");
            $num=$_POST['serieventa'];
            $archivo1 = fopen("C:/Users/FERREBOOM/Dropbox/20600996968/20600996968-01-F001-".$num.".DET", "w");
            for ($i=0; $i<sizeof($_POST['producto']) ; $i++) {
                $sql= mysqli_query($con,"INSERT INTO facturaelectronicaboom (seriefactura,documento,id,compra,producto,cantidad,unitario,importe,especial,ruc,cliente,direccion,fecha,hora,vendedor,entregado) 
                    VALUES ('".$num."',
                            'FACTURA ELECTRONICA BOOM',
                            '".$_POST['id'][$i]."',
                            '".$_POST['compra'][$i]."',
                            '".$_POST['producto'][$i]."',
                            '".$_POST['cantidad'][$i]."',
                            '".$_POST['unitario'][$i]."',
                            '".$_POST['importe'][$i]."',
                            '".$_POST['promotor'][$i]."',
                            '".$_POST['str'][6]['value']."',
                            '".addslashes($_POST['str'][7]['value'])."',
                            '".addslashes($_POST['str'][8]['value'])."',
                            '".date('Y-m-d', strtotime(str_replace('/', '-', $_POST['str'][5]['value'])))."',
                            NOW(),
                            '".$_POST['str'][0]['value']."',
                            '".$_POST['str'][9]['value']."'
                            )");
                $a1=number_format($_POST['unitario'][$i]/1.18,2,'.','');
                $b1=number_format($_POST['unitario'][$i]-$a1,2,'.','');
                $a11=number_format($_POST['importe'][$i]/1.18,2,'.','');
                $b11=number_format($_POST['importe'][$i]-$a11,2,'.','');
                $inse=mysqli_query($con,"UPDATE producto SET stock_con1=(stock_con1-".$_POST['cantidad'][$i].") WHERE id='".$_POST['id'][$i]."'");
                if($i>0){
                    fwrite($archivo1,PHP_EOL ."NIU|".$_POST['cantidad'][$i]."||-|".$_POST['producto'][$i]."|".$a1."|".$b11."|1000|".$b11."|".$a1*$_POST['cantidad'][$i]."|IGV|VAT|10|18|-|0|0|||-|0|-|0|0|||0|".$_POST['importe'][$i]."|".$a1*$_POST['cantidad'][$i]."|0|");
                }else{
                    fwrite($archivo1,"NIU|".$_POST['cantidad'][$i]."||-|".$_POST['producto'][$i]."|".$a1."|".$b11."|1000|".$b11."|".$a1*$_POST['cantidad'][$i]."|IGV|VAT|10|18|-|0|0|||-|0|-|0|0|||0|".$_POST['importe'][$i]."|".$a1*$_POST['cantidad'][$i]."|0|");
                }
            }
            fclose($archivo1);
            $query= mysqli_query($con,"INSERT INTO total_ventas (fecha,hora,serieventas,documento,ruc,cliente,direccion,entregado,subtotal,devolucion,total,vendedor,comentario,credito,igv) 
                        VALUES ('".date('Y-m-d', strtotime(str_replace('/', '-', $_POST['str'][5]['value'])))."',
                                NOW(),
                                '".$num."',
                                'FACTURA ELECTRONICA BOOM',
                                '".$_POST['str'][6]['value']."',
                                '".addslashes($_POST['str'][7]['value'])."',
                                '".addslashes($_POST['str'][8]['value'])."',
                                'NO',
                                '".$_POST['str'][10]['value']."',
                                '".$_POST['str'][11]['value']."',
                                '".$_POST['str'][12]['value']."',
                                '".$_POST['str'][0]['value']."',
                                '".$_POST['str'][13]['value']."',
                                '".$_POST['str'][2]['value']."',
                                '1'
                                )");
            $a=number_format($_POST['str'][12]['value']/1.18,2,'.','');
            $b=number_format($_POST['str'][12]['value']-$a,2,'.','');
            $archivo = fopen("C:/Users/FERREBOOM/Dropbox/20600996968/20600996968-01-F001-".$num.".CAB", "w");
            fwrite($archivo, "0101|".date('Y-m-d', strtotime(str_replace('/', '-', $_POST['str'][5]['value'])))."|".date("h:i:s")."|-|000|6|".$_POST['str'][6]['value']."|".trim(addslashes($_POST['str'][7]['value']))."|PEN|".$b."|".$a."|".$_POST['str'][12]['value']."|0.00|0.00|0.00|".$_POST['str'][12]['value']."|2.1|2|");
            fclose($archivo);
            $archivo2 = fopen("C:/Users/FERREBOOM/Dropbox/20600996968/20600996968-01-F001-".$num.".TRI", "w");
            fwrite($archivo2, "1000|IGV|VAT|".$a."|".$b."|");
            fclose($archivo2);
        }
    break;




    case 'NOTA DE CREDITO BOOM':
        if ($_POST['serieventa']==0) {
            $res = mysqli_query($con,"SELECT MAX(serieventas) FROM total_ventas WHERE documento='NOTA DE CREDITO BOOM'"); 
            $row = mysqli_fetch_row($res);
            $mm=$row[0]+1;
            $num="000000".$mm;
            $num=substr($num,-7);
            $archivo1 = fopen("C:/Users/FERREBOOM/Dropbox/20600996968/20600996968-01-F001-".$num.".DET", "w");
            for ($i=0; $i<sizeof($_POST['producto']) ; $i++) {
                $sql= mysqli_query($con,"INSERT INTO notacredito (serienota,documento,id,compra,producto,cantidad,unitario,importe,especial,ruc,cliente,direccion,fecha,hora,vendedor,entregado) 
                    VALUES ('".$num."',
                            'NOTA DE CREDITO BOOM',
                            '".$_POST['id'][$i]."',
                            '".$_POST['compra'][$i]."',
                            '".$_POST['producto'][$i]."',
                            '".$_POST['cantidad'][$i]."',
                            '".$_POST['unitario'][$i]."',
                            '".$_POST['importe'][$i]."',
                            '".$_POST['promotor'][$i]."',
                            '".$_POST['str'][6]['value']."',
                            '".addslashes($_POST['str'][7]['value'])."',
                            '".addslashes($_POST['str'][8]['value'])."',
                            '".date('Y-m-d', strtotime(str_replace('/', '-', $_POST['str'][5]['value'])))."',
                            NOW(),
                            '".$_POST['str'][0]['value']."',
                            '".$_POST['str'][9]['value']."'
                            )");
                $a1=number_format($_POST['unitario'][$i]/1.18,2,'.','');
                $b1=number_format($_POST['unitario'][$i]-$a1,2,'.','');
                $a11=number_format($_POST['importe'][$i]/1.18,2,'.','');
                $b11=number_format($_POST['importe'][$i]-$a11,2,'.','');
                $inse=mysqli_query($con,"UPDATE producto SET stock_con1=(stock_con1-".$_POST['cantidad'][$i].") WHERE id='".$_POST['id'][$i]."'");
                if($i>0){
                    fwrite($archivo1,PHP_EOL ."NIU|".$_POST['cantidad'][$i]."||-|".$_POST['producto'][$i]."|".$a1."|".$b11."|1000|".$b11."|".$a1*$_POST['cantidad'][$i]."|IGV|VAT|10|18|-|0|0|||-|0|-|0|0|||0|".$_POST['importe'][$i]."|".$a1*$_POST['cantidad'][$i]."|0|");
                }else{
                    fwrite($archivo1,"NIU|".$_POST['cantidad'][$i]."||-|".$_POST['producto'][$i]."|".$a1."|".$b11."|1000|".$b11."|".$a1*$_POST['cantidad'][$i]."|IGV|VAT|10|18|-|0|0|||-|0|-|0|0|||0|".$_POST['importe'][$i]."|".$a1*$_POST['cantidad'][$i]."|0|");
                }
                
            }
            fclose($archivo1);
            $query= mysqli_query($con,"INSERT INTO total_ventas (fecha,hora,serieventas,documento,ruc,cliente,direccion,entregado,subtotal,devolucion,total,vendedor,comentario,credito,igv) 
                        VALUES ('".date('Y-m-d', strtotime(str_replace('/', '-', $_POST['str'][5]['value'])))."',
                                NOW(),
                                '".$num."',
                                'NOTA DE CREDITO BOOM',
                                '".$_POST['str'][6]['value']."',
                                '".addslashes($_POST['str'][7]['value'])."',
                                '".addslashes($_POST['str'][8]['value'])."',
                                'NO',
                                '".$_POST['str'][10]['value']."',
                                '".$_POST['str'][11]['value']."',
                                '".$_POST['str'][12]['value']."',
                                '".$_POST['str'][0]['value']."',
                                '".$_POST['str'][13]['value']."',
                                '".$_POST['str'][2]['value']."',
                                '1'
                                )");
            $a=number_format($_POST['str'][12]['value']/1.18,2,'.','');
            $b=number_format($_POST['str'][12]['value']-$a,2,'.','');
            $archivo = fopen("C:/Users/FERREBOOM/Dropbox/20600996968/20600996968-01-F001-".$num.".CAB", "w");
            fwrite($archivo, "0101|".date('Y-m-d', strtotime(str_replace('/', '-', $_POST['str'][5]['value'])))."|".date("h:i:s")."|-|000|6|".$_POST['str'][6]['value']."|".trim(addslashes($_POST['str'][7]['value']))."|PEN|".$b."|".$a."|".$_POST['str'][12]['value']."|0.00|0.00|0.00|".$_POST['str'][12]['value']."|2.1|2|");
            fclose($archivo);
            $archivo2 = fopen("C:/Users/FERREBOOM/Dropbox/20600996968/20600996968-01-F001-".$num.".TRI", "w");
            fwrite($archivo2, "1000|IGV|VAT|".$a."|".$b."|");
            fclose($archivo2);
        }
        else{
            $del = mysqli_query($con,"SELECT id,cantidad,entregado FROM notacredito WHERE serienota='".$_POST['serieventa']."'"); 
            while($row = mysqli_fetch_assoc($del)){
                if($row['entregado']=='NO' ){
                    $ins=mysqli_query($con,"UPDATE producto SET stock_con1=(stock_con1+".$row['cantidad'].") WHERE id='".$row['id']."'");
                }
            }
            $del1 = mysqli_query($con,"DELETE FROM notacredito WHERE serienota='".$_POST['serieventa']."'");
            $del2 = mysqli_query($con,"DELETE FROM total_ventas WHERE serieventas='".$_POST['serieventa']."' AND documento='NOTA DE CREDITO BOOM'");
            $num=$_POST['serieventa'];
            $archivo1 = fopen("C:/Users/FERREBOOM/Dropbox/20600996968/20600996968-01-F001-".$num.".DET", "w");
            for ($i=0; $i<sizeof($_POST['producto']) ; $i++) {
                $sql= mysqli_query($con,"INSERT INTO notacredito (serienota,documento,id,compra,producto,cantidad,unitario,importe,especial,ruc,cliente,direccion,fecha,hora,vendedor,entregado) 
                    VALUES ('".$num."',
                            'NOTA DE CREDITO BOOM',
                            '".$_POST['id'][$i]."',
                            '".$_POST['compra'][$i]."',
                            '".$_POST['producto'][$i]."',
                            '".$_POST['cantidad'][$i]."',
                            '".$_POST['unitario'][$i]."',
                            '".$_POST['importe'][$i]."',
                            '".$_POST['promotor'][$i]."',
                            '".$_POST['str'][6]['value']."',
                            '".addslashes($_POST['str'][7]['value'])."',
                            '".addslashes($_POST['str'][8]['value'])."',
                            '".date('Y-m-d', strtotime(str_replace('/', '-', $_POST['str'][5]['value'])))."',
                            NOW(),
                            '".$_POST['str'][0]['value']."',
                            '".$_POST['str'][9]['value']."'
                            )");
                $a1=number_format($_POST['unitario'][$i]/1.18,2,'.','');
                $b1=number_format($_POST['unitario'][$i]-$a1,2,'.','');
                $a11=number_format($_POST['importe'][$i]/1.18,2,'.','');
                $b11=number_format($_POST['importe'][$i]-$a11,2,'.','');
                $inse=mysqli_query($con,"UPDATE producto SET stock_con1=(stock_con1-".$_POST['cantidad'][$i].") WHERE id='".$_POST['id'][$i]."'");
                if($i>0){
                    fwrite($archivo1,PHP_EOL ."NIU|".$_POST['cantidad'][$i]."||-|".$_POST['producto'][$i]."|".$a1."|".$b11."|1000|".$b11."|".$a1*$_POST['cantidad'][$i]."|IGV|VAT|10|18|-|0|0|||-|0|-|0|0|||0|".$_POST['importe'][$i]."|".$a1*$_POST['cantidad'][$i]."|0|");
                }else{
                    fwrite($archivo1,"NIU|".$_POST['cantidad'][$i]."||-|".$_POST['producto'][$i]."|".$a1."|".$b11."|1000|".$b11."|".$a1*$_POST['cantidad'][$i]."|IGV|VAT|10|18|-|0|0|||-|0|-|0|0|||0|".$_POST['importe'][$i]."|".$a1*$_POST['cantidad'][$i]."|0|");
                }
            }
            fclose($archivo1);
            $query= mysqli_query($con,"INSERT INTO total_ventas (fecha,hora,serieventas,documento,ruc,cliente,direccion,entregado,subtotal,devolucion,total,vendedor,comentario,credito,igv) 
                        VALUES ('".date('Y-m-d', strtotime(str_replace('/', '-', $_POST['str'][5]['value'])))."',
                                NOW(),
                                '".$num."',
                                'NOTA DE CREDITO BOOM',
                                '".$_POST['str'][6]['value']."',
                                '".addslashes($_POST['str'][7]['value'])."',
                                '".addslashes($_POST['str'][8]['value'])."',
                                'NO',
                                '".$_POST['str'][10]['value']."',
                                '".$_POST['str'][11]['value']."',
                                '".$_POST['str'][12]['value']."',
                                '".$_POST['str'][0]['value']."',
                                '".$_POST['str'][13]['value']."',
                                '".$_POST['str'][2]['value']."',
                                '1'
                                )");
            $a=number_format($_POST['str'][12]['value']/1.18,2,'.','');
            $b=number_format($_POST['str'][12]['value']-$a,2,'.','');
            $archivo = fopen("C:/Users/FERREBOOM/Dropbox/20600996968/20600996968-01-F001-".$num.".CAB", "w");
            fwrite($archivo, "0101|".date('Y-m-d', strtotime(str_replace('/', '-', $_POST['str'][5]['value'])))."|".date("h:i:s")."|-|000|6|".$_POST['str'][6]['value']."|".trim(addslashes($_POST['str'][7]['value']))."|PEN|".$b."|".$a."|".$_POST['str'][12]['value']."|0.00|0.00|0.00|".$_POST['str'][12]['value']."|2.1|2|");
            fclose($archivo);
            $archivo2 = fopen("C:/Users/FERREBOOM/Dropbox/20600996968/20600996968-01-F001-".$num.".TRI", "w");
            fwrite($archivo2, "1000|IGV|VAT|".$a."|".$b."|");
            fclose($archivo2);
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
                                '".addslashes($_POST['str'][7]['value'])."',
                                '".addslashes($_POST['str'][8]['value'])."',
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
                                '".addslashes($_POST['str'][7]['value'])."',
                                '".addslashes($_POST['str'][8]['value'])."',
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
                                '".addslashes($_POST['str'][7]['value'])."',
                                '".addslashes($_POST['str'][8]['value'])."',
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
        }
        else{
            $sqla=mysqli_query($con,"SELECT total,credito,entregado,acuenta FROM total_ventas WHERE serieventas='".$_POST['serieventa']."' AND documento='NOTA DE PEDIDO'");
            $ro=mysqli_fetch_row($sqla);
            if($ro[1]=='CONTADO' && $ro[2]=='SI'){
              $inser=mysqli_query($con,"UPDATE dinerodiario SET nota=(nota-".$ro[0].") WHERE fecha='$hoy'");
            }
            $d = mysqli_query($con,"SELECT id,cantidad,entregado FROM notapedido WHERE serienota='".$_POST['serieventa']."'"); 
            while($row = mysqli_fetch_assoc($d)){
                if($row['entregado']=='SI' ){
                    $ins=mysqli_query($con,"UPDATE producto SET stock_real=(stock_real+".$row['cantidad'].") WHERE id='".$row['id']."'");
                }
            }
            $c = mysqli_query($con,"SELECT id,cantidad,entregado FROM devoluciones WHERE seriedevolucion='".$_POST['serieventa']."'"); 
            while($row = mysqli_fetch_assoc($c)){
                if($row['estado']=='BUENO' ){
                    $ins=mysqli_query($con,"UPDATE producto SET stock_real=(stock_real-".$row['cantidad'].") WHERE id='".$row['id']."'");
                }
            }
            $del = mysqli_query($con,"DELETE FROM notapedido WHERE serienota='".$_POST['serieventa']."'");
            $del1 = mysqli_query($con,"DELETE FROM devoluciones WHERE seriedevolucion='".$_POST['serieventa']."'");
            $del2 = mysqli_query($con,"DELETE FROM total_ventas WHERE serieventas='".$_POST['serieventa']."' AND documento='NOTA DE PEDIDO'");
            $num=$_POST['serieventa'];
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
                                '".addslashes($_POST['str'][7]['value'])."',
                                '".addslashes($_POST['str'][8]['value'])."',
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
                                '".addslashes($_POST['str'][7]['value'])."',
                                '".addslashes($_POST['str'][8]['value'])."',
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
                                '".addslashes($_POST['str'][7]['value'])."',
                                '".addslashes($_POST['str'][8]['value'])."',
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
        }
    break;




    case 'NOTA DE CREDITO':
        if ($_POST['serieventa']==0) {
            $res = mysqli_query($con,"SELECT MAX(serieventas)+1 FROM total_ventas WHERE documento='NOTA DE CREDITO'"); 
            $row = mysqli_fetch_row($res);
            $num="000000".$row[0];
            $num=substr($num,-7);
            if(isset($_POST['producto']) && !empty($_POST['producto'])){
                for ($i=0; $i<sizeof($_POST['producto']) ; $i++) {
                    $sql= mysqli_query($con,"INSERT INTO notacredito (serienota,documento,id,compra,producto,cantidad,unitario,importe,especial,ruc,cliente,direccion,fecha,hora,vendedor,entregado,tiponotacredito) 
                        VALUES ('".$num."',
                                'NOTA DE CREDITO',
                                '".$_POST['id'][$i]."',
                                '".$_POST['compra'][$i]."',
                                '".$_POST['producto'][$i]."',
                                '".$_POST['cantidad'][$i]."',
                                '".$_POST['unitario'][$i]."',
                                '".$_POST['importe'][$i]."',
                                '".$_POST['promotor'][$i]."',
                                '".$_POST['str'][6]['value']."',
                                '".addslashes($_POST['str'][7]['value'])."',
                                '".addslashes($_POST['str'][8]['value'])."',
                                '".$hoy."',
                                NOW(),
                                '".$_POST['str'][0]['value']."',
                                '".$_POST['str'][9]['value']."',
                                '".$_POST['str'][14]['value']."'
                                )");
                    $inse=mysqli_query($con,"UPDATE producto SET stock_real=(stock_real-".$_POST['cantidad'][$i].") WHERE id='".$_POST['id'][$i]."'");
                }
            }
            $resta=$_POST['str'][12]['value']-$_POST['str'][4]['value'];
            $query= mysqli_query($con,"INSERT INTO total_ventas (fecha,hora,serieventas,documento,ruc,cliente,direccion,entregado,subtotal,devolucion,total,vendedor,comentario,credito,acuenta,fechapago,pendiente) 
                        VALUES ('".$hoy."',
                                NOW(),
                                '".$num."',
                                'NOTA DE CREDITO',
                                '".$_POST['str'][6]['value']."',
                                '".addslashes($_POST['str'][7]['value'])."',
                                '".addslashes($_POST['str'][8]['value'])."',
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
        }
        else{
            $sqla=mysqli_query($con,"SELECT total,credito,entregado,acuenta FROM total_ventas WHERE serieventas='".$_POST['serieventa']."' AND documento='NOTA DE CREDITO'");
            $ro=mysqli_fetch_row($sqla);
            if($ro[1]=='CONTADO' && $ro[2]=='SI'){
              $inser=mysqli_query($con,"UPDATE dinerodiario SET nota=(nota-".$ro[0].") WHERE fecha='$hoy'");
            }
            $d = mysqli_query($con,"SELECT id,cantidad,entregado FROM notacredito WHERE serienota='".$_POST['serieventa']."'"); 
            while($row = mysqli_fetch_assoc($d)){
                if($row['entregado']=='SI' ){
                    $ins=mysqli_query($con,"UPDATE producto SET stock_real=(stock_real+".$row['cantidad'].") WHERE id='".$row['id']."'");
                }
            }
            $del = mysqli_query($con,"DELETE FROM notapedido WHERE serienota='".$_POST['serieventa']."'");
            $del2 = mysqli_query($con,"DELETE FROM total_ventas WHERE serieventas='".$_POST['serieventa']."' AND documento='NOTA DE CREDITO'");
            $num=$_POST['serieventa'];
            $hoy=date('Y-m-d', strtotime(str_replace('/', '-', $_POST['str'][5]['value'])));
            if(isset($_POST['producto']) && !empty($_POST['producto'])){
                for ($i=0; $i<sizeof($_POST['producto']) ; $i++) {
                    $sql= mysqli_query($con,"INSERT INTO notacredito (serienota,documento,id,compra,producto,cantidad,unitario,importe,especial,ruc,cliente,direccion,fecha,hora,vendedor,entregado,tiponotacredito) 
                        VALUES ('".$num."',
                                'NOTA DE CREDITO',
                                '".$_POST['id'][$i]."',
                                '".$_POST['compra'][$i]."',
                                '".$_POST['producto'][$i]."',
                                '".$_POST['cantidad'][$i]."',
                                '".$_POST['unitario'][$i]."',
                                '".$_POST['importe'][$i]."',
                                '".$_POST['promotor'][$i]."',
                                '".$_POST['str'][6]['value']."',
                                '".addslashes($_POST['str'][7]['value'])."',
                                '".addslashes($_POST['str'][8]['value'])."',
                                '".$hoy."',
                                NOW(),
                                '".$_POST['str'][0]['value']."',
                                '".$_POST['str'][9]['value']."',
                                '".$_POST['str'][14]['value']."'
                                )");
                    $inse=mysqli_query($con,"UPDATE producto SET stock_real=(stock_real-".$_POST['cantidad'][$i].") WHERE id='".$_POST['id'][$i]."'");
                }
            }
            $resta=$_POST['str'][12]['value']-$_POST['str'][4]['value'];
            $query= mysqli_query($con,"INSERT INTO total_ventas (fecha,hora,serieventas,documento,ruc,cliente,direccion,entregado,subtotal,devolucion,total,vendedor,comentario,credito,acuenta,fechapago,pendiente) 
                        VALUES ('".$hoy."',
                                NOW(),
                                '".$num."',
                                'NOTA DE CREDITO',
                                '".$_POST['str'][6]['value']."',
                                '".addslashes($_POST['str'][7]['value'])."',
                                '".addslashes($_POST['str'][8]['value'])."',
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
                            '".addslashes($_POST['str'][7]['value'])."',
                            '".addslashes($_POST['str'][8]['value'])."',
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
                                '".addslashes($_POST['str'][7]['value'])."',
                                '".addslashes($_POST['str'][8]['value'])."',
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
                            '".addslashes($_POST['str'][7]['value'])."',
                            '".addslashes($_POST['str'][8]['value'])."',
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
                                '".addslashes($_POST['str'][7]['value'])."',
                                '".addslashes($_POST['str'][8]['value'])."',
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
                            '".addslashes($_POST['str'][7]['value'])."',
                            '".addslashes($_POST['str'][8]['value'])."',
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
                                '".addslashes($_POST['str'][7]['value'])."',
                                '".addslashes($_POST['str'][8]['value'])."',
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
                            '".addslashes($_POST['str'][7]['value'])."',
                            '".addslashes($_POST['str'][8]['value'])."',
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
                                '".addslashes($_POST['str'][7]['value'])."',
                                '".addslashes($_POST['str'][8]['value'])."',
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