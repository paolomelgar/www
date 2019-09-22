<?php 
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
            $sqll = mysqli_query($con,"SELECT * FROM marca WHERE foto='SI' AND id='".$_POST['id']."'");
            if(mysqli_num_rows($sqll)>0){
                unlink("../fotos/marca"."/a".$_POST['id'].".jpg");
            }
            $sql12= mysqli_query($con,"DELETE FROM marca WHERE id='".$_POST['id']."'");
		break;
    }
}
?>