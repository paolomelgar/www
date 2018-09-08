<?php 
session_start();
require_once('../connection.php');
if(isset($_POST['accion']) && !empty($_POST['accion'])){
    switch ($_POST['accion']) {
        case 'add':
            if($_FILES['imagen']['tmp_name']!=''){
                $sql1= mysqli_query($con,"INSERT INTO marca (marca,activo,foto) VALUES ('".$_POST['marca']."','".$_POST['activo1']."','SI')");
            }
            else{
                $sql1= mysqli_query($con,"INSERT INTO marca (marca,activo,foto) VALUES ('".$_POST['marca']."','".$_POST['activo1']."','NO')");
            }
            $q=mysqli_query($con,"SELECT MAX(id) FROM marca");
            $ro=mysqli_fetch_row($q);
            move_uploaded_file($_FILES['imagen']['tmp_name'], realpath("../fotos/marca ")."/a".$ro[0].".jpg");
    	break;

        ///////////////////////////////////////////////////////////////////////////////////

    	case 'edit':
            if($_FILES['imagen']['tmp_name']!=''){
                $sql1= mysqli_query($con,"UPDATE marca SET marca='".$_POST['marca']."', activo='".$_POST['activo1']."', foto='SI' WHERE id='".$_POST['id']."'");
            }
            else{
                $sql1= mysqli_query($con,"UPDATE marca SET marca='".$_POST['marca']."', activo='".$_POST['activo1']."' WHERE id='".$_POST['id']."'");
            }
            move_uploaded_file($_FILES['imagen']['tmp_name'], realpath("../fotos/marca ")."/a".$_POST['id'].".jpg");
   		break;

        ///////////////////////////////////////////////////////////////////////////////////

    	case 'del':
            $sql12= mysqli_query($con,"UPDATE marca SET activo='ANULADO' WHERE id='".$_POST['id']."'");
            $b=mysqli_query($con,"SELECT marca FROM marca WHERE id_cliente='".$_POST['id']."'");
            $row = mysqli_fetch_row($b);
            $a=mysqli_query($con,"INSERT INTO alerta (tipo,concepto,usuario,fecha,hora,estado) VALUES ('MARCA','SE ANULO LA MARCA ".$row[0]."','".$_SESSION['nombre']."',NOW(),NOW(),'SI')");
		break;
    }
}
?>