<?php 
session_start();
$con1 =  mysqli_connect('localhost','root','','huanuco');
  mysqli_query ($con1,"SET NAMES 'utf8'");
  /*$con2 =  mysqli_connect('localhost','root','','huanucotienda');
  mysqli_query ($con2,"SET NAMES 'utf8'");*/
date_default_timezone_set("America/Lima");
if(isset($_POST['accion']) && !empty($_POST['accion'])){
    switch ($_POST['accion']) {
        case 'add':
        $sq=mysqli_fetch_row(mysqli_query($con1,"SELECT MAX(codigo)+1 FROM producto"));
            if($_FILES['imagen']['tmp_name']!=''){
                $sql1= mysqli_query($con1,"INSERT INTO producto (codigo,producto,marca,familia,cant_caja,activo,stock_real,stock_con,proveedor,porcentaje,p_promotor,p_especial,p_compra,foto,fran,fecha,antiguedad) 
                    VALUES ('".$sq[0]."','".$_POST['producto']."','".$_POST['marca']."','".$_POST['familia']."','0','".$_POST['activo1']."','0','0','".$_POST['proveedor']."','0','0','0','0',NOW(),'0',NOW(),NOW())");
                //$sql2= mysqli_query($con2,"INSERT INTO producto (codigo,producto,marca,familia,cant_caja,activo,stock_real,stock_con,proveedor,porcentaje,p_promotor,p_especial,p_compra,foto,stock_con1,fecha) 
                    //VALUES ('".$_POST['producto']."','".$_POST['producto']."','".$_POST['marca']."','".$_POST['familia']."','0','".$_POST['activo1']."','0','0','".$_POST['proveedor']."','0','0','0','0',NOW(),'0',NOW())");
            }
            else{
                $sql1= mysqli_query($con1,"INSERT INTO producto (codigo,producto,marca,familia,cant_caja,activo,stock_real,stock_con,proveedor,porcentaje,p_promotor,p_especial,p_compra,foto,fran,fecha,antiguedad) 
                    VALUES ('".$sq[0]."','".$_POST['producto']."','".$_POST['marca']."','".$_POST['familia']."','0','".$_POST['activo1']."','0','0','".$_POST['proveedor']."','0','0','0','0','NO','0',NOW(),NOW())");
                //$sql2= mysqli_query($con2,"INSERT INTO producto (producto,marca,familia,cant_caja,activo,stock_real,stock_con,proveedor,porcentaje,p_promotor,p_especial,p_compra,foto,stock_con1,fecha) 
                    //VALUES ('".$_POST['producto']."','".$_POST['marca']."','".$_POST['familia']."','0','".$_POST['activo1']."','0','0','".$_POST['proveedor']."','0','0','0','0','NO','0',NOW())");
            }
            move_uploaded_file($_FILES['imagen']['tmp_name'], realpath("../fotos/producto ")."/a".$sq[0].".jpg");
            
    		break;

        ///////////////////////////////////////////////////////////////////////////////////

    	case 'edit':
            if($_FILES['imagen']['tmp_name']!=''){
        		$sql1= mysqli_query($con1,"UPDATE producto SET producto='".$_POST['producto']."', marca='".$_POST['marca']."', familia='".$_POST['familia']."', proveedor='".$_POST['proveedor']."',activo='".$_POST['activo1']."', foto=NOW() WHERE codigo='".$_POST['codigo']."'");
                //$sql2= mysqli_query($con2,"UPDATE producto SET producto='".$_POST['producto']."', marca='".$_POST['marca']."', familia='".$_POST['familia']."', proveedor='".$_POST['proveedor']."',activo='".$_POST['activo1']."', foto=NOW() WHERE id='".$_POST['id']."'");
            }
            else{
                $sql1= mysqli_query($con1,"UPDATE producto SET producto='".$_POST['producto']."', marca='".$_POST['marca']."', familia='".$_POST['familia']."', proveedor='".$_POST['proveedor']."',activo='".$_POST['activo1']."' WHERE codigo='".$_POST['codigo']."'");
                //$sql2= mysqli_query($con2,"UPDATE producto SET producto='".$_POST['producto']."', marca='".$_POST['marca']."', familia='".$_POST['familia']."', proveedor='".$_POST['proveedor']."',activo='".$_POST['activo1']."' WHERE id='".$_POST['id']."'");
            }
            move_uploaded_file($_FILES['imagen']['tmp_name'], realpath("../fotos/producto ")."/a".$_POST['codigo'].".jpg");
    		break;

        ///////////////////////////////////////////////////////////////////////////////////

    	case 'del':
            $sql1= mysqli_query($con1,"UPDATE producto SET activo='ANULADO' WHERE codigo='".$_POST['codigo']."'");
            //$sql2= mysqli_query($con2,"UPDATE producto SET activo='ANULADO' WHERE id='".$_POST['id']."'");
            $b=mysqli_query($con1,"SELECT producto FROM producto WHERE codigo='".$_POST['codigo']."'");
            $row = mysqli_fetch_row($b);
            $a=mysqli_query($con,"INSERT INTO alerta (tipo,concepto,usuario,fecha,hora,estado) VALUES ('PRODUCTO','SE ANULO EL PRODUCTO ".$row[0]."','".$_SESSION['nombre']."',NOW(),NOW(),'SI')");
    		break;
    }
}
?>