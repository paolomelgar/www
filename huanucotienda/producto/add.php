<?php 
session_start();
require_once('../connection.php');
date_default_timezone_set("America/Lima");
if(isset($_POST['accion']) && !empty($_POST['accion'])){
    switch ($_POST['accion']) {
        case 'add':
            if($_FILES['imagen']['tmp_name']!=''){
                $sql1= mysqli_query($con,"INSERT INTO producto (producto,marca,familia,cant_caja,activo,stock_real,stock_con,proveedor,porcentaje,p_promotor,p_especial,p_compra,foto,stock_con1,fecha) 
                    VALUES ('".$_POST['producto']."','".$_POST['marca']."','".$_POST['familia']."','0','".$_POST['activo1']."','0','0','".$_POST['proveedor']."','0','0','0','0',NOW(),'0',NOW())");
            }
            else{
                $sql1= mysqli_query($con,"INSERT INTO producto (producto,marca,familia,cant_caja,activo,stock_real,stock_con,proveedor,porcentaje,p_promotor,p_especial,p_compra,foto,stock_con1,fecha) 
                    VALUES ('".$_POST['producto']."','".$_POST['marca']."','".$_POST['familia']."','0','".$_POST['activo1']."','0','0','".$_POST['proveedor']."','0','0','0','0','NO','0',NOW())");
            }
            $q=mysqli_query($con,"SELECT MAX(id) FROM producto");
            $ro=mysqli_fetch_row($q);
            move_uploaded_file($_FILES['imagen']['tmp_name'], realpath("../fotos/producto ")."/a".$ro[0].".jpg");
            
    		break;

        ///////////////////////////////////////////////////////////////////////////////////

    	case 'edit':
            if($_FILES['imagen']['tmp_name']!=''){
        		$sql1= mysqli_query($con,"UPDATE producto SET producto='".$_POST['producto']."', marca='".$_POST['marca']."', familia='".$_POST['familia']."', proveedor='".$_POST['proveedor']."',
        							activo='".$_POST['activo1']."', foto=NOW() WHERE id='".$_POST['id']."'");
            }
            else{
                $sql1= mysqli_query($con,"UPDATE producto SET producto='".$_POST['producto']."', marca='".$_POST['marca']."', familia='".$_POST['familia']."', proveedor='".$_POST['proveedor']."',
                                    activo='".$_POST['activo1']."' WHERE id='".$_POST['id']."'");
            }
            move_uploaded_file($_FILES['imagen']['tmp_name'], realpath("../fotos/producto ")."/a".$_POST['id'].".jpg");
    		
    		break;

        ///////////////////////////////////////////////////////////////////////////////////

    	case 'del':
            $sql12= mysqli_query($con,"UPDATE producto SET activo='ANULADO' WHERE id='".$_POST['id']."'");
            $b=mysqli_query($con,"SELECT producto FROM producto WHERE id='".$_POST['id']."'");
            $row = mysqli_fetch_row($b);
            $a=mysqli_query($con,"INSERT INTO alerta (tipo,concepto,usuario,fecha,hora,estado) VALUES ('PRODUCTO','SE ANULO EL PRODUCTO ".$row[0]."','".$_SESSION['nombre']."',NOW(),NOW(),'SI')");
    		break;
    }
}
?>