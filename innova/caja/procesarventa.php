<?php
    require_once('../connection.php');
    $hoy=date("Y-m-d");
    $hoy1=$hoy;
    if($_POST['str'][6]['value'] !='' AND addslashes($_POST['str'][7]['value'])!=''){
        $cons=mysqli_query($con,"SELECT * FROM cliente WHERE ruc='".$_POST['str'][6]['value']."' AND cliente='".addslashes($_POST['str'][7]['value'])."'");
        if(mysqli_num_rows($cons)==0){
            $cliente= mysqli_query($con,"INSERT INTO cliente (ruc,cliente,direccion,tipo,activo) 
                VALUES ('".$_POST['str'][6]['value']."',
                        '".addslashes($_POST['str'][7]['value'])."',
                        '".addslashes($_POST['str'][8]['value'])."',
                        'UNIDAD',
                        'SI')");
        }
    }
    if($_POST['seriepedido']!=0){
        $consulta=mysqli_query($con,"UPDATE total_pedido SET entregado='SI' WHERE seriepedido='".$_POST['seriepedido']."'");
    }
    $aa="";
    $bb="";
    if($_SESSION['mysql']=="innovaelectric"){
      $aa="20601765641";
      $bb="001";
    }else if($_SESSION['mysql']=="innovaprincipal"){
      $aa="20487211410";
      $bb="001";
    }else if($_SESSION['mysql']=="prolongacionhuanuco"){
      $aa="10433690058";
      $bb="002";
    }else if($_SESSION['mysql']=="jauja"){
      $aa="20603695055";
      $bb="001"; 
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
        }
	break;
    case 'BOLETA ELECTRONICA':
        if ($_POST['serieventa']==0) {
            $res = mysqli_query($con,"SELECT MAX(serieventas) FROM total_ventas WHERE documento='BOLETA ELECTRONICA'"); 
            $row = mysqli_fetch_row($res);
            $mm=$row[0]+1;
            $num="000000".$mm;
            $num=substr($num,-7);
            if($aa!=""){$archivo1 = fopen("C:/Users/FERREBOOM/Dropbox/".$aa."/".$aa."-03-B".$bb."-".$num.".DET", "w");}
            for ($i=0; $i<sizeof($_POST['producto']) ; $i++) {
                $sql= mysqli_query($con,"INSERT INTO boletaelectronica (serieboleta,documento,id,compra,producto,cantidad,unitario,importe,especial,ruc,cliente,direccion,fecha,hora,vendedor,entregado) 
                    VALUES ('".$num."',
                            'BOLETA ELECTRONICA',
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
                if($aa!=""){
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
            }
            if($aa!=""){fclose($archivo1);}
            $query= mysqli_query($con,"INSERT INTO total_ventas (fecha,hora,serieventas,documento,ruc,cliente,direccion,entregado,subtotal,devolucion,total,vendedor,comentario,credito) 
                        VALUES (NOW(),
                                NOW(),
                                '".$num."',
                                'BOLETA ELECTRONICA',
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
            if($aa!=""){
                $a=number_format($_POST['str'][12]['value']/1.18,2,'.','');
                $b=number_format($_POST['str'][12]['value']-$a,2,'.','');
                $archivo = fopen("C:/Users/FERREBOOM/Dropbox/".$aa."/".$aa."-03-B".$bb."-".$num.".CAB", "w");
                fwrite($archivo, "0101|".date('Y-m-d', strtotime(str_replace('/', '-', $_POST['str'][5]['value'])))."|".date("h:i:s")."|-|000|1|0|".trim(addslashes($_POST['str'][7]['value']))."|PEN|".$b."|".$a."|".$_POST['str'][12]['value']."|0.00|0.00|0.00|".$_POST['str'][12]['value']."|2.1|2|");
                fclose($archivo);
                $archivo2 = fopen("C:/Users/FERREBOOM/Dropbox/".$aa."/".$aa."-03-B".$bb."-".$num.".TRI", "w");
                fwrite($archivo2, "1000|IGV|VAT|".$a."|".$b."|");
                fclose($archivo2);
            }
        }else{
            $sqla=mysqli_query($con,"SELECT total,entregado,hora FROM total_ventas WHERE serieventas='".$_POST['serieventa']."' AND documento='BOLETA ELECTRONICA'");
            $del = mysqli_query($con,"SELECT id,cantidad FROM boletaelectronica WHERE serieboleta='".$_POST['serieventa']."'"); 
            $ro=mysqli_fetch_row($sqla);
            if($ro[1]=='SI'){
                while($row = mysqli_fetch_assoc($del)){
                    $ins=mysqli_query($con,"UPDATE producto SET stock_real=(stock_real+".$row['cantidad'].") WHERE id='".$row['id']."'");
                }
            }
            $del1 = mysqli_query($con,"DELETE FROM boletaelectronica WHERE serieboleta='".$_POST['serieventa']."'");
            $del2 = mysqli_query($con,"DELETE FROM total_ventas WHERE serieventas='".$_POST['serieventa']."' AND documento='BOLETA ELECTRONICA'");
            $num=$_POST['serieventa'];
            if($aa!=""){$archivo1 = fopen("C:/Users/FERREBOOM/Dropbox/".$aa."/".$aa."-03-B".$bb."-".$num.".DET", "w");}
            for ($i=0; $i<sizeof($_POST['producto']) ; $i++) {
                $sql= mysqli_query($con,"INSERT INTO boletaelectronica (serieboleta,documento,id,compra,producto,cantidad,unitario,importe,especial,ruc,cliente,direccion,fecha,hora,vendedor,entregado) 
                    VALUES ('".$num."',
                            'BOLETA ELECTRONICA',
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
                if($aa!=""){
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
            }
            if($aa!=""){fclose($archivo1);}
            $query= mysqli_query($con,"INSERT INTO total_ventas (fecha,hora,serieventas,documento,ruc,cliente,direccion,entregado,subtotal,devolucion,total,vendedor,comentario,credito) 
                        VALUES (NOW(),
                                NOW(),
                                '".$num."',
                                'BOLETA ELECTRONICA',
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
            if($aa!=""){
                $a=number_format($_POST['str'][12]['value']/1.18,2,'.','');
                $b=number_format($_POST['str'][12]['value']-$a,2,'.','');
                $archivo = fopen("C:/Users/FERREBOOM/Dropbox/".$aa."/".$aa."-03-B".$bb."-".$num.".CAB", "w");
                fwrite($archivo, "0101|".date('Y-m-d', strtotime(str_replace('/', '-', $_POST['str'][5]['value'])))."|".$ro[2]."|-|000|1|0|".trim(addslashes($_POST['str'][7]['value']))."|PEN|".$b."|".$a."|".$_POST['str'][12]['value']."|0.00|0.00|0.00|".$_POST['str'][12]['value']."|2.1|2|");
                fclose($archivo);
                $archivo2 = fopen("C:/Users/FERREBOOM/Dropbox/".$aa."/".$aa."-03-B".$bb."-".$num.".TRI", "w");
                fwrite($archivo2, "1000|IGV|VAT|".$a."|".$b."|");
                fclose($archivo2);
            }
        }
    break;
    case 'FACTURA ELECTRONICA':
        if ($_POST['serieventa']==0) {
            $res = mysqli_query($con,"SELECT MAX(serieventas) FROM total_ventas WHERE documento='FACTURA ELECTRONICA'"); 
            $row = mysqli_fetch_row($res);
            $mm=$row[0]+1;
            $num="000000".$mm;
            $num=substr($num,-7);
            if($aa!=""){$archivo1 = fopen("C:/Users/FERREBOOM/Dropbox/".$aa."/".$aa."-01-F".$bb."-".$num.".DET", "w");}
            for ($i=0; $i<sizeof($_POST['producto']) ; $i++) {
                $sql= mysqli_query($con,"INSERT INTO facturaelectronica (seriefactura,documento,id,compra,producto,cantidad,unitario,importe,especial,ruc,cliente,direccion,fecha,hora,vendedor,entregado) 
                    VALUES ('".$num."',
                            'FACTURA ELECTRONICA',
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
                if($aa!=""){
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
            }
            if($aa!=""){fclose($archivo1);}
            $query= mysqli_query($con,"INSERT INTO total_ventas (fecha,hora,serieventas,documento,ruc,cliente,direccion,entregado,subtotal,devolucion,total,vendedor,comentario,credito,igv) 
                        VALUES ('".date('Y-m-d', strtotime(str_replace('/', '-', $_POST['str'][5]['value'])))."',
                                NOW(),
                                '".$num."',
                                'FACTURA ELECTRONICA',
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
            if($aa!=""){
                $a=number_format($_POST['str'][12]['value']/1.18,2,'.','');
                $b=number_format($_POST['str'][12]['value']-$a,2,'.','');
                $archivo = fopen("C:/Users/FERREBOOM/Dropbox/".$aa."/".$aa."-01-F".$bb."-".$num.".CAB", "w");
                fwrite($archivo, "0101|".date('Y-m-d', strtotime(str_replace('/', '-', $_POST['str'][5]['value'])))."|".date("h:i:s")."|-|000|6|".$_POST['str'][6]['value']."|".trim(addslashes($_POST['str'][7]['value']))."|PEN|".$b."|".$a."|".$_POST['str'][12]['value']."|0.00|0.00|0.00|".$_POST['str'][12]['value']."|2.1|2|");
                fclose($archivo);
                $archivo2 = fopen("C:/Users/FERREBOOM/Dropbox/".$aa."/".$aa."-01-F".$bb."-".$num.".TRI", "w");
                fwrite($archivo2, "1000|IGV|VAT|".$a."|".$b."|");
                fclose($archivo2);
            }
        }
        else{
            $del = mysqli_query($con,"SELECT id,cantidad,entregado FROM facturaelectronica WHERE seriefactura='".$_POST['serieventa']."'"); 
            while($row = mysqli_fetch_assoc($del)){
                if($row['entregado']=='NO' ){
                    $ins=mysqli_query($con,"UPDATE producto SET stock_con=(stock_con+".$row['cantidad'].") WHERE id='".$row['id']."'");
                }
            }
            $del1 = mysqli_query($con,"DELETE FROM facturaelectronica WHERE seriefactura='".$_POST['serieventa']."'");
            $del2 = mysqli_query($con,"DELETE FROM total_ventas WHERE serieventas='".$_POST['serieventa']."' AND documento='FACTURA ELECTRONICA'");
            $num=$_POST['serieventa'];
            if($aa!=""){$archivo1 = fopen("C:/Users/FERREBOOM/Dropbox/".$aa."/".$aa."-01-F".$bb."-".$num.".DET", "w");}
            for ($i=0; $i<sizeof($_POST['producto']) ; $i++) {
                $sql= mysqli_query($con,"INSERT INTO facturaelectronica (seriefactura,documento,id,compra,producto,cantidad,unitario,importe,especial,ruc,cliente,direccion,fecha,hora,vendedor,entregado) 
                    VALUES ('".$num."',
                            'FACTURA ELECTRONICA',
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
                if($aa!=""){
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
            }
            if($aa!=""){fclose($archivo1);}
            $query= mysqli_query($con,"INSERT INTO total_ventas (fecha,hora,serieventas,documento,ruc,cliente,direccion,entregado,subtotal,devolucion,total,vendedor,comentario,credito,igv) 
                        VALUES ('".date('Y-m-d', strtotime(str_replace('/', '-', $_POST['str'][5]['value'])))."',
                                NOW(),
                                '".$num."',
                                'FACTURA ELECTRONICA',
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
            if($aa!=""){
                $a=number_format($_POST['str'][12]['value']/1.18,2,'.','');
                $b=number_format($_POST['str'][12]['value']-$a,2,'.','');
                $archivo = fopen("C:/Users/FERREBOOM/Dropbox/".$aa."/".$aa."-01-F".$bb."-".$num.".CAB", "w");
                fwrite($archivo, "0101|".date('Y-m-d', strtotime(str_replace('/', '-', $_POST['str'][5]['value'])))."|".date("h:i:s")."|-|000|6|".$_POST['str'][6]['value']."|".trim(addslashes($_POST['str'][7]['value']))."|PEN|".$b."|".$a."|".$_POST['str'][12]['value']."|0.00|0.00|0.00|".$_POST['str'][12]['value']."|2.1|2|");
                fclose($archivo);
                $archivo2 = fopen("C:/Users/FERREBOOM/Dropbox/".$aa."/".$aa."-01-F".$bb."-".$num.".TRI", "w");
                fwrite($archivo2, "1000|IGV|VAT|".$a."|".$b."|");
                fclose($archivo2);
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
                            '".addslashes($_POST['str'][7]['value'])."',
                            '".addslashes($_POST['str'][8]['value'])."',
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
            $del = mysqli_query($con,"SELECT id,cantidad,entregado FROM factura WHERE seriefactura='".$_POST['serieventa']."'"); 
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
                            '".addslashes($_POST['str'][7]['value'])."',
                            '".addslashes($_POST['str'][8]['value'])."',
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
    case 'PROFORMA':
        if ($_POST['serieventa']==0) {
            $res = mysqli_query($con,"SELECT MAX(serieventas)+1 FROM total_ventas WHERE documento='PROFORMA'"); 
            $row = mysqli_fetch_row($res);
            $num="000000".$row[0];
            $num=substr($num,-7);
            for ($i=0; $i<sizeof($_POST['producto']) ; $i++) {
                $sql= mysqli_query($con,"INSERT INTO proforma (serieproforma,documento,id,compra,producto,cantidad,unitario,importe,especial,ruc,cliente,direccion,fecha,hora,vendedor,entregado) 
                    VALUES ('".$num."',
                            'PROFORMA',
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
                                'PROFORMA',
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
                $inser=mysqli_query($con,"UPDATE dinerodiario SET proforma=(proforma+".$_POST['str'][12]['value'].") WHERE fecha='$hoy'");
            }
        }
        else{
            $sqla=mysqli_query($con,"SELECT total,entregado FROM total_ventas WHERE serieventas='".$_POST['serieventa']."' AND documento='PROFORMA'");
            $del = mysqli_query($con,"SELECT id,cantidad FROM proforma WHERE serieproforma='".$_POST['serieventa']."'"); 
            $ro=mysqli_fetch_row($sqla);
            if($ro[1]=='SI'){
                $inser=mysqli_query($con,"UPDATE dinerodiario SET proforma=(proforma-".$ro[0].") WHERE fecha='$hoy'");
                while($row = mysqli_fetch_assoc($del)){
                    $ins=mysqli_query($con,"UPDATE producto SET stock_real=(stock_real+".$row['cantidad'].") WHERE id='".$row['id']."'");
                }
            }
            $del1 = mysqli_query($con,"DELETE FROM proforma WHERE serieproforma='".$_POST['serieventa']."'");
            $del2 = mysqli_query($con,"DELETE FROM total_ventas WHERE serieventas='".$_POST['serieventa']."' AND documento='PROFORMA'");
            $num=$_POST['serieventa'];
            for ($i=0; $i<sizeof($_POST['producto']) ; $i++) {
                $sql= mysqli_query($con,"INSERT INTO proforma (serieproforma,documento,id,compra,producto,cantidad,unitario,importe,especial,ruc,cliente,direccion,fecha,hora,vendedor,entregado) 
                    VALUES ('".$num."',
                            'PROFORMA',
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
                                'PROFORMA',
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
                $inser=mysqli_query($con,"UPDATE dinerodiario SET proforma=(proforma+".$_POST['str'][12]['value'].") WHERE fecha='$hoy'");
            }
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
            if($_POST['str'][2]['value']=='CONTADO'){
                $inser=mysqli_query($con,"UPDATE dinerodiario SET nota=(nota+".$_POST['str'][12]['value'].") WHERE fecha='$hoy'");
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
            if($_POST['str'][4]['value']!=0 && $hoy1==date('Y-m-d', strtotime(str_replace('/', '-', $_POST['str'][5]['value'])))){
                $que=mysqli_query($con,"INSERT INTO adelantos (serie,adelanto,encargado,fecha,forma,cliente,sesion) 
                    VALUES ('".$num."',
                            '".$_POST['str'][4]['value']."',
                            '".$_POST['str'][0]['value']."',
                            NOW(),
                            'EFECTIVO',
                            '".addslashes($_POST['str'][7]['value'])."',
                            'CAJERO'
                        )");
                $insertt=mysqli_query($con,"UPDATE dinerodiario SET creditos=(creditos+".$_POST['str'][4]['value'].") WHERE fecha='".$hoy."'");
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
                if($row['entregado']=='SI' ){
                    $ins=mysqli_query($con,"UPDATE producto SET stock_real=(stock_real-".$row['cantidad'].") WHERE id='".$row['id']."'");
                }
            }
            $del = mysqli_query($con,"DELETE FROM notapedido WHERE serienota='".$_POST['serieventa']."'");
            $del1 = mysqli_query($con,"DELETE FROM devoluciones WHERE seriedevolucion='".$_POST['serieventa']."'");
            $del2 = mysqli_query($con,"DELETE FROM total_ventas WHERE serieventas='".$_POST['serieventa']."' AND documento='NOTA DE PEDIDO'");
            $num=$_POST['serieventa'];
            if($ro[3]>0 && $hoy==date('Y-m-d', strtotime(str_replace('/', '-', $_POST['str'][5]['value'])))){
                $quee=mysqli_query($con,"DELETE FROM adelantos WHERE serie='".$_POST['serieventa']."'");
                $inserttt=mysqli_query($con,"UPDATE dinerodiario SET creditos=(creditos-".$ro[3].") WHERE fecha='$hoy'");
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
            if($_POST['str'][2]['value']=='CONTADO'){
                $inser=mysqli_query($con,"UPDATE dinerodiario SET nota=(nota+".$_POST['str'][12]['value'].") WHERE fecha='$hoy'");
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
            if($_POST['str'][4]['value']!=0 && $hoy1==date('Y-m-d', strtotime(str_replace('/', '-', $_POST['str'][5]['value'])))){
                $que=mysqli_query($con,"INSERT INTO adelantos (serie,adelanto,encargado,fecha,forma,cliente,sesion) 
                    VALUES ('".$num."',
                            '".$_POST['str'][4]['value']."',
                            '".$_POST['str'][0]['value']."',
                            NOW(),
                            'EFECTIVO',
                            '".addslashes($_POST['str'][7]['value'])."',
                            'CAJERO'
                        )");
                $insertt=mysqli_query($con,"UPDATE dinerodiario SET creditos=(creditos+".$_POST['str'][4]['value'].") WHERE fecha='".$hoy."'");
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