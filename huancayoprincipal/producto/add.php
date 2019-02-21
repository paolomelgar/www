<?php 
require_once('../connection.php');
$con2 =  mysqli_connect('localhost','root','','innovaprincipal');
  mysqli_query ($con2,"SET NAMES 'utf8'");
if(isset($_POST['accion']) && !empty($_POST['accion'])){
    switch ($_POST['accion']) {
        case 'add':
            $sq=mysqli_fetch_row(mysqli_query($con,"SELECT MAX(codigo)+1 FROM producto"));
            $s=mysqli_query($con,"UPDATE producto SET codigo='".$sq[0]."' WHERE id='".$row['id']."'");
            if($_FILES['imagen']['tmp_name']!=''){
                $sql1= mysqli_query($con,"INSERT INTO producto (codigo,producto,marca,familia,cant_caja,caja_master,activo,stock_real,stock_con,p_compra,foto,stock_con1,fecha) 
                    VALUES ('".$sq[0]."','".$_POST['producto']."','".$_POST['marca']."','".$_POST['familia']."','0','0','".$_POST['activo1']."','0','0','0',NOW(),'0',NOW())");
                $sql2= mysqli_query($con2,"INSERT INTO producto (codigo,producto,marca,familia,cant_caja,activo,stock_real,stock_con,p_compra,foto,fecha) 
                    VALUES ('".$sq[0]."','".$_POST['producto']."','".$_POST['marca']."','".$_POST['familia']."','0','".$_POST['activo1']."','0','0','0',NOW(),NOW())");
            }
            else{
               $sql1= mysqli_query($con,"INSERT INTO producto (codigo,producto,marca,familia,cant_caja,caja_master,activo,stock_real,stock_con,p_compra,foto,stock_con1,fecha) 
                    VALUES ('".$sq[0]."','".$_POST['producto']."','".$_POST['marca']."','".$_POST['familia']."','0','0','".$_POST['activo1']."','0','0','0','NO','0',NOW())");
               $sql2= mysqli_query($con2,"INSERT INTO producto (codigo,producto,marca,familia,cant_caja,activo,stock_real,stock_con,p_compra,foto,fecha) 
                    VALUES ('".$sq[0]."','".$_POST['producto']."','".$_POST['marca']."','".$_POST['familia']."','0','".$_POST['activo1']."','0','0','0','NO',NOW())");
            }
            move_uploaded_file($_FILES['imagen']['tmp_name'], realpath("../fotos/producto ")."/a".$sq[0].".jpg");
            break;

        ///////////////////////////////////////////////////////////////////////////////////

    	case 'edit':
            if($_FILES['imagen']['tmp_name']!=''){
        		$sql1= mysqli_query($con,"UPDATE producto SET producto='".$_POST['producto']."', marca='".$_POST['marca']."', familia='".$_POST['familia']."', activo='".$_POST['activo1']."', foto=NOW() WHERE codigo='".$_POST['codigo']."'");
                $sql2= mysqli_query($con2,"UPDATE producto SET producto='".$_POST['producto']."', marca='".$_POST['marca']."', familia='".$_POST['familia']."', activo='".$_POST['activo1']."', foto=NOW() WHERE codigo='".$_POST['codigo']."'");
            }
            else{
                $sql1= mysqli_query($con,"UPDATE producto SET producto='".$_POST['producto']."', marca='".$_POST['marca']."', familia='".$_POST['familia']."', activo='".$_POST['activo1']."' WHERE codigo='".$_POST['codigo']."'");
                $sql2= mysqli_query($con2,"UPDATE producto SET producto='".$_POST['producto']."', marca='".$_POST['marca']."', familia='".$_POST['familia']."', activo='".$_POST['activo1']."' WHERE codigo='".$_POST['codigo']."'");
            }
            move_uploaded_file($_FILES['imagen']['tmp_name'], realpath("../fotos/producto ")."/a".$_POST['codigo'].".jpg");
    		
    		break;

        ///////////////////////////////////////////////////////////////////////////////////

    	case 'del':
            $sql1 = mysqli_query($con,"SELECT * FROM producto WHERE foto!='NO' AND id='".$_POST['id']."'");
            if(mysqli_num_rows($sql1)>0){
                unlink("../fotos/producto"."/a".$_POST['codigo'].".jpg");
            }
    		$sql12= mysqli_query($con,"DELETE FROM producto WHERE codigo='".$_POST['codigo']."'");
    		echo $_POST['codigo'];
    		break;
    }
}
?>