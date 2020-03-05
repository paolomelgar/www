<?php
  require_once('../connection.php');
  date_default_timezone_set("America/Lima");
  $hoy=date("Y-m-d");
  if($_POST['str'][7]['value'] !='' AND $_POST['str'][10]['value']!=''){
        $cons=mysqli_query($con,"SELECT * FROM proveedor WHERE ruc='".$_POST['str'][7]['value']."' AND proveedor='".$_POST['str'][10]['value']."'");
        if(mysqli_num_rows($cons)==0){
            $cliente= mysqli_query($con,"INSERT INTO proveedor (ruc,proveedor,direccion,activo) 
                VALUES ('".$_POST['str'][7]['value']."',
                        '".$_POST['str'][10]['value']."',
                        '".$_POST['str'][11]['value']."',
                        'SI')");
        }
    }
  if(isset($_POST) && !empty($_POST)){
	switch ($_POST['str'][1]['value']) {
    case 'FACTURA INNOVA':
        if ($_POST['editar']==0) {
            $res = mysqli_query($con,"SELECT MAX(value) FROM total_compras"); 
            $row = mysqli_fetch_row($res);
            $num = $row[0]+1;
            $acuenta=0;
        }
        else{
            $sqla=mysqli_query($con,"SELECT montototal,entregado,billete,cambio,credito,acuenta FROM total_compras WHERE value='".$_POST['editar']."'");
            $ro=mysqli_fetch_row($sqla);
            if($ro[1]=='SI' && $ro[4]=='CONTADO'){
                if($ro[2]=='SOLES'){
                    $am=$ro[0];
                    $inser5=mysqli_query($con,"UPDATE cajamayor SET contados=(contados-round($am,1)) WHERE fecha='$hoy'");
                }
                else{
                    $am=$ro[0]*$ro[3];
                    $inser5=mysqli_query($con,"UPDATE cajamayor SET contados=(contados-round($am,1)) WHERE fecha='$hoy'");
                }
            }
            $del = mysqli_query($con,"SELECT idproducto,cantidad,entregado FROM compras WHERE value='".$_POST['editar']."'"); 
            while($row = mysqli_fetch_assoc($del)){
                if($row['entregado']=='SI' ){
                    $ins=mysqli_query($con,"UPDATE producto SET stock_real=(stock_real-".$row['cantidad']."),stock_con=(stock_con-".$row['cantidad'].") WHERE id='".$row['idproducto']."'");
                }else{
                    $ins=mysqli_query($con,"UPDATE producto SET stock_con=(stock_con-".$row['cantidad'].") WHERE id='".$row['idproducto']."'");
                }
            }
            $del1 = mysqli_query($con,"DELETE FROM compras WHERE value='".$_POST['editar']."'");
            $del2 = mysqli_query($con,"DELETE FROM total_compras WHERE value='".$_POST['editar']."'");
            $num=$_POST['editar'];
            $acuenta=$ro[5];
        }
        if(isset($_POST['producto']) && !empty($_POST['producto'])){
            for ($i=0; $i<sizeof($_POST['producto']) ; $i++) {
                $sql= mysqli_query($con,"INSERT INTO compras (serie,numero,value,documento,producto,cantidad,unitario,importe,idproducto,billete,cambio,proveedor,fecha,hora,entregado,usuario) 
                    VALUES ('".$_POST['str'][2]['value']."',
                            '".$_POST['str'][3]['value']."',
                            '".$num."',
                            'FACTURA INNOVA',
                            '".$_POST['producto'][$i]."',
                            '".$_POST['cantidad'][$i]."',
                            '".$_POST['unitario'][$i]."',
                            '".$_POST['importe'][$i]."',
                            '".$_POST['id'][$i]."',
                            '".$_POST['str'][8]['value']."',
                            '".$_POST['str'][9]['value']."',
                            '".$_POST['str'][10]['value']."',
                            '".date('Y-m-d', strtotime(str_replace('/', '-', $_POST['str'][6]['value'])))."',
                            NOW(),
                            '".$_POST['str'][12]['value']."',
                            '".$_POST['str'][0]['value']."'
                            )");
                if($_POST['str'][12]['value']=='SI'){
                    if($_POST['str'][8]['value']=='SOLES'){
                        $inse=mysqli_query($con,"UPDATE producto SET stock_real=(stock_real+".$_POST['cantidad'][$i]."),stock_con=(stock_con+".$_POST['cantidad'][$i]."),p_compra=(".$_POST['unitario'][$i]."),activo='SI',antiguedad=NOW() WHERE id='".$_POST['id'][$i]."'");
                    }
                    else{
                        $inse=mysqli_query($con,"UPDATE producto SET stock_real=(stock_real+".$_POST['cantidad'][$i]."),stock_con=(stock_con+".$_POST['cantidad'][$i]."),p_compra=(".$_POST['unitario'][$i]*$_POST['str'][9]['value']."),activo='SI',antiguedad=NOW() WHERE id='".$_POST['id'][$i]."'");
                    }
                }
                else{
                    $inse=mysqli_query($con,"UPDATE producto SET stock_con=(stock_con+".$_POST['cantidad'][$i].") WHERE id='".$_POST['id'][$i]."'");
                }
            }
        }
        $pendiente=$_POST['str'][14]['value']-$acuenta;
        $query= mysqli_query($con,"INSERT INTO total_compras (serie,numero,value,fechafactura,hora,documento,ruc,proveedor,direccion,entregado,subtotal,igv,total,percepcion,montototal,comentario,credito,fechapago,fechaingreso,billete,cambio,pendiente,acuenta,letra,usuario) 
                    VALUES ('".$_POST['str'][2]['value']."',
                            '".$_POST['str'][3]['value']."',
                            '".$num."',
                            '".date('Y-m-d', strtotime(str_replace('/', '-', $_POST['str'][6]['value'])))."',
                            NOW(),
                            'FACTURA INNOVA',
                            '".$_POST['str'][7]['value']."',
                            '".$_POST['str'][10]['value']."',
                            '".$_POST['str'][11]['value']."',
                            '".$_POST['str'][12]['value']."',
                            '0.00',
                            '0.00',
                            '".$_POST['str'][13]['value']."',
                            '".$_POST['str'][14]['value']."',
                            '".$_POST['str'][15]['value']."',
                            '".$_POST['str'][16]['value']."',
                            '".$_POST['str'][4]['value']."',
                            '".date('Y-m-d', strtotime(str_replace('/', '-', $_POST['str'][5]['value'])))."',
                            NOW(),
                            '".$_POST['str'][8]['value']."',
                            '".$_POST['str'][9]['value']."',
                            '".$pendiente."',
                            '".$acuenta."',
                            'NO',
                            '".$_POST['str'][0]['value']."'
                            )");
        if($_POST['str'][12]['value']=='SI' && $_POST['str'][4]['value']=='CONTADO'){
            if($_POST['str'][8]['value']=='SOLES'){
                $am=$_POST['str'][15]['value'];
                $inser=mysqli_query($con,"UPDATE cajamayor SET contados=(contados+round($am,1)) WHERE fecha='$hoy'");
            }
            else{
                $am=$_POST['str'][15]['value']*$_POST['str'][9]['value'];
                $inser=mysqli_query($con,"UPDATE cajamayor SET contados=(contados+round($am,1)) WHERE fecha='$hoy'");
            }
        }
    break;
    case 'FACTURA BOOM':
        if ($_POST['editar']==0) {
            $res = mysqli_query($con,"SELECT MAX(value) FROM total_compras"); 
            $row = mysqli_fetch_row($res);
            $num = $row[0]+1;
            $acuenta=0;
        }
        else{
            $sqla=mysqli_query($con,"SELECT montototal,entregado,billete,cambio,credito,acuenta FROM total_compras WHERE value='".$_POST['editar']."'");
            $ro=mysqli_fetch_row($sqla);
            if($ro[1]=='SI' && $ro[4]=='CONTADO'){
                if($ro[2]=='SOLES'){
                    $am=$ro[0];
                    $inser5=mysqli_query($con,"UPDATE cajamayor SET contados=(contados-round($am,1)) WHERE fecha='$hoy'");
                }
                else{
                    $am=$ro[0]*$ro[3];
                    $inser5=mysqli_query($con,"UPDATE cajamayor SET contados=(contados-round($am,1)) WHERE fecha='$hoy'");
                }
            }
            $del = mysqli_query($con,"SELECT idproducto,cantidad,entregado FROM compras WHERE value='".$_POST['editar']."'"); 
            while($row = mysqli_fetch_assoc($del)){
                if($row['entregado']=='SI' ){
                    $ins=mysqli_query($con,"UPDATE producto SET stock_real=(stock_real-".$row['cantidad']."),stock_con1=(stock_con1-".$row['cantidad'].") WHERE id='".$row['idproducto']."'");
                }else{
                    $ins=mysqli_query($con,"UPDATE producto SET stock_con1=(stock_con1-".$row['cantidad'].") WHERE id='".$row['idproducto']."'");
                }
            }
            $del1 = mysqli_query($con,"DELETE FROM compras WHERE value='".$_POST['editar']."'");
            $del2 = mysqli_query($con,"DELETE FROM total_compras WHERE value='".$_POST['editar']."'");
            $num=$_POST['editar'];
            $acuenta=$ro[5];
        }
        if(isset($_POST['producto']) && !empty($_POST['producto'])){
            for ($i=0; $i<sizeof($_POST['producto']) ; $i++) {
                $sql= mysqli_query($con,"INSERT INTO compras (serie,numero,value,documento,producto,cantidad,unitario,importe,idproducto,billete,cambio,proveedor,fecha,hora,entregado,usuario) 
                    VALUES ('".$_POST['str'][2]['value']."',
                            '".$_POST['str'][3]['value']."',
                            '".$num."',
                            'FACTURA BOOM',
                            '".$_POST['producto'][$i]."',
                            '".$_POST['cantidad'][$i]."',
                            '".$_POST['unitario'][$i]."',
                            '".$_POST['importe'][$i]."',
                            '".$_POST['id'][$i]."',
                            '".$_POST['str'][8]['value']."',
                            '".$_POST['str'][9]['value']."',
                            '".$_POST['str'][10]['value']."',
                            '".date('Y-m-d', strtotime(str_replace('/', '-', $_POST['str'][6]['value'])))."',
                            NOW(),
                            '".$_POST['str'][12]['value']."',
                            '".$_POST['str'][0]['value']."'
                            )");
                if($_POST['str'][12]['value']=='SI'){
                    if($_POST['str'][8]['value']=='SOLES'){
                        $inse=mysqli_query($con,"UPDATE producto SET stock_real=(stock_real+".$_POST['cantidad'][$i]."),stock_con1=(stock_con1+".$_POST['cantidad'][$i]."),p_compra=(".$_POST['unitario'][$i]."),activo='SI',antiguedad=NOW() WHERE id='".$_POST['id'][$i]."'");
                    }
                    else{
                        $inse=mysqli_query($con,"UPDATE producto SET stock_real=(stock_real+".$_POST['cantidad'][$i]."),stock_con1=(stock_con1+".$_POST['cantidad'][$i]."),p_compra=(".$_POST['unitario'][$i]*$_POST['str'][9]['value']."),activo='SI',antiguedad=NOW() WHERE id='".$_POST['id'][$i]."'");
                    }
                }
                else{
                    $inse=mysqli_query($con,"UPDATE producto SET stock_con1=(stock_con1+".$_POST['cantidad'][$i].") WHERE id='".$_POST['id'][$i]."'");
                }
            }
        }
        $pendiente=$_POST['str'][15]['value']-$acuenta;
        $query= mysqli_query($con,"INSERT INTO total_compras (serie,numero,value,fechafactura,hora,documento,ruc,proveedor,direccion,entregado,subtotal,igv,total,percepcion,montototal,comentario,credito,fechapago,fechaingreso,billete,cambio,pendiente,acuenta,letra,usuario) 
                    VALUES ('".$_POST['str'][2]['value']."',
                            '".$_POST['str'][3]['value']."',
                            '".$num."',
                            '".date('Y-m-d', strtotime(str_replace('/', '-', $_POST['str'][6]['value'])))."',
                            NOW(),
                            'FACTURA BOOM',
                            '".$_POST['str'][7]['value']."',
                            '".$_POST['str'][10]['value']."',
                            '".$_POST['str'][11]['value']."',
                            '".$_POST['str'][12]['value']."',
                            '0.00',
                            '0.00',
                            '".$_POST['str'][13]['value']."',
                            '".$_POST['str'][14]['value']."',
                            '".$_POST['str'][15]['value']."',
                            '".$_POST['str'][16]['value']."',
                            '".$_POST['str'][4]['value']."',
                            '".date('Y-m-d', strtotime(str_replace('/', '-', $_POST['str'][5]['value'])))."',
                            NOW(),
                            '".$_POST['str'][8]['value']."',
                            '".$_POST['str'][9]['value']."',
                            '".$pendiente."',
                            '".$acuenta."',
                            'NO',
                            '".$_POST['str'][0]['value']."'
                            )");
        if($_POST['str'][12]['value']=='SI' && $_POST['str'][4]['value']=='CONTADO'){
            if($_POST['str'][8]['value']=='SOLES'){
                $am=$_POST['str'][15]['value'];
                $inser=mysqli_query($con,"UPDATE cajamayor SET contados=(contados+round($am,1)) WHERE fecha='$hoy'");
            }
            else{
                $am=$_POST['str'][15]['value']*$_POST['str'][8]['value'];
                $inser=mysqli_query($con,"UPDATE cajamayor SET contados=(contados+round($am,1)) WHERE fecha='$hoy'");
            }
        }
	break;
	case 'NOTA DE PEDIDO':
		if ($_POST['editar']==0) {
            $res = mysqli_query($con,"SELECT MAX(numero)+1 FROM total_compras WHERE serie='000'"); 
            $row = mysqli_fetch_row($res);
            $num="000000".$row[0];
            $num=substr($num,-7);
            $ress = mysqli_query($con,"SELECT MAX(value) FROM total_compras"); 
            $roww = mysqli_fetch_row($ress);
            $numm = $roww[0]+1;
            $acuenta=0;
        }
        else{
            $sqla=mysqli_query($con,"SELECT montototal,entregado,billete,cambio,credito,fechaingreso,acuenta,numero FROM total_compras WHERE value='".$_POST['editar']."'");
            $ro=mysqli_fetch_row($sqla);
            $hoy=$ro[5];
            if($ro[4]=='CONTADO'){
                if($ro[2]=='SOLES'){
                    $am=$ro[0];
                    $inser5=mysqli_query($con,"UPDATE cajamayor SET contados=(contados-round($am,1)) WHERE fecha='".$hoy."'");
                }
                else{
                    $am=$ro[0]*$ro[3];
                    $inser5=mysqli_query($con,"UPDATE cajamayor SET contados=(contados-round($am,1)) WHERE fecha='".$hoy."'");
                }
            }
            $del = mysqli_query($con,"SELECT idproducto,cantidad,entregado FROM compras WHERE value='".$_POST['editar']."'"); 
            while($row = mysqli_fetch_assoc($del)){
                if($row['entregado']=='SI' ){
                    $ins=mysqli_query($con,"UPDATE producto SET stock_real=(stock_real-".$row['cantidad']."),activo='SI' WHERE id='".$row['idproducto']."'");
                }
            }
            $del1 = mysqli_query($con,"DELETE FROM compras WHERE value='".$_POST['editar']."'");
            $del2 = mysqli_query($con,"DELETE FROM total_compras WHERE value='".$_POST['editar']."'");
            $num=$ro[7];
            $numm=$_POST['editar'];
            $acuenta=$ro[6];
        }
        if(isset($_POST['producto']) && !empty($_POST['producto'])){
            for ($i=0; $i<sizeof($_POST['producto']) ; $i++) {
                $sql= mysqli_query($con,"INSERT INTO compras (serie,numero,value,documento,producto,cantidad,unitario,importe,idproducto,billete,cambio,proveedor,fecha,hora,entregado,usuario) 
                    VALUES ('000',
                            '".$num."',
                            '".$numm."',
                            'NOTA DE PEDIDO',
                            '".$_POST['producto'][$i]."',
                            '".$_POST['cantidad'][$i]."',
                            '".$_POST['unitario'][$i]."',
                            '".$_POST['importe'][$i]."',
                            '".$_POST['id'][$i]."',
                            '".$_POST['str'][8]['value']."',
                            '".$_POST['str'][9]['value']."',
                            '".$_POST['str'][10]['value']."',
                            '".$hoy."',
                            NOW(),
                            '".$_POST['str'][12]['value']."',
                            '".$_POST['str'][0]['value']."'
                    		)");
                if($_POST['str'][12]['value']=='SI'){
                    if($_POST['str'][8]['value']=='SOLES'){
                        $inse=mysqli_query($con,"UPDATE producto SET stock_real=(stock_real+".$_POST['cantidad'][$i]."),p_compra=(".$_POST['unitario'][$i]."),activo='SI',antiguedad=NOW() WHERE id='".$_POST['id'][$i]."'");
                    }
                    else{
                        $inse=mysqli_query($con,"UPDATE producto SET stock_real=(stock_real+".$_POST['cantidad'][$i]."),p_compra=(".$_POST['unitario'][$i]*$_POST['str'][9]['value']."),activo='SI',antiguedad=NOW() WHERE id='".$_POST['id'][$i]."'");
                    }
                }else{
                    if($_POST['str'][8]['value']=='SOLES'){
                        $inse=mysqli_query($con,"UPDATE producto SET p_compra=(".$_POST['unitario'][$i].") WHERE id='".$_POST['id'][$i]."'");
                    }
                    else{
                        $inse=mysqli_query($con,"UPDATE producto SET p_compra=(".$_POST['unitario'][$i]*$_POST['str'][9]['value'].") WHERE id='".$_POST['id'][$i]."'");
                    }
                }
            }
        }
        $pendiente=$_POST['str'][15]['value']-$acuenta;
        $query= mysqli_query($con,"INSERT INTO total_compras (serie,numero,value,fechafactura,hora,documento,ruc,proveedor,direccion,entregado,subtotal,igv,total,percepcion,montototal,comentario,credito,fechapago,fechaingreso,billete,cambio,pendiente,acuenta,letra,usuario) 
                    VALUES ('000',
                            '".$num."',
                            '".$numm."',
                            '".date('Y-m-d', strtotime(str_replace('/', '-', $_POST['str'][6]['value'])))."',
                            NOW(),
                            'NOTA DE PEDIDO',
                            '".$_POST['str'][7]['value']."',
                            '".$_POST['str'][10]['value']."',
                            '".$_POST['str'][11]['value']."',
                            '".$_POST['str'][12]['value']."',
                            '0.00',
                            '0.00',
                            '".$_POST['str'][13]['value']."',
                            '".$_POST['str'][14]['value']."',
                            '".$_POST['str'][15]['value']."',
                            '".$_POST['str'][16]['value']."',
                            '".$_POST['str'][4]['value']."',
                            '".date('Y-m-d', strtotime(str_replace('/', '-', $_POST['str'][5]['value'])))."',
                            '".$hoy."',
                            '".$_POST['str'][8]['value']."',
                            '".$_POST['str'][9]['value']."',
                            '".$pendiente."',
                            '".$acuenta."',
                            'NO',
                            '".$_POST['str'][0]['value']."'
                            )");
        
        if($_POST['str'][4]['value']=='CONTADO'){
            if($_POST['str'][8]['value']=='SOLES'){
                $am=$_POST['str'][15]['value'];
                $inser=mysqli_query($con,"UPDATE cajamayor SET contados=(contados+round($am,1)) WHERE fecha='".$hoy."'");
            }
            else{
                $am=$_POST['str'][15]['value']*$_POST['str'][9]['value'];
                $inser=mysqli_query($con,"UPDATE cajamayor SET contados=(contados+round($am,1)) WHERE fecha='".$hoy."'");
            }
        }
    break;
        }
	}

?>