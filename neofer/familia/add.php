<?php 
session_start();
require_once('../connection.php');
if(isset($_POST['accion']) && !empty($_POST['accion'])){
    switch ($_POST['accion']) {
        case 'add':
            if($_FILES['imagen']['tmp_name']!=''){
                $sql1= mysqli_query($con,"INSERT INTO familia (familia,activo,foto) VALUES ('".$_POST['familia']."','".$_POST['activo1']."','SI')");
            }
            else{
                $sql1= mysqli_query($con,"INSERT INTO familia (familia,activo,foto) VALUES ('".$_POST['familia']."','".$_POST['activo1']."','NO')");
            }
            $q=mysqli_query($con,"SELECT MAX(id) FROM familia");
            $ro=mysqli_fetch_row($q);
            move_uploaded_file($_FILES['imagen']['tmp_name'], realpath("../fotos/familia ")."/a".$ro[0].".jpg");
        break;
        ///////////////////////////////////////////////////////////////////////////////////
        case 'edit':
            if($_FILES['imagen']['tmp_name']!=''){
                $sql1= mysqli_query($con,"UPDATE familia SET familia='".$_POST['familia']."', activo='".$_POST['activo1']."', foto='SI' WHERE id='".$_POST['id']."'");
            }
            else{
                $sql1= mysqli_query($con,"UPDATE familia SET familia='".$_POST['familia']."', activo='".$_POST['activo1']."' WHERE id='".$_POST['id']."'");
            }
            move_uploaded_file($_FILES['imagen']['tmp_name'], realpath("../fotos/familia ")."/a".$_POST['id'].".jpg");
        break;
        ///////////////////////////////////////////////////////////////////////////////////
        case 'del':
            $sql12= mysqli_query($con,"UPDATE familia SET activo='ANULADO' WHERE id='".$_POST['id']."'");
            $b=mysqli_query($con,"SELECT familia FROM familia WHERE id_cliente='".$_POST['id']."'");
            $row = mysqli_fetch_row($b);
            $a=mysqli_query($con,"INSERT INTO alerta (tipo,concepto,usuario,fecha,hora,estado) VALUES ('CATEGORIA','SE ANULO LA CATEGORIA ".$row[0]."','".$_SESSION['nombre']."',NOW(),NOW(),'SI')");
        break;
    }
}
?>