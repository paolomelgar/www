<?php 
require_once('../connection.php');
if(isset($_POST['accion']) && !empty($_POST['accion'])){
    switch ($_POST['accion']) {
        case 'add':
            if($_FILES['imagen']['tmp_name']!=''){
                $sql1= mysqli_query($con,"INSERT INTO producto (producto,marca,familia,cant_caja,activo,stock_real,stock_con,p_mayor,p_promotor,p_especial,p_compra,foto) 
                    VALUES ('".$_POST['producto']."','".$_POST['marca']."','".$_POST['familia']."','0','".$_POST['activo1']."','0','0','0','0','0','0','SI')");
            }
            else{
               $sql1= mysqli_query($con,"INSERT INTO producto (producto,marca,familia,cant_caja,activo,stock_real,stock_con,p_mayor,p_promotor,p_especial,p_compra,foto) 
                    VALUES ('".$_POST['producto']."','".$_POST['marca']."','".$_POST['familia']."','0','".$_POST['activo1']."','0','0','0','0','0','0','NO')");
            }
            $q=mysqli_query($con,"SELECT MAX(id) FROM producto");
            $ro=mysqli_fetch_row($q);
            move_uploaded_file($_FILES['imagen']['tmp_name'], realpath("../fotos/producto ")."/a".$ro[0].".jpg");
            break;

        ///////////////////////////////////////////////////////////////////////////////////

    	case 'edit':
            if($_FILES['imagen']['tmp_name']!=''){
        		$sql1= mysqli_query($con,"UPDATE producto SET producto='".$_POST['producto']."', marca='".$_POST['marca']."', familia='".$_POST['familia']."', 
        							activo='".$_POST['activo1']."', foto='SI' WHERE id='".$_POST['id']."'");
            }
            else{
                $sql1= mysqli_query($con,"UPDATE producto SET producto='".$_POST['producto']."', marca='".$_POST['marca']."', familia='".$_POST['familia']."', 
                                    activo='".$_POST['activo1']."' WHERE id='".$_POST['id']."'");
            }
            move_uploaded_file($_FILES['imagen']['tmp_name'], realpath("../fotos/producto ")."/a".$_POST['id'].".jpg");
    		
    		break;

        ///////////////////////////////////////////////////////////////////////////////////

    	case 'del':
            $sql1 = mysqli_query($con,"SELECT * FROM producto WHERE foto='SI' AND id='".$_POST['id']."'");
            if(mysqli_num_rows($sql1)>0){
                unlink("../fotos/producto"."/a".$_POST['id'].".jpg");
            }
    		$sql12= mysqli_query($con,"DELETE FROM producto WHERE id='".$_POST['id']."'");
    		echo $_POST['id'];
    		break;
    }
}
?>